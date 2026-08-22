<?php

namespace App\Services\Shipping;

use App\Models\ShippingMethod;
use App\Models\ShippingSetting;

class FlatShippingService
{
    private $flatRate = 0.00;

    public function getSettings()
    {
        $shippingMethod = ShippingMethod::where('code', 'flat')->first();
        $methodId = $shippingMethod ? $shippingMethod->id : null;

        if ($methodId) {
            $setting = ShippingSetting::where('shipping_method_id', $methodId)
                ->where('label', 'flat_rate_price')
                ->first();
            $this->flatRate = $setting ? (float)$setting->value : ($shippingMethod->cost ?? 0.00);
        }

        return $this;
    }

    public function calculateShipping(): float
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return 0.00;
        }

        return (float) $this->flatRate;
    }
}
