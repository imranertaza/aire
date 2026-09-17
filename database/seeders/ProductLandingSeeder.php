<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductLanding;

class ProductLandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $targetSlug = 'aire-pure-studio-mini';
        $product = Product::where('slug', $targetSlug)->first();

        if (!$product) {
            $this->command->error("Product with slug '{$targetSlug}' not found.");
            return;
        }

        // Base landing page dataset (identical to the existing landing page)
        $defaultData = [
            'status' => 1,
            'hero_tag' => 'PRO SERIES X',
            'hero_title' => 'Revolutionary Atmospheric Purification',
            'hero_description' => 'Engineered with aerospace-grade synthesis technology for zero contaminant tolerance.',
            'hero_button_text' => 'Explore Technology',
            'hero_button_url' => '/explore',
            'hero_image' => null,
            'science_tag' => 'MOLECULAR SYNTHESIS',
            'science_title' => "Absolute Purity\nInside & Out",
            'science_description' => 'Every microscopic filter is tested to medical benchmark precision.',
            'science_stat1_value' => '99.999%',
            'science_stat1_label' => 'VIRAL REDUCTION',
            'science_stat2_value' => 'NANO',
            'science_stat2_label' => 'LEVEL PURITY',
            'science_image' => null,
            'science_features' => [
                [
                    'title' => 'Ultra-Quiet Acoustic Dampening',
                    'desc' => 'Operates at under 22dB in night mode.',
                ],
                [
                    'title' => 'Smart IoT Cloud Sync',
                    'desc' => 'Real-time telemetry and air quality monitoring.',
                ],
                [
                    'title' => 'Auto-Regulating Sensor Array',
                    'desc' => 'Dual laser particle and VOC sensing.',
                ],
            ],
            'lifestyle_tag' => 'ARCHITECTURAL',
            'lifestyle_title' => "Seamless\nHarmony",
            'lifestyle_description' => 'Flawlessly blends into luxury residential and commercial spaces.',
            'lifestyle_button_text' => 'View Spaces',
            'lifestyle_button_url' => '/spaces',
            'lifestyle_image' => null,
            'filter_tech_title' => 'Multi-Layer HEPA Precision',
            'filter_tech_description' => 'Captures allergens, bacteria, and particulate matter at 0.1 microns.',
            'filter_tech_badge_text' => 'Certified medical-grade high-efficiency filtration matrix.',
            'filter_tech_image' => null,
            'specs_title' => 'Technical Specifications',
            'specs_subtitle' => 'Detailed metrics and performance benchmarks.',
            'specs_image' => null,
            'specs_button_text' => 'Download Whitepaper',
            'specs_button_url' => '/whitepaper.pdf',
            'specs_groups' => [
                [
                    'tag' => '01 / FILTRATION MATRIX',
                    'title' => 'Multi-Stage Active Filtration',
                    'image' => 'https://picsum.photos/500/500?test=1',
                    'items' => [
                        [
                            'label' => 'Pre-Filter Matrix',
                            'value' => 'Stainless micromesh',
                        ],
                        [
                            'label' => 'HEPA Efficiency',
                            'value' => '99.99% @ 0.1 micron',
                        ],
                    ],
                ],
                [
                    'tag' => '02 / AIRFLOW & VELOCITY',
                    'title' => 'Dynamic Air Volume',
                    'image' => 'https://picsum.photos/500/500?test=2',
                    'items' => [
                        [
                            'label' => 'Clean Air Delivery Rate',
                            'value' => '650 m³/h',
                        ],
                        [
                            'label' => 'Room Coverage Area',
                            'value' => '1,400 sq. ft.',
                        ],
                    ],
                ],
            ],
        ];

        // Check if an existing landing page exists to replicate exact active values
        $existing = ProductLanding::where('product_id', 1)->first();
        if ($existing) {
            $landingData = $existing->toArray();
            unset($landingData['id'], $landingData['created_at'], $landingData['updated_at']);
        } else {
            $landingData = $defaultData;
        }

        $landingData['product_id'] = $product->id;
        $landingData['status'] = 1;

        ProductLanding::updateOrCreate(
            ['product_id' => $product->id],
            $landingData
        );

        $this->command->info("Successfully seeded landing page for '{$product->name}' (slug: {$targetSlug}, ID: {$product->id}).");
    }
}
