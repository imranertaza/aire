<?php

namespace App\Services\Shipping;

use App\Models\GeoZoneDetail;
use App\Models\GeoZoneShippingRate;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\ShippingSetting;
use App\Models\Zone;

class ZoneRateShippingService
{
    private $zoneRateMethod = '1';
    private $geoZoneId = 0;

    /**
     * Initialize settings based on selected zone/district ID.
     */
    public function getSettings($zoneId = null, $countryId = null)
    {
        $shippingMethod = ShippingMethod::where('code', 'zone_rate')->orWhere('code', 'zone')->first();
        $methodId = $shippingMethod ? $shippingMethod->id : null;

        if ($methodId) {
            $setting = ShippingSetting::where('shipping_method_id', $methodId)
                ->where('label', 'zone_rate_method')
                ->first();
            if ($setting && !empty($setting->value)) {
                $this->zoneRateMethod = $setting->value; // 1: Weight, 2: Item Count, 3: Price
            }
        }

        if (!empty($zoneId)) {
            if (empty($countryId)) {
                $zoneObj = Zone::where('id', $zoneId)->orWhere('name', $zoneId)->first();
                $countryId = $zoneObj ? $zoneObj->country_id : null;
            }

            $this->geoZoneId = $this->getGeoZoneId($countryId, $zoneId);
        } else {
            $this->geoZoneId = 0;
        }

        return $this;
    }

    /**
     * Calculate shipping charge matching cCart reference.
     */
    public function calculateShipping(): float
    {
        $charge = 0.00;

        if (!empty($this->geoZoneId)) {
            if ($this->zoneRateMethod == '1') {
                $charge = $this->weightRateCalculation($this->geoZoneId);
            } elseif ($this->zoneRateMethod == '2') {
                $charge = $this->itemRateCalculation($this->geoZoneId);
            } elseif ($this->zoneRateMethod == '3') {
                $charge = $this->priceRateCalculation($this->geoZoneId);
            }
        } else {
            $charge = $this->othersRateCalculation(0);
        }

        return (float) $charge;
    }

    private function othersRateCalculation($geoZoneId): float
    {
        if ($this->zoneRateMethod == '1') {
            return $this->weightRateCalculation($geoZoneId);
        } elseif ($this->zoneRateMethod == '2') {
            return $this->itemRateCalculation($geoZoneId);
        } elseif ($this->zoneRateMethod == '3') {
            return $this->priceRateCalculation($geoZoneId);
        }

        return 0.00;
    }

    /**
     * Method 1: Calculate shipping based on total cart weight.
     */
    private function weightRateCalculation($geoZoneId): float
    {
        $charge = 0.00;
        $totalWeight = 0;
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return 0.00;
        }

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            $weight = $product ? ($product->weight ?? 1) : 1;
            $totalWeight += $weight * $item['quantity'];
        }

        $rate = GeoZoneShippingRate::where('geo_zone_id', $geoZoneId)
            ->where('up_to_value', '>=', $totalWeight)
            ->orderBy('up_to_value', 'ASC')
            ->first();

        if ($rate) {
            $charge = $rate->cost;
        }

        return (float) $charge;
    }

    /**
     * Method 2: Calculate shipping based on total item count.
     */
    private function itemRateCalculation($geoZoneId): float
    {
        $charge = 0.00;
        $totalItem = 0;
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return 0.00;
        }

        foreach ($cart as $item) {
            $totalItem += $item['quantity'];
        }

        $rate = GeoZoneShippingRate::where('geo_zone_id', $geoZoneId)
            ->where('up_to_value', '>=', $totalItem)
            ->orderBy('up_to_value', 'ASC')
            ->first();

        if ($rate) {
            $charge = $rate->cost;
        }

        return (float) $charge;
    }

    /**
     * Method 3: Calculate shipping based on total cart price.
     */
    private function priceRateCalculation($geoZoneId): float
    {
        $charge = 0.00;
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return 0.00;
        }

        $totalPrice = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        $rate = GeoZoneShippingRate::where('geo_zone_id', $geoZoneId)
            ->where('up_to_value', '>=', $totalPrice)
            ->orderBy('up_to_value', 'ASC')
            ->first();

        if ($rate) {
            $charge = $rate->cost;
        }

        return (float) $charge;
    }

    /**
     * Resolve Geo Zone ID from country and zone/district ID.
     */
    public function getGeoZoneId($countryId, $zoneId): int
    {
        if (!$countryId && !$zoneId) return 0;

        $zoneObj = Zone::where('id', $zoneId)->orWhere('name', $zoneId)->first();
        $realZoneId = $zoneObj ? $zoneObj->id : (is_numeric($zoneId) ? (int)$zoneId : 0);

        $detail = GeoZoneDetail::where('country_id', $countryId)
            ->where('zone_id', $realZoneId)
            ->first();

        if ($detail) {
            return (int) $detail->geo_zone_id;
        }

        $countryDefault = GeoZoneDetail::where('country_id', $countryId)
            ->where(fn($q) => $q->where('zone_id', 0)->orWhereNull('zone_id'))
            ->first();

        if ($countryDefault) {
            return (int) $countryDefault->geo_zone_id;
        }

        return 0;
    }
}
