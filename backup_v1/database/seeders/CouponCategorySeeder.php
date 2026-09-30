<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class CouponCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = Coupon::all();
        $categories = ProductCategory::all();

        if ($coupons->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Coupons or Categories table is empty. Skipping seeding.');
            return;
        }

        // Loop through coupons and assign random categories
        foreach ($coupons as $coupon) {
            // Pick a random number of categories to assign (e.g., 1 to 3)
            $randomCategories = $categories->random(rand(1, min(3, $categories->count())));

            // Use the sync or attach method provided by the relationship
            $coupon->categories()->sync($randomCategories->pluck('id'));
        }
    }
}
