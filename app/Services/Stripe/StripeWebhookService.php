<?php

namespace App\Services\Stripe;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Mail\PurchaseConfirmationMail;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeWebhookService
{
    /**
     * @throws SignatureVerificationException
     * @throws UnexpectedValueException
     */
    public function handle(string $payload, string $signature): void
    {
        $event = Webhook::constructEvent(
            $payload,
            $signature,
            config('services.stripe.webhook_secret')
        );

        if ($event->type === 'checkout.session.completed') {
            $this->handleCheckoutSessionCompleted($event->data->object);
        }
    }

    protected function handleCheckoutSessionCompleted(object $session): void
    {
        $orderId = data_get($session, 'metadata.order_id');

        if (! $orderId) {
            return;
        }

        $order = Order::query()->with('user')->find($orderId);

        if (! $order) {
            return;
        }

        $payment = Payment::query()->firstOrCreate(
            ['order_id' => $order->id],
            ['amount_usd' => $order->total_usd, 'status' => PaymentStatus::PENDING->value]
        );

        $payment->update([
            'stripe_checkout_session_id' => data_get($session, 'id'),
            'stripe_payment_intent_id' => data_get($session, 'payment_intent'),
            'amount_usd' => ((int) data_get($session, 'amount_total', 0)) / 100,
            'status' => PaymentStatus::PAID->value,
            'payload' => json_decode(json_encode($session), true),
        ]);

        if (! $order->isPaid()) {
            $order->update([
                'status' => OrderStatus::PAID->value,
                'paid_at' => now(),
            ]);

            Mail::to($order->user)->send(new PurchaseConfirmationMail($order->fresh('items.product.files')));
        }
    }
}
