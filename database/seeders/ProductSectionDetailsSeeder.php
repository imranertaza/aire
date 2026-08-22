<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductTechnology;
use App\Models\ProductApplication;
use App\Models\ProductBoxContent;
use App\Models\ProductFaq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSectionDetailsSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if (\Illuminate\Support\Facades\Schema::hasTable('product_features')) {
            DB::table('product_features')->truncate();
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('product_technologies')) {
            DB::table('product_technologies')->truncate();
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('product_applications')) {
            DB::table('product_applications')->truncate();
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('product_box_contents')) {
            DB::table('product_box_contents')->truncate();
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('product_faqs')) {
            DB::table('product_faqs')->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = Product::all();
        echo "Seeding full section details for " . $products->count() . " products...\n";

        foreach ($products as $p) {
            // 1. Features (3 Cards for Parallax Banner)
            ProductFeature::create([
                'product_id'  => $p->id,
                'title'       => 'Medical-Grade Facial Seal',
                'description' => 'Hypoallergenic LSR silicone ensures a perfect, pressure-mapped seal for all-day comfort in high-stakes environments.',
                'icon'        => 'bi bi-shield-lock',
                'sort_order'  => 1,
                'status'      => 1,
            ]);

            ProductFeature::create([
                'product_id'  => $p->id,
                'title'       => 'Active Feedback Ring',
                'description' => 'Integrated LED halo provides real-time data on air quality and filter life at a glance, ensuring constant operational awareness.',
                'icon'        => 'bi bi-lightbulb',
                'sort_order'  => 2,
                'status'      => 1,
            ]);

            ProductFeature::create([
                'product_id'  => $p->id,
                'title'       => 'Advanced HEPA Filtration',
                'description' => 'Dual H13 Industrial filters capture 99.97% of particulates with micro-pleated geometry for maximum surface area efficiency.',
                'icon'        => 'bi bi-funnel',
                'sort_order'  => 3,
                'status'      => 1,
            ]);

            // 2. Technologies (Physics Banner & 3 Numbered Steps)
            ProductTechnology::create([
                'product_id'  => $p->id,
                'title'       => 'The Physics of Pure Air',
                'subtitle'    => 'TURBULENT FLOW CONTROL',
                'description' => 'Internal ducting is modeled using computational fluid dynamics to minimize air turbulence and operational noise below 20dB.',
                'image'       => $p->main_image,
                'sort_order'  => 1,
                'status'      => 1,
            ]);

            ProductTechnology::create([
                'product_id'  => $p->id,
                'title'       => 'The Physics of Pure Air',
                'subtitle'    => 'PARTICULATE SENSING',
                'description' => 'Integrated laser-based sensors scan for PM2.5 concentrations every 500ms, providing hyper-responsive airflow modulation.',
                'image'       => $p->main_image,
                'sort_order'  => 2,
                'status'      => 1,
            ]);

            ProductTechnology::create([
                'product_id'  => $p->id,
                'title'       => 'The Physics of Pure Air',
                'subtitle'    => 'BIO-MECHANICAL FIT',
                'description' => 'The structural chassis is crafted from aerospace-grade polymers, achieving an industry-leading strength-to-weight ratio for ergonomic balance.',
                'image'       => $p->main_image,
                'sort_order'  => 3,
                'status'      => 1,
            ]);

            // 3. Applications (3 Grid Layout: col-8, col-4, col-12)
            ProductApplication::create([
                'product_id'  => $p->id,
                'title'       => 'R&D Laboratories',
                'badge'       => 'CONTROLLED ENVIRONMENTS',
                'description' => 'Precision filtration for controlled environments and sensitive chemical handling applications.',
                'image'       => 'themes/default/assets/img/products/R&D Laboratories1.png',
                'bg_image'    => 'themes/default/assets/img/products/R&D Laboratories1.png',
                'grid_width'  => 'col-lg-8',
                'sort_order'  => 1,
            ]);

            ProductApplication::create([
                'product_id'  => $p->id,
                'title'       => 'Precision Manufacturing',
                'badge'       => 'INDUSTRIAL',
                'description' => 'Protects technicians from micro-particulates during high-precision fabrication.',
                'image'       => 'themes/default/assets/img/products/Precision Manufacturing.png',
                'bg_image'    => 'themes/default/assets/img/products/Precision Manufacturing.png',
                'grid_width'  => 'col-lg-4',
                'sort_order'  => 2,
            ]);

            ProductApplication::create([
                'product_id'  => $p->id,
                'title'       => 'Urban Mobility',
                'badge'       => 'OPTIMIZED FOR DAILY COMMUTE',
                'description' => 'Advanced protection for professionals navigating high-density metropolitan environments.',
                'image'       => 'themes/default/assets/img/products/Urban Mobility.png',
                'bg_image'    => 'themes/default/assets/img/products/Urban Mobility.png',
                'grid_width'  => 'col-12',
                'sort_order'  => 3,
            ]);

            // 4. Box Contents (6 Items Grid)
            ProductBoxContent::create([
                'product_id' => $p->id,
                'item_name'  => $p->name,
                'quantity'   => '01',
                'image'      => $p->main_image ?: 'img/airpro_mask_fb2.png',
                'sort_order' => 1,
                'status'     => 1,
            ]);

            ProductBoxContent::create([
                'product_id' => $p->id,
                'item_name'  => 'HEPA H13 FILTER',
                'quantity'   => '02',
                'image'      => 'img/Air-Purify.png',
                'sort_order' => 2,
                'status'     => 1,
            ]);

            ProductBoxContent::create([
                'product_id' => $p->id,
                'item_name'  => 'USB-C POWER KIT',
                'quantity'   => '01',
                'image'      => 'img/aire_mini.png',
                'sort_order' => 3,
                'status'     => 1,
            ]);

            ProductBoxContent::create([
                'product_id' => $p->id,
                'item_name'  => 'TECHNICAL CASE',
                'quantity'   => '01',
                'image'      => 'img/Air-Purify.png',
                'sort_order' => 4,
                'status'     => 1,
            ]);

            ProductBoxContent::create([
                'product_id' => $p->id,
                'item_name'  => 'TECHNICAL GUIDE',
                'quantity'   => '01',
                'image'      => 'img/Aire-product.png',
                'sort_order' => 5,
                'status'     => 1,
            ]);

            ProductBoxContent::create([
                'product_id' => $p->id,
                'item_name'  => 'QUALITY CERTIFICATE',
                'quantity'   => '01',
                'image'      => 'img/Filter-1.png',
                'sort_order' => 6,
                'status'     => 1,
            ]);

            // 5. FAQs (5 Accordion Questions)
            ProductFaq::create([
                'product_id' => $p->id,
                'question'   => 'How long do the HEPA H13 filters last?',
                'answer'     => 'Under normal conditions, filters should be replaced every 120-150 hours of active use. The integrated sensor will notify you via the LED ring and app when replacement is required.',
                'sort_order' => 1,
                'status'     => 1,
            ]);

            ProductFaq::create([
                'product_id' => $p->id,
                'question'   => 'Is this product suitable for high-intensity exercise and sports?',
                'answer'     => 'Yes. The active pressure balance system dynamically adjusts airflow to match your breathing rate, preventing CO2 buildup and keeping the interior cool during physical exertion.',
                'sort_order' => 2,
                'status'     => 1,
            ]);

            ProductFaq::create([
                'product_id' => $p->id,
                'question'   => 'How do I sanitize and clean the unit?',
                'answer'     => 'The medical-grade silicone seal is detachable and can be cleaned with warm soapy water or alcohol-based wipes. Ensure the electronic chassis is removed before cleaning.',
                'sort_order' => 3,
                'status'     => 1,
            ]);

            ProductFaq::create([
                'product_id' => $p->id,
                'question'   => 'Does the device support Bluetooth and Smart App connectivity?',
                'answer'     => 'Yes, it connects to the AIRE app via Bluetooth 5.2 and Wi-Fi for real-time air quality monitoring, filter health tracking, and firmware updates.',
                'sort_order' => 4,
                'status'     => 1,
            ]);

            ProductFaq::create([
                'product_id' => $p->id,
                'question'   => 'What is the battery life of the active sensors and motor?',
                'answer'     => 'The internal lithium-ion battery provides up to 12 hours of continuous operation on a single charge. It supports fast charging via USB-C, reaching 80% in just 45 minutes.',
                'sort_order' => 5,
                'status'     => 1,
            ]);
        }

        echo "Successfully seeded all 5 section tables for all products!\n";
    }
}
