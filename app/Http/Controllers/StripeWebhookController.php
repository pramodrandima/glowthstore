<?php

namespace App\Http\Controllers;

use App\Services\Stripe\StripeWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, StripeWebhookService $stripeWebhookService): JsonResponse
    {
        $signature = (string) $request->header('Stripe-Signature');

        try {
            $stripeWebhookService->handle($request->getContent(), $signature);
        } catch (UnexpectedValueException|SignatureVerificationException $exception) {
            return response()->json(['message' => 'Invalid webhook signature.'], 400);
        }

        return response()->json(['received' => true]);
    }
}
