<?php

namespace App\Services\Stripe;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeCheckoutService
{
    public function createSession(Order $order, Product $product, User $user): Session
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        return Session::create([
            'mode' => 'payment',
            'customer_email' => $user->email,
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => (int) round($product->price_usd * 100),
                    'product_data' => [
                        'name' => $product->title,
                        'description' => $product->short_description ?: $product->title,
                    ],
                ],
            ]],
            'metadata' => [
                'order_id' => (string) $order->id,
                'user_id' => (string) $user->id,
                'product_id' => (string) $product->id,
            ],
            'success_url' => route('purchase.success', $order).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('product.show', $product->slug),
        ]);
    }
}
