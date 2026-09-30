<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDescription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsForEveryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProductCategory::with('parent.parent')->get();
        echo "Found " . $categories->count() . " categories in total.\n";

        $localImages = [
            'themes/default/assets/img/airpro_mask_fb2.png',
            'themes/default/assets/img/aire_pro_s1.png',
            'themes/default/assets/img/aire_mini.png',
            'themes/default/assets/img/Air-Purify.png',
            'themes/default/assets/img/air-purifier.png',
            'themes/default/assets/img/AIRE-Pro-S1-Hero.png',
            'themes/default/assets/img/HEPA-H13-Macro.png',
            'themes/default/assets/img/Filter.png',
            'themes/default/assets/img/Filter-1.png',
            'themes/default/assets/img/product.png',
            'themes/default/assets/img/photograph.png',
            'themes/default/assets/img/apartments.png',
            'https://images.unsplash.com/photo-1585771724684-38269d6639fd?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1545259741-2ea3ebf61fa3?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1540518614846-7ede433c5173?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1584634731339-252c581abfc5?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1584744982491-665216d95f8b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1584467735815-f778f274e296?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1508873696983-2df57046475a?auto=format&fit=crop&w=800&q=80',
        ];

        $productCount = Product::count();

        foreach ($categories as $cat) {
            $existingCount = DB::table('product_to_categories')->where('category_id', $cat->id)->count();

            if ($existingCount < 2) {
                $needed = 2 - $existingCount;
                for ($k = 1; $k <= $needed; $k++) {
                    $productCount++;
                    $name = "AIRE " . $cat->category_name . " " . ($k == 1 ? "Pro S" . rand(1, 9) : "Ultra Series " . rand(100, 900));
                    $model = "AP-" . strtoupper(substr(Str::slug($cat->slug), 0, 4)) . "-" . rand(100, 990);
                    $code = "AIRE-" . sprintf("%04d", rand(1000, 9999));
                    $price = rand(199, 1899) + 0.00;
                    $imgUrl = $localImages[($cat->id + $k) % count($localImages)];

                    // Generate clean unique slug
                    $baseSlug = Str::slug($name);
                    $slug = $baseSlug;
                    $slugCounter = 1;
                    while (Product::where('slug', $slug)->exists()) {
                        $slug = $baseSlug . '-' . $slugCounter;
                        $slugCounter++;
                    }

                    // Create Product
                    $product = Product::create([
                        'store_id'         => 1,
                        'name'             => $name,
                        'slug'             => $slug,
                        'model'            => $model,
                        'product_code'     => $code,
                        'main_image'       => $imgUrl,
                        'image'            => $imgUrl,
                        'alt_name'         => $name,
                        'brand_id'         => 1,
                        'price'            => $price,
                        'quantity'         => rand(25, 120),
                        'featured'         => rand(0, 1),
                        'average_feedback' => 5,
                        'date_available'   => now(),
                        'weight'           => rand(2, 14) + 0.5,
                        'length'           => rand(25, 75),
                        'width'            => rand(25, 55),
                        'height'           => rand(15, 60),
                        'sort_order'       => $productCount,
                        'status'           => 1,
                        'createdBy'        => 1,
                        'updatedBy'        => 1,
                    ]);

                    // Create Description
                    $descData = [
                        'product_id'       => $product->id,
                        'description'      => "The {$name} represents advanced engineering in clean air management. Built for demanding technical, commercial, and luxury residential environments, delivering certified particulate capture, ultra-quiet fluid dynamics, and intelligent automation.",
                        'tag'              => $cat->slug,
                        'meta_title'       => $name . " | AIRE Advanced Clean Air Systems",
                        'meta_description' => "Explore {$name}. Certified medical-grade H13/H14 HEPA filtration, smart IoT sensor array, and architectural performance.",
                        'meta_keyword'     => "aire, " . $cat->slug . ", air purifier, clean air, hepa filter, h13, h14",
                    ];

                    if (\Illuminate\Support\Facades\Schema::hasColumn('product_descriptions', 'applications_title')) {
                        $descData = array_merge($descData, [
                            'specs_badge'                 => 'SPECIFICATIONS',
                            'specs_title'                 => 'Technical Specifications & Performance Data',
                            'specs_description'           => 'Laboratory validated against ISO 29463 and EN 1822 cleanroom clean air delivery standards.',
                            'specs_image'                 => 'themes/default/assets/img/products/SPECIFICATIONS.png',
                            'spec1_icon'                  => 'bi bi-shield-check',
                            'spec1_badge'                 => 'CADR RATE',
                            'spec1_value'                 => (string) rand(320, 850),
                            'spec1_unit'                  => 'm³/h',
                            'spec1_desc'                  => 'Clean Air Delivery Rate certified',
                            'spec2_icon'                  => 'bi bi-wind',
                            'spec2_badge'                 => 'EFFICIENCY',
                            'spec2_value'                 => '99.97',
                            'spec2_unit'                  => '%',
                            'spec2_desc'                  => 'Capture rate at 0.1 microns',
                            'spec3_icon'                  => 'bi bi-battery-charging',
                            'spec3_badge'                 => 'ACOUSTICS',
                            'spec3_value'                 => (string) rand(18, 24),
                            'spec3_unit'                  => 'dBA',
                            'spec3_desc'                  => 'Whisper-quiet sleep operational floor',
                            'spec4_icon'                  => 'bi bi-box-seam',
                            'spec4_badge'                 => 'POWER',
                            'spec4_value'                 => (string) rand(28, 65),
                            'spec4_unit'                  => 'W',
                            'spec4_desc'                  => 'Energy Star continuous duty rated',

                            'features_badge'              => 'FEATURES',
                            'features_title'              => 'Architectural Engineering & Zero Compromise',
                            'features_description'        => 'Every contour and internal fluid dynamic passage has been sculpted to optimize throughput while minimizing operational sound signature.',
                            'features_image'              => 'themes/default/assets/img/products/features.png',
                            'feature1_icon'               => 'bi bi-shield-lock',
                            'feature1_title'              => 'Medical-Grade Seal Matrix',
                            'feature1_desc'               => 'LSR silicone and precision gaskets prevent untreated bypass air from entering clean zones.',
                            'feature2_icon'               => 'bi bi-lightbulb',
                            'feature2_title'              => 'Active Environmental Status Ring',
                            'feature2_desc'               => 'Real-time multi-color LED visual feedback reflecting live particulate load and filter longevity.',
                            'feature3_icon'               => 'bi bi-funnel',
                            'feature3_title'              => 'Dual H13 & Carbon Composite',
                            'feature3_desc'               => 'Micro-pleated activated carbon bed neutralizes VOCs, chemical vapors, and gaseous pollutants.',

                            'applications_title'          => 'Industrial Excellence, Personal Comfort',
                            'applications_description'    => $name . ' is engineered to exceed safety and hygiene standards across laboratories, high-tech facilities, and modern homes.',
                            
                            'technology_badge'            => 'TECHNOLOGY',
                            'technology_title'            => 'The Physics of Pure Air',
                            'technology_description'      => 'Beyond simple filtration, the ' . $name . ' utilizes computational fluid dynamics and active sensor loops to maintain an ultra-clean air envelope.',
                            'technology_image'            => 'themes/default/assets/img/products/technology.png',
                            'technology_card_title'       => 'ACTIVE POSITIVE PRESSURE',
                            'technology_card_description' => 'Solid-state pressure sensors detect room impedance and modulate fan velocity to ensure constant laminar delivery of purified air.',
                            'tech_feature1_title'         => 'TURBULENT FLOW CONTROL',
                            'tech_feature1_desc'          => 'Internal ducting modeled via CFD to reduce air turbulence and maintain operation under 22dB.',
                            'tech_feature2_title'         => 'LASER PARTICULATE SCANNING',
                            'tech_feature2_desc'          => 'Integrated solid-state laser sensor monitors PM2.5 / PM10 concentrations every 250ms.',
                            'tech_feature3_title'         => 'AEROSPACE CHASSIS',
                            'tech_feature3_desc'          => 'Precision-crafted chassis from anodized aluminum and reinforced aerospace polymers.',
                        ]);
                    }

                    ProductDescription::create($descData);

                    // Collect category chain (self, parent, grandparent)
                    $catChain = [$cat->id];
                    if ($cat->parent) {
                        $catChain[] = $cat->parent->id;
                        if ($cat->parent->parent) {
                            $catChain[] = $cat->parent->parent->id;
                        }
                    }

                    $catChain = array_unique($catChain);

                    foreach ($catChain as $cId) {
                        DB::table('product_to_categories')->insertOrIgnore([
                            'product_id'  => $product->id,
                            'category_id' => $cId,
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ]);
                    }
                }
            }
        }

        echo "Successfully seeded {$productCount} total products across all categories!\n";
    }
}
