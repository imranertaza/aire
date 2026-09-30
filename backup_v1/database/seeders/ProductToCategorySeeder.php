<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductToCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('product_to_categories')->truncate();
        Schema::enableForeignKeyConstraints();

        $electronics  = ProductCategory::where('alt_name', 'electronics')->first();
        $fashion      = ProductCategory::where('alt_name', 'fashion')->first();
        $smartphones  = ProductCategory::where('alt_name', 'smartphones')->first();
        $laptops      = ProductCategory::where('alt_name', 'laptops')->first();
        $mensClothing = ProductCategory::where('alt_name', 'mens-clothing')->first();

        $samsung = Product::where('product_code', 'SAMS23U001')->first();
        if ($samsung) {
            $samsungCategories = array_filter([$smartphones?->id, $electronics?->id]);
            if (!empty($samsungCategories)) {
                $samsung->categories()->sync($samsungCategories);
            }
        }

        $nike = Product::where('product_code', 'NIKE270001')->first();
        if ($nike) {
            $nikeCategories = array_filter([$mensClothing?->id, $fashion?->id]);
            if (!empty($nikeCategories)) {
                $nike->categories()->sync($nikeCategories);
            }
        }

        $dell = Product::where('product_code', 'DELLXPS001')->first();
        if ($dell) {
            $dellCategories = array_filter([$laptops?->id, $electronics?->id]);
            if (!empty($dellCategories)) {
                $dell->categories()->sync($dellCategories);
            }
        }
    }
}
