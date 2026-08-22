<?php

namespace App\Services\Shipping;

use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WeightShippingService
{
    private array $shippingData = [];

    public function getSettings()
    {
        $shippingMethod = ShippingMethod::where('code', 'weight')->first();
        $methodId = $shippingMethod ? $shippingMethod->id : null;

        if ($methodId && Schema::hasTable('weight_shipping_settings')) {
            $this->shippingData = DB::table('weight_shipping_settings')
                ->where('shipping_method_id', $methodId)
                ->orderBy('label', 'ASC')
                ->get()
                ->toArray();
        }

        return $this;
    }

    public function calculateShipping(): float
    {
        $weight = 0;
        $value = 0.00;
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return 0.00;
        }

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            $pWeight = $product ? ($product->weight ?? 1) : 1;
            $weight += $pWeight * $item['quantity'];
        }

        foreach ($this->shippingData as $ship) {
            if ($ship->label < $weight) {
                $value = (float) $ship->value;
            } else {
                if ($ship->label == 0) {
                    $value = (float) $ship->value;
                }
            }
        }

        return (float) $value;
    }
}
