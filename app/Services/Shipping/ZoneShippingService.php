<?php

namespace App\Services\Shipping;

use App\Models\ShippingMethod;
use App\Models\ShippingSetting;
use App\Models\Zone;

class ZoneShippingService
{
    private $inDhakaPrice = 60.00;
    private $outDhakaPrice = 120.00;

    public function getSettings()
    {
        $shippingMethod = ShippingMethod::where('code', 'zone')->first();
        $methodId = $shippingMethod ? $shippingMethod->id : null;

        if ($methodId) {
            $inDhaka = ShippingSetting::where('shipping_method_id', $methodId)->where('label', 'in_dhaka')->first();
            $outDhaka = ShippingSetting::where('shipping_method_id', $methodId)->where('label', 'out_dhaka')->first();

            if ($inDhaka && (float)$inDhaka->value > 0) {
                $this->inDhakaPrice = (float) $inDhaka->value;
            }
            if ($outDhaka && (float)$outDhaka->value > 0) {
                $this->outDhakaPrice = (float) $outDhaka->value;
            }
        }

        return $this;
    }

    /**
     * Calculate Zone Based Shipping (Inside Dhaka vs Outside Dhaka matching cCart reference).
     */
    public function calculateShipping($cityId = null): float
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return 0.00;
        }

        if (empty($cityId)) {
            return (float) $this->outDhakaPrice;
        }

        $zoneObj = Zone::where('id', $cityId)->orWhere('name', $cityId)->first();
        $cityName = $zoneObj ? strtolower($zoneObj->name) : strtolower((string)$cityId);

        // Check if city/district is Dhaka (Inside Dhaka vs Outside Dhaka - cCart Reference)
        if ($cityId == 322 || str_contains($cityName, 'dhaka')) {
            return (float) $this->inDhakaPrice;
        }

        return (float) $this->outDhakaPrice;
    }
}
