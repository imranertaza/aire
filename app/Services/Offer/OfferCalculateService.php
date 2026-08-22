<?php

namespace App\Services\Offer;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OfferCalculateService
{
    /**
     * Fetch active offers matching current timestamp.
     */
    public function getActiveOffers()
    {
        if (!Schema::hasTable('offers')) {
            return [];
        }

        $todayDate = date('Y-m-d H:i:s');
        $query = DB::table('offers')
            ->where('expire_date', '>=', $todayDate);

        if (Schema::hasColumn('offers', 'start_date')) {
            $query->where('start_date', '<=', $todayDate);
        }

        if (Schema::hasColumn('offers', 'status')) {
            $query->where('status', 1);
        }

        return $query->get();
    }

    /**
     * Compute total promotional offer discount for cart and shipping.
     */
    public function calculateOfferDiscount(array $cart, float $shipAmount = 0.00, int $geoZoneId = 0): array
    {
        $discountAmount = 0.00;
        $discountShipping = 0.00;

        $offers = $this->getActiveOffers();
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        foreach ($offers as $offer) {
            $minAmount = $offer->on_amount ?? $offer->min_amount ?? 0;
            if ($minAmount > 0 && $subtotal < $minAmount) {
                continue;
            }

            $amountVal = $offer->amount ?? $offer->discount_value ?? 0;

            if (!empty($offer->discount_percent)) {
                $discountAmount += $subtotal * ($amountVal / 100);
            } else if (!empty($offer->discount_amount)) {
                $discountAmount += (float) $amountVal;
            }

            if (!empty($offer->free_shipping) || (isset($offer->discount_on) && $offer->discount_on == 3)) {
                $discountShipping = $shipAmount;
            }
        }

        return [
            'discount_product_amount'  => min($discountAmount, $subtotal),
            'discount_shipping_amount' => min($discountShipping, $shipAmount),
            'total_offer_discount'     => min($discountAmount + $discountShipping, $subtotal + $shipAmount),
        ];
    }
}
