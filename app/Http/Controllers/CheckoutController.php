<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Product;
use App\Services\Stripe\StripeCheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $request, Product $product, StripeCheckoutService $stripeCheckoutService): RedirectResponse
    {
        $user = $request->user();

        abort_if($product->status->value !== 'published', 404);

        $order = Order::query()->create([
            'user_id' => $user->id,
            'status' => OrderStatus::PENDING->value,
            'total_usd' => $product->price_usd,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'price_usd' => $product->price_usd,
        ]);

        $payment = $order->payments()->create([
            'amount_usd' => $product->price_usd,
            'status' => PaymentStatus::PENDING->value,
        ]);

        $session = $stripeCheckoutService->createSession($order, $product, $user);

        $payment->update([
            'stripe_checkout_session_id' => $session->id,
            'payload' => json_decode(json_encode($session), true),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        $order->load('items.product.files');

        return view('store.purchase-success', compact('order'));
    }
}
