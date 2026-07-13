<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = Coupon::all();
        $products = Product::all();

        if ($coupons->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Coupons or Products are empty. Skipping.');
            return;
        }

        foreach ($coupons as $coupon) {
            $count = rand(1, min(5, $products->count()));
            $productIds = $products->random($count)->pluck('id');

            $coupon->products()->sync($productIds);
        }
    }
}
