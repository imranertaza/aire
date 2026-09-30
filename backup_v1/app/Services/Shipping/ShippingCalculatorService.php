<?php

namespace App\Services\Shipping;

use App\Models\ShippingMethod;
use App\Models\ShippingSetting;
use App\Services\Offer\OfferCalculateService;
use Illuminate\Support\Collection;

class ShippingCalculatorService
{
    public function __construct(
        protected ZoneRateShippingService $zoneRateService,
        protected ZoneShippingService $zoneService,
        protected FlatShippingService $flatService,
        protected WeightShippingService $weightService,
        protected OfferCalculateService $offerService
    ) {}

    /**
     * Calculate shipping charge for a given shipping method code and location.
     */
    public function calculateCharge(
        string $methodCode,
        bool $isFreeDelivery = false,
        ?string $city = null,
        ?int $countryId = null
    ): float {
        if ($isFreeDelivery) {
            return 0.00;
        }

        $code = strtolower(trim($methodCode));

        return match ($code) {
            'flat'      => (float) $this->flatService->getSettings()->calculateShipping(),
            'zone'      => (float) $this->zoneService->getSettings()->calculateShipping($city),
            'weight'    => (float) $this->weightService->getSettings()->calculateShipping(),
            'zone_rate' => (float) $this->zoneRateService->getSettings($city, $countryId)->calculateShipping(),
            default     => $this->getFallbackCost($code),
        };
    }

    /**
     * Get all active shipping methods with their calculated costs.
     */
    public function getAvailableMethods(bool $isFreeDelivery = false, ?string $city = null, ?int $countryId = 223): Collection
    {
        return ShippingMethod::where('status', 1)->get()->map(function ($method) use ($isFreeDelivery, $city, $countryId) {
            if ($isFreeDelivery) {
                $method->cost = 0.00;
                $method->description = 'Free Delivery applied on your order.';
                return $method;
            }

            switch ($method->code) {
                case 'zone_rate':
                    $method->cost = $this->zoneRateService->getSettings($city, $countryId)->calculateShipping();
                    $method->description = 'Zone Rate delivery calculated based on weight, item count, or location price.';
                    break;
                case 'zone':
                    $method->cost = $this->zoneService->getSettings()->calculateShipping($city);
                    $method->description = 'Zone Based Shipping (Inside Dhaka vs Outside Dhaka).';
                    break;
                case 'flat':
                    $method->cost = $this->flatService->getSettings()->calculateShipping();
                    $method->description = 'Flat Rate Shipping for standard delivery.';
                    break;
                case 'weight':
                    $method->cost = $this->weightService->getSettings()->calculateShipping();
                    $method->description = 'Weight Based Shipping for item packages.';
                    break;
                default:
                    $setting = ShippingSetting::where('shipping_method_id', $method->id)->first();
                    $method->cost = $setting ? (float) $setting->value : 0.00;
                    $method->description = 'Standard shipping delivery service.';
                    break;
            }

            return $method;
        });
    }

    /**
     * Compute full shipping rate and promo calculation for AJAX checkout queries.
     */
    public function calculateRateSummary(
        array $cart,
        string $paymethod,
        bool $isFreeDelivery,
        ?string $cityId = null,
        ?int $countryId = null,
        float $couponDiscount = 0.00
    ): array {
        $charge = $this->calculateCharge($paymethod, $isFreeDelivery, $cityId, $countryId);
        $subtotal = collect($cart)->sum(fn($i) => ($i['price'] ?? 0) * ($i['quantity'] ?? 1));

        $geoZoneId = $this->zoneRateService->getGeoZoneId($countryId, $cityId);
        $offerResult = $this->offerService->calculateOfferDiscount($cart, $charge, $geoZoneId);

        $totalDiscount = $couponDiscount + ($offerResult['total_offer_discount'] ?? 0);
        $grandTotal = max(0, $subtotal + $charge - $totalDiscount);

        return [
            'charge'             => $charge,
            'formatted_charge'   => $charge > 0 ? '$' . number_format($charge, 2) : 'Free',
            'discount'           => $totalDiscount,
            'formatted_discount' => '$' . number_format($totalDiscount, 2),
            'subtotal'           => $subtotal,
            'formatted_subtotal' => '$' . number_format($subtotal, 2),
            'grand_total'        => $grandTotal,
            'formatted_total'    => '$' . number_format($grandTotal, 2),
        ];
    }

    /**
     * Fallback cost calculation from database.
     */
    protected function getFallbackCost(string $code): float
    {
        $shippingMethod = ShippingMethod::where('code', $code)
            ->orWhere('name', 'like', '%' . $code . '%')
            ->first();

        return $shippingMethod ? (float) $shippingMethod->cost : 0.00;
    }
}
