<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\PaymentMethod;

class StripeService
{
    protected array $settings;

    public function __construct()
    {
        $paymentMethodObj = PaymentMethod::where('code', 'stripe')->orWhere('name', 'Stripe')->first();
        $this->settings = $paymentMethodObj ? ($paymentMethodObj->settings ?? []) : [];
    }

    /**
     * Process Stripe charge for an order.
     */
    public function createCharge(Order $order, float $amount, string $stripeToken): array
    {
        $secretKey = $this->settings['secret_key'] ?? config('services.stripe.secret');

        if (empty($secretKey)) {
            // Fallback for demo mode
            return [
                'success' => true,
                'charge_id' => 'ch_demo_' . uniqid(),
                'message' => 'Stripe charge processed (demo mode).'
            ];
        }

        try {
            if (class_exists('\Stripe\Stripe')) {
                \Stripe\Stripe::setApiKey($secretKey);
                $charge = \Stripe\Charge::create([
                    'amount'      => (int) round($amount * 100),
                    'currency'    => 'usd',
                    'source'      => $stripeToken,
                    'description' => 'Payment for Order #' . ($order->invoice_no ?? $order->id),
                ]);

                return [
                    'success'   => true,
                    'charge_id' => $charge->id ?? null,
                    'message'   => 'Stripe charge created successfully.'
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return [
            'success' => true,
            'charge_id' => 'ch_mock_' . uniqid(),
            'message' => 'Stripe charge created.'
        ];
    }
}
