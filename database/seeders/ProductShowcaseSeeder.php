<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductShowcase;
use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('product_showcases')) {
            echo "Table 'product_showcases' does not exist. Please run 'php artisan migrate' first.\n";
            return;
        }

        // Ensure title and subtitle columns exist
        Schema::table('product_showcases', function (Blueprint $table) {
            if (!Schema::hasColumn('product_showcases', 'title')) {
                $table->string('title')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('product_showcases', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('title');
            }
            if (!Schema::hasColumn('product_showcases', 'modal_subtitle')) {
                $table->string('modal_subtitle')->nullable()->after('subtitle');
            }
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('product_showcases')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } else {
            DB::table('product_showcases')->truncate();
        }

        $products = Product::with(['description', 'brand', 'categories'])->get();

        if ($products->isEmpty()) {
            echo "No products found to seed showcase data.\n";
            return;
        }

        echo "Seeding showcase data for " . $products->count() . " products...\n";

        foreach ($products as $index => $product) {
            $brandName = $product->brand ? $product->brand->name : 'BROAD';
            $firstCategory = $product->categories ? $product->categories->first() : null;
            $categoryName = $firstCategory ? $firstCategory->name : 'Single Room Ductless';
            $categoryDesc = $firstCategory && $firstCategory->description
                ? \Illuminate\Support\Str::limit(strip_tags($firstCategory->description), 45)
                : 'Compact & powerful fresh air solution';

            $modelName = $product->model ?: ($product->description ? $product->description->name : 'FF100 AirPro Fresh');
            $descText = $product->description && $product->description->description
                ? \Illuminate\Support\Str::limit(strip_tags($product->description->description), 36)
                : 'Compact Fresh Air System';

            ProductShowcase::updateOrCreate(
                ['product_id' => $product->id],
                [
                    // Top Header & Badges (cart.png)
                    'title'             => 'Single Room Ductless',
                    'subtitle'          => 'Compact & powerful fresh air solution',
                    'modal_subtitle'    => 'Single Room Ductless Fresh Air Ventilator',
                    'series_badge'      => 'AIRPRO HEPA Series',
                    'badge_residential' => 'Residential',
                    'badge_fresh_air'   => 'Small Fresh Air',

                    // Images & Cutouts
                    'hero_bg_image'     => 'assets/images/cart-bg.png',
                    'diagram_image'     => 'assets/images/diagram.png',

                    // Diagram Box Meta (cart.png)
                    'diagram_brand'     => $brandName,
                    'diagram_model'     => $modelName,
                    'diagram_system'    => $descText,

                    // Bottom Specs Bar (cart.png)
                    'airflow'           => '260 m³/h',
                    'power'             => '30–120 W',
                    'coverage_area'     => '20–50 m²',

                    // Floating Feature Pills over Image (cart.png)
                    'feature_pills'     => [
                        ['icon' => 'bi bi-arrows-fullscreen', 'text' => '200–500 sq ft'],
                        ['icon' => 'bi bi-arrow-repeat', 'text' => 'Heat Recovery 70%'],
                        ['icon' => 'bi bi-shield-check', 'text' => 'PM 2.5 99%'],
                        ['icon' => 'bi bi-arrow-right', 'text' => '100% Fresh Air', 'subtext' => 'No Recycled Air'],
                        ['icon' => 'bi bi-crosshair', 'text' => 'Infection Control'],
                        ['icon' => 'bi bi-file-earmark-medical', 'text' => 'Asthma'],
                        ['icon' => 'bi bi-brightness-high', 'text' => 'Allergies & Dust'],
                    ],

                    // 4-Column Spec Highlights Grid (detail-modal-popup.png)
                    'spec_highlights'   => [
                        [
                            'label' => 'PM2.5 Filtration',
                            'value' => '',
                            'icon'  => 'bi bi-arrow-right',
                        ],
                        [
                            'label' => 'Heat Recovery Efficiency',
                            'value' => '60%',
                            'icon'  => 'bi bi-arrow-repeat',
                        ],
                        [
                            'label' => 'Power Consumption',
                            'value' => '7 – 31 W',
                            'icon'  => 'bi bi-lightning-charge',
                        ],
                        [
                            'label' => 'Colour',
                            'value' => 'White',
                            'icon'  => 'bi bi-palette',
                        ],
                    ],

                    // Matched Checklist Badges (detail-modal-popup.png)
                    'matched_features'  => [
                        ['icon' => 'bi bi-house-door', 'text' => 'Residential'],
                        ['icon' => 'bi bi-arrows-fullscreen', 'text' => '200 – 500 sq ft'],
                        ['icon' => 'bi bi-arrow-right', 'text' => 'Fresh Air & Ventilation'],
                        ['icon' => 'bi bi-layout-sidebar', 'text' => 'Single Room'],
                        ['icon' => 'bi bi-square', 'text' => 'Wall Mounted'],
                        ['icon' => 'bi bi-arrow-repeat', 'text' => 'Heat Recovery'],
                        ['icon' => 'bi bi-shield-check', 'text' => 'HEPA / PM2.5 Filtration'],
                    ],

                    // Health & Certification Tags (detail-modal-popup.png)
                    'health_tags'       => [
                        ['icon' => 'bi bi-arrow-right', 'text' => 'Allergies & Dust'],
                        ['icon' => 'bi bi-file-earmark-medical', 'text' => 'Asthma'],
                        ['icon' => 'bi bi-house-door', 'text' => 'Mold & Fog Window'],
                        ['icon' => 'bi bi-grid-3x3', 'text' => 'Pets & Odor'],
                        ['icon' => 'bi bi-arrow-right', 'text' => 'Smoke & Wildfire'],
                        ['icon' => 'bi bi-diagram-3', 'text' => 'VOCs'],
                    ],
                ]
            );
        }

        echo "Product showcase data seeded successfully!\n";
    }
}
