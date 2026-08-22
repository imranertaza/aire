<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDescription;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultStore = Store::first();
        $defaultBrand = Brand::first();
        $storeId = $defaultStore?->id ?? 1;
        $brandId = $defaultBrand?->id ?? 1;

        $solutionsCat = ProductCategory::where('slug', 'solutions')->first();
        $productsCat  = ProductCategory::where('slug', 'products')->first();

        $flagships = [
            [
                'name'         => 'AIRE AirPro Mask FB2',
                'model'        => 'AP-FB2-PRO',
                'product_code' => 'AIRE-FB2-001',
                'main_image'   => 'themes/default/assets/img/airpro_mask_fb2.png',
                'image'        => 'themes/default/assets/img/airpro_mask_fb2.png,themes/default/assets/img/products/AIRE Airpro Mask FB2 Technical Visualization.png',
                'price'        => 349.00,
                'quantity'     => 150,
                'featured'     => 1,
                'weight'       => 0.32,
                'description'  => 'The AIRE AirPro Mask FB2 is a groundbreaking active-pressure particulate respirator designed for high-risk clinical environments, precision laboratories, and daily urban resilience.',
            ],
            [
                'name'         => 'AIRE Pro S1 Enterprise Purifier',
                'model'        => 'AP-S1-MAX',
                'product_code' => 'AIRE-S1-002',
                'main_image'   => 'themes/default/assets/img/aire_pro_s1.png',
                'image'        => 'themes/default/assets/img/aire_pro_s1.png,themes/default/assets/img/AIRE-Pro-S1-Hero.png',
                'price'        => 1299.00,
                'quantity'     => 80,
                'featured'     => 1,
                'weight'       => 8.50,
                'description'  => 'Engineered for open corporate offices, healthcare wards, and luxury residential suites. Delivers clinical CADR airflow of 650 m³/h with true H13 HEPA & activated carbon filtration.',
            ],
            [
                'name'         => 'AIRE Pure Studio Mini',
                'model'        => 'AP-MINI-01',
                'product_code' => 'AIRE-MINI-003',
                'main_image'   => 'themes/default/assets/img/aire_mini.png',
                'image'        => 'themes/default/assets/img/aire_mini.png,themes/default/assets/img/photograph.png',
                'price'        => 299.00,
                'quantity'     => 120,
                'featured'     => 1,
                'weight'       => 2.10,
                'description'  => 'Ultra-compact personal air cleaner with whisper-quiet 18.5dB sleep mode, laser particulate sensing, and 360-degree cylindrical air intake.',
            ],
            [
                'name'         => 'AIRE Cleanroom Scrubber 9000',
                'model'        => 'AIRE-IND-9000',
                'product_code' => 'AIRE-SCRUB-004',
                'main_image'   => 'themes/default/assets/img/Air-Purify.png',
                'image'        => 'themes/default/assets/img/Air-Purify.png,themes/default/assets/img/products/technology.png',
                'price'        => 3499.00,
                'quantity'     => 45,
                'featured'     => 1,
                'weight'       => 28.00,
                'description'  => 'High-volume industrial particulate scrubber with continuous positive pressure dynamics and dual-stage H14 ultra-HEPA matrix for cleanroom environments.',
            ],
            [
                'name'         => 'AIRE OptiSense PM2.5 & IAQ Monitor',
                'model'        => 'AIRE-IAQ-500',
                'product_code' => 'AIRE-IAQ-005',
                'main_image'   => 'themes/default/assets/img/HEPA-H13-Macro.png',
                'image'        => 'themes/default/assets/img/HEPA-H13-Macro.png,themes/default/assets/img/Filter.png',
                'price'        => 199.00,
                'quantity'     => 200,
                'featured'     => 1,
                'weight'       => 0.45,
                'description'  => 'Continuous laser spectrometry air quality monitor with OLED diagnostics displaying PM2.5, PM10, TVOC, CO2, temperature, and humidity.',
            ],
        ];

        foreach ($flagships as $idx => $f) {
            $slug = Str::slug($f['name']);
            $product = Product::updateOrCreate(
                ['product_code' => $f['product_code']],
                [
                    'store_id'         => $storeId,
                    'name'             => $f['name'],
                    'slug'             => $slug,
                    'model'            => $f['model'],
                    'main_image'       => $f['main_image'],
                    'image'            => $f['image'],
                    'alt_name'         => $f['name'],
                    'brand_id'         => $brandId,
                    'price'            => $f['price'],
                    'quantity'         => $f['quantity'],
                    'featured'         => $f['featured'],
                    'average_feedback' => 5,
                    'date_available'   => now(),
                    'weight'           => $f['weight'],
                    'length'           => 30.00,
                    'width'            => 25.00,
                    'height'           => 20.00,
                    'sort_order'       => $idx + 1,
                    'status'           => 1,
                    'createdBy'        => 1,
                    'updatedBy'        => 1,
                ]
            );

            ProductDescription::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'description'      => $f['description'],
                    'tag'              => 'flagship',
                    'meta_title'       => $f['name'] . ' | AIRE Advanced Clean Air Systems',
                    'meta_description' => $f['description'],
                    'meta_keyword'     => 'aire, clean air, air purifier, hepa, indoor air quality',
                ]
            );

            $catSync = array_filter([$solutionsCat?->id, $productsCat?->id]);
            if (!empty($catSync)) {
                $product->categories()->syncWithoutDetaching($catSync);
            }
        }
    }
}
