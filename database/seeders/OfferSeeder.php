<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    /**
     * Seed offers, offer_discounts, and offer_on_products
     * from the original cc_offer / cc_offer_discount / cc_offer_on_product data.
     *
     * Mapping from old CI string values → new integer values:
     *   offer_type : 'distinct' → 1 | 'indistinct' → 2
     *   offer_on   : 'product'  → 1 | 'amount'     → 2
     *   discount_on: 'product'  → 1 | 'product_amount' → 2 | 'shipping_amount' → 3
     *   discount_calculate_on: 'percentage' → 1 | 'fixed' → 2
     */
    public function run(): void
    {
        // ----------------------------------------------------------------
        // 1. offers  (disable FK checks so child tables can be truncated first)
        // ----------------------------------------------------------------
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('offer_on_products')->truncate();
        DB::table('offer_discounts')->truncate();
        DB::table('offers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('offers')->insert([
            [
                'id'           => 3,
                'name'         => 'Buy One Get 20 % off',
                'key'          => 'general_offer',
                'description'  => 'Buy One Get 20 % off',
                'banner'       => 'https://placehold.co/1200x400?text=Buy+1+Get+20+Off',
                'alt_name'     => 'Buy One Get 20 % off',
                'slug'         => 'buy-one-get-20--off',
                'offer_type'   => 1,     // distinct
                'offer_on'     => 1,     // product
                'qty'          => 1,
                'on_amount'    => 0.00,
                'discount_on'  => 2,     // product_amount
                'start_date'   => '2025-09-05 00:00:00',
                'expire_date'  => '2025-01-31 00:00:00',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 4,
                'name'         => 'Offer all products',
                'key'          => 'zone_based_offer',
                'description'  => 'Offer all products',
                'banner'       => 'https://placehold.co/1200x400?text=Offer+All+Products',
                'alt_name'     => 'Offer all products',
                'slug'         => 'offer-all-products',
                'offer_type'   => 1,     // distinct
                'offer_on'     => 1,     // product
                'qty'          => 2,
                'on_amount'    => 0.00,
                'discount_on'  => 3,     // shipping_amount
                'start_date'   => '2025-09-05 00:00:00',
                'expire_date'  => '2025-01-30 00:00:00',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        // ----------------------------------------------------------------
        // 2. offer_discounts
        // ----------------------------------------------------------------

        DB::table('offer_discounts')->insert([
            // Offer 4 — zone-based shipping discounts
            [
                'offer_id'              => 4,
                'discount_calculate_on' => 2,     // fixed
                'discount_amount'       => 15,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'offer_id'              => 4,
                'discount_calculate_on' => 1,     // percentage
                'discount_amount'       => 10,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'offer_id'              => 4,
                'discount_calculate_on' => 1,     // percentage
                'discount_amount'       => 10,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'offer_id'              => 4,
                'discount_calculate_on' => 1,     // percentage
                'discount_amount'       => 10,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            // Offer 3 — 10% percentage discount
            [
                'offer_id'              => 3,
                'discount_calculate_on' => 1,     // percentage
                'discount_amount'       => 10,
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
        ]);

        // ----------------------------------------------------------------
        // 3. offer_on_products
        // ----------------------------------------------------------------

        DB::table('offer_on_products')->insert([
            // Offer 4 — all products (all columns NULL → means "apply to everything")
            [
                'offer_id'    => 4,
                'product_id'  => null,
                'prod_cat_id' => null,
                'brand_id'    => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            // Offer 3 — specific product (product_id = 39 from old DB)
            [
                'offer_id'    => 3,
                'product_id'  => 39,
                'prod_cat_id' => null,
                'brand_id'    => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
