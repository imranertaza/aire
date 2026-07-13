<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = Coupon::all();
        $shippingMethods = ShippingMethod::all();

        if ($coupons->isEmpty() || $shippingMethods->isEmpty()) {
            $this->command->warn('Coupons or Shipping Methods are empty. Skipping.');
            return;
        }

        foreach ($coupons as $coupon) {
            $count = rand(1, min(2, $shippingMethods->count()));
            $randomIds = $shippingMethods->random($count)->pluck('id');

            $coupon->shippingMethods()->sync($randomIds);
        }

        $this->command->info('Coupon Shipping relationships seeded successfully!');
    }
}
