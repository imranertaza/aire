<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultStore = Store::first();
        $defaultBrand = Brand::first();

        $electronics  = ProductCategory::where('alt_name', 'electronics')->first();
        $fashion      = ProductCategory::where('alt_name', 'fashion')->first();
        $smartphones  = ProductCategory::where('alt_name', 'smartphones')->first();
        $laptops      = ProductCategory::where('alt_name', 'laptops')->first();
        $mensClothing = ProductCategory::where('alt_name', 'mens-clothing')->first();

        // 1. Samsung Galaxy S23 Ultra
        $s23 = Product::create([
            'store_id'         => $defaultStore?->id ?? 1,
            'name'             => 'Samsung Galaxy S23 Ultra',
            'model'            => 'SM-S918B',
            'product_code'     => 'SAMS23U001',
            'main_image'       => 'https://placehold.co/800x800?text=Samsung+S23+Ultra',
            'image'            => 'https://placehold.co/800x800?text=S23+Detail+1,https://placehold.co/800x800?text=S23+Detail+2',
            'alt_name'         => 'samsung-galaxy-s23-ultra',
            'brand_id'         => $defaultBrand?->id ?? 1,
            'price'            => 1199.99,
            'quantity'         => 50,
            'featured'         => 1,
            'average_feedback' => 4,
            'date_available'   => now()->addDays(5),
            'weight'           => 0.2340,
            'length'           => 16.30,
            'width'            => 7.80,
            'height'           => 0.87,
            'sort_order'       => 1,
            'status'           => 1,
            'createdBy'        => 1,
            'updatedBy'        => 1,
        ]);

        $s23Categories = array_filter([$smartphones?->id, $electronics?->id]);
        if (!empty($s23Categories)) {
            $s23->categories()->sync($s23Categories);
        }

        // 2. Nike Air Max 270
        $nike = Product::create([
            'store_id'         => $defaultStore?->id ?? 1,
            'name'             => 'Nike Air Max 270',
            'model'            => 'AH6789-001',
            'product_code'     => 'NIKE270001',
            'main_image'       => 'https://placehold.co/800x800?text=Nike+Air+Max+270',
            'image'            => 'https://placehold.co/800x800?text=Nike+Detail+1',
            'alt_name'         => 'nike-air-max-270',
            'brand_id'         => $defaultBrand?->id ?? 1,
            'price'            => 149.99,
            'quantity'         => 120,
            'featured'         => 1,
            'average_feedback' => 5,
            'date_available'   => now(),
            'weight'           => 0.4500,
            'length'           => 28.00,
            'width'            => 12.00,
            'height'           => 10.00,
            'sort_order'       => 2,
            'status'           => 1,
            'createdBy'        => 1,
            'updatedBy'        => 1,
        ]);

        $nikeCategories = array_filter([$mensClothing?->id, $fashion?->id]);
        if (!empty($nikeCategories)) {
            $nike->categories()->sync($nikeCategories);
        }

        // 3. Dell XPS 13 Laptop
        $dell = Product::create([
            'store_id'         => $defaultStore?->id ?? 1,
            'name'             => 'Dell XPS 13 Laptop',
            'model'            => 'XPS-13-9315',
            'product_code'     => 'DELLXPS001',
            'main_image'       => 'https://placehold.co/800x800?text=Dell+XPS+13',
            'image'            => 'https://placehold.co/800x800?text=Dell+Detail+1',
            'alt_name'         => 'dell-xps-13',
            'brand_id'         => $defaultBrand?->id ?? 1,
            'price'            => 999.99,
            'quantity'         => 25,
            'featured'         => 0,
            'average_feedback' => 4,
            'date_available'   => now()->subDays(10),
            'weight'           => 1.2000,
            'length'           => 29.60,
            'width'            => 19.90,
            'height'           => 1.50,
            'sort_order'       => 3,
            'status'           => 1,
            'createdBy'        => 1,
            'updatedBy'        => 1,
        ]);

        $dellCategories = array_filter([$laptops?->id, $electronics?->id]);
        if (!empty($dellCategories)) {
            $dell->categories()->sync($dellCategories);
        }
    }
}
