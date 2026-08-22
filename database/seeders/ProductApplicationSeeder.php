<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('No products found to seed applications for.');
            return;
        }

        // Ensure image files are copied into storage/app/public/products
        $targetDir = storage_path('app/public/products');
        if (!\Illuminate\Support\Facades\File::exists($targetDir)) {
            \Illuminate\Support\Facades\File::makeDirectory($targetDir, 0755, true);
        }
        $copyMap = [
            public_path('themes/default/assets/img/products/SPECIFICATIONS.png')        => $targetDir . '/specifications.png',
            public_path('themes/default/assets/img/products/features.png')               => $targetDir . '/features.png',
            public_path('themes/default/assets/img/airpro_mask_fb2.png')                => $targetDir . '/airpro_mask_fb2.png',
            public_path('themes/default/assets/img/products/technology.png')            => $targetDir . '/technology.png',
            public_path('themes/default/assets/img/products/R&D Laboratories1.png')      => $targetDir . '/rd_laboratories.png',
            public_path('themes/default/assets/img/products/Precision Manufacturing.png') => $targetDir . '/precision_manufacturing.png',
            public_path('themes/default/assets/img/products/Urban Mobility.png')        => $targetDir . '/urban_mobility.png',
        ];
        foreach ($copyMap as $s => $d) {
            if (\Illuminate\Support\Facades\File::exists($s) && !\Illuminate\Support\Facades\File::exists($d)) {
                \Illuminate\Support\Facades\File::copy($s, $d);
            }
        }

        // Clean existing product applications
        DB::table('product_applications')->truncate();

        $appTemplates = [
            [
                'title'       => 'R&D Laboratories',
                'description' => 'Precision filtration for controlled environments and sensitive chemical handling applications.',
                'badge'       => null,
                'image'       => 'products/rd_laboratories.png',
                'grid_width'  => 'col-lg-8',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Precision Manufacturing',
                'description' => 'Protects technicians from micro-particulates during high-precision fabrication and assembly.',
                'badge'       => null,
                'image'       => 'products/precision_manufacturing.png',
                'grid_width'  => 'col-lg-4',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Urban Mobility',
                'description' => 'Advanced protection for professionals navigating high-density metropolitan environments.',
                'badge'       => 'OPTIMIZED FOR DAILY COMMUTE',
                'image'       => 'products/urban_mobility.png',
                'grid_width'  => 'col-12',
                'sort_order'  => 3,
            ],
        ];

        $records = [];
        foreach ($products as $product) {
            foreach ($appTemplates as $tmpl) {
                $records[] = [
                    'product_id'  => $product->id,
                    'title'       => $tmpl['title'],
                    'description' => $tmpl['description'],
                    'badge'       => $tmpl['badge'],
                    'image'       => $tmpl['image'],
                    'bg_image'    => $tmpl['image'],
                    'grid_width'  => $tmpl['grid_width'],
                    'sort_order'  => $tmpl['sort_order'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        foreach (array_chunk($records, 500) as $chunk) {
            DB::table('product_applications')->insert($chunk);
        }

        // Also ensure product_descriptions have dynamic features, technology and applications fields populated if columns exist
        if (\Illuminate\Support\Facades\Schema::hasColumn('product_descriptions', 'applications_title')) {
            $hasFeaturesCols = \Illuminate\Support\Facades\Schema::hasColumn('product_descriptions', 'features_title');
            foreach ($products as $product) {
                $descUpdate = [
                    'specs_badge'                 => 'SPECIFICATIONS',
                    'specs_title'                 => 'Technical Specifications',
                    'specs_description'           => 'Laboratory-validated performance metrics and component architecture for the ' . $product->name . ' System.',
                    'specs_image'                 => 'products/specifications.png',
                    'spec1_icon'                  => 'bi bi-shield-check',
                    'spec1_badge'                 => 'FILTRATION',
                    'spec1_value'                 => '99.97%',
                    'spec1_unit'                  => '',
                    'spec1_desc'                  => '@ 0.3MM EFFICIENCY',
                    'spec2_icon'                  => 'bi bi-wind',
                    'spec2_badge'                 => 'VELOCITY',
                    'spec2_value'                 => '4.2',
                    'spec2_unit'                  => 'L/sec',
                    'spec2_desc'                  => 'MAX AIRFLOW RATE',
                    'spec3_icon'                  => 'bi bi-battery-charging',
                    'spec3_badge'                 => 'ENDURANCE',
                    'spec3_value'                 => '12',
                    'spec3_unit'                  => 'Hours',
                    'spec3_desc'                  => 'CONTINUOUS OPERATION',
                    'spec4_icon'                  => 'bi bi-box-seam',
                    'spec4_badge'                 => 'MASS',
                    'spec4_value'                 => '185',
                    'spec4_unit'                  => 'Grams',
                    'spec4_desc'                  => 'TOTAL SYSTEM WEIGHT',

                    'applications_title'          => 'Industrial Excellence, Personal Comfort',
                    'applications_description'    => $product->name . ' is engineered to exceed safety standards in the most demanding environments, from high-tech labs to daily mobility.',
                    'technology_badge'            => 'TECHNOLOGY',
                    'technology_title'            => 'The Physics of Pure Air',
                    'technology_description'      => 'Beyond simple filtration, the ' . $product->name . ' utilizes fluid dynamics and active sensor arrays to maintain a stable positive-pressure environment within the mask, preventing untreated air ingress.',
                    'technology_image'            => 'products/airpro_mask_fb2.png',
                    'technology_card_title'       => 'ACTIVE POSITIVE PRESSURE',
                    'technology_card_description' => 'Smart sensors detect inhalation resistance and automatically adjust fan velocity to ensure a constant supply of fresh air, regardless of respiratory demand.',
                    'tech_feature1_title'         => 'TURBULENT FLOW CONTROL',
                    'tech_feature1_desc'          => 'Internal ducting is modeled using computational fluid dynamics to minimize air turbulence and operational noise below 20dB.',
                    'tech_feature2_title'         => 'PARTICULATE SENSING',
                    'tech_feature2_desc'          => 'Integrated laser-based sensors scan for PM2.5 concentrations every 500ms, providing hyper-responsive airflow modulation.',
                    'tech_feature3_title'         => 'BIO-MECHANICAL FIT',
                    'tech_feature3_desc'          => 'The structural chassis is crafted from aerospace-grade polymers, achieving an industry-leading strength-to-weight ratio for ergonomic balance.',
                ];

                if ($hasFeaturesCols) {
                    $descUpdate['features_badge']       = 'FEATURES';
                    $descUpdate['features_title']       = 'Precision Engineered Details';
                    $descUpdate['features_description'] = 'The ' . $product->name . ' is a masterclass in industrial design, where every component is optimized for performance, durability, and user comfort.';
                    $descUpdate['features_image']       = 'products/features.png';
                    $descUpdate['feature1_icon']        = 'bi bi-shield-lock';
                    $descUpdate['feature1_title']       = 'Medical-Grade Facial Seal';
                    $descUpdate['feature1_desc']        = 'Hypoallergenic LSR silicone ensures a perfect, pressure-mapped seal for all-day comfort in high-stakes environments.';
                    $descUpdate['feature2_icon']        = 'bi bi-lightbulb';
                    $descUpdate['feature2_title']       = 'Active Feedback Ring';
                    $descUpdate['feature2_desc']        = 'Integrated LED halo provides real-time data on air quality and filter life at a glance, ensuring constant operational awareness.';
                    $descUpdate['feature3_icon']        = 'bi bi-funnel';
                    $descUpdate['feature3_title']       = 'Advanced HEPA Filtration';
                    $descUpdate['feature3_desc']        = 'Dual H13 Industrial filters capture 99.97% of particulates with micro-pleated geometry for maximum surface area efficiency.';
                }

                DB::table('product_descriptions')->where('product_id', $product->id)->update($descUpdate);
            }
        }

        $this->command->info("Successfully seeded applications and descriptions for {$products->count()} products.");
    }
}