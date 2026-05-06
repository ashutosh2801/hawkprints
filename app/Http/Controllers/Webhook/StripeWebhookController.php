<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $stripeService = new StripePaymentService();
        
        if (!$stripeService->isEnabled()) {
            return response()->json(['received' => true]);
        }

        $payload = $request->getContent();
        $signature = $request->header('stripe-signature');

        if (!$signature) {
            Log::warning('Stripe webhook received without signature');
            return response()->json(['received' => true]);
        }

        $event = $stripeService->handleWebhook($payload, $signature);
        
        if (!$event) {
            Log::warning('Stripe webhook signature verification failed');
            return response()->json(['received' => true]);
        }

        $eventType = $event['type'] ?? '';
        
        switch ($eventType) {
            case 'payment_intent.succeeded':
                $this->handlePaymentSuccess($event['data']['object']);
                break;
            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($event['data']['object']);
                break;
            default:
                Log::info('Stripe webhook received: ' . $eventType);
                break;
        }

        return response()->json(['received' => true]);
    }

    private function handlePaymentSuccess(array $paymentIntent)
    {
        $paymentIntentId = $paymentIntent['id'] ?? null;
        
        if ($paymentIntentId) {
            Order::where('payment_intent_id', $paymentIntentId)->update([
                'status' => 'processing',
                'payment_status' => 'paid',
            ]);
        }
    }

    private function handlePaymentFailed(array $paymentIntent)
    {
        $paymentIntentId = $paymentIntent['id'] ?? null;
        
        if ($paymentIntentId) {
            Order::where('payment_intent_id', $paymentIntentId)->update([
                'payment_status' => 'failed',
            ]);
        }
    }
}