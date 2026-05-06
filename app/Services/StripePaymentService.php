<?php

namespace App\Services;

use App\Models\Setting;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;
use Stripe\Exception;

class StripePaymentService
{
    private $secretKey;
    private $webhookSecret;
    private $enabled;

    public function __construct()
    {
        $this->enabled = Setting::get('stripe_enabled') === '1';
        $this->secretKey = Setting::get('stripe_secret');
        $this->webhookSecret = Setting::get('stripe_webhook_secret');
        
        if ($this->enabled && $this->secretKey) {
            Stripe::setApiKey($this->secretKey);
        }
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getPublishableKey(): string
    {
        return Setting::get('stripe_key') ?? '';
    }

    public function createPaymentIntent(int $amountInCents, string $currency = 'cad'): ?array
    {
        if (!$this->enabled || !$this->secretKey) {
            return null;
        }

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => $currency,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return [
                'client_secret' => $paymentIntent->client_secret,
                'id' => $paymentIntent->id,
            ];
        } catch (Exception $e) {
            logger('Stripe PaymentIntent Error: ' . $e->getMessage());
            return null;
        }
    }

    public function retrievePaymentIntent(string $paymentIntentId): ?array
    {
        if (!$this->enabled || !$this->secretKey) {
            return null;
        }

        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            return [
                'id' => $paymentIntent->id,
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
            ];
        } catch (Exception $e) {
            logger('Stripe retrieve Error: ' . $e->getMessage());
            return null;
        }
    }

    public function handleWebhook(string $payload, string $signature): ?array
    {
        if (!$this->enabled || !$this->webhookSecret) {
            return null;
        }

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $this->webhookSecret
            );
            return $event->toArray();
        } catch (Exception $e) {
            logger('Stripe Webhook Error: ' . $e->getMessage());
            return null;
        }
    }
}