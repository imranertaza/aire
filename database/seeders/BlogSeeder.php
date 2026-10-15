<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('blog_category_maps')->truncate();
        DB::table('blogs')->truncate();
        DB::table('blog_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminId = \App\Models\User::value('id') ?: 1;

        // 1. Create Categories
        $categories = [
            ['id' => 1, 'category_name' => 'Air Quality & Health', 'slug' => 'air-quality-health', 'parent_id' => null, 'status' => 1],
            ['id' => 2, 'category_name' => 'Filtration Technology', 'slug' => 'filtration-technology', 'parent_id' => null, 'status' => 1],
            ['id' => 3, 'category_name' => 'Smart Cleanrooms', 'slug' => 'smart-cleanrooms', 'parent_id' => null, 'status' => 1],
            ['id' => 4, 'category_name' => 'HVAC & Ventilation', 'slug' => 'hvac-ventilation', 'parent_id' => null, 'status' => 1],
            ['id' => 5, 'category_name' => 'Guides & Maintenance', 'slug' => 'guides-maintenance', 'parent_id' => null, 'status' => 1],
        ];

        foreach ($categories as $cat) {
            BlogCategory::create($cat);
        }

        // 2. Create Blogs
        $blogs = [
            [
                'id'          => 1,
                'title'       => 'Understanding HEPA H13 vs H14 Filtration Standards',
                'slug'        => 'understanding-hepa-h13-vs-h14-filtration-standards',
                'short_des'   => 'Discover the scientific differences between True HEPA H13 and medical-grade H14 filters.',
                'description' => '<p>When evaluating clean air performance, particle capture efficiency is critical. HEPA H13 filters capture 99.95% of particulates down to 0.1 microns, while H14 filters achieve 99.995% efficiency, making them the standard choice for semiconductor cleanrooms and surgical suites. Understanding pressure drop and airflow velocity ensures optimal filter selection.</p>',
                'meta_title'       => 'HEPA H13 vs H14 Filtration Standards Explained | Aire',
                'meta_keyword'     => 'HEPA H13, HEPA H14, air filtration efficiency, cleanroom standards',
                'meta_description' => 'A comprehensive guide explaining the efficiency, airflow, and applications of HEPA H13 and H14 filtration.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'HEPA Filter Cross Section',
                'publish_date'     => Carbon::now()->subDays(2),
                'status'           => '1',
                'createdBy'        => $adminId,
                'updatedBy'        => $adminId,
                'category_ids'     => [2],
            ],
            [
                'id'          => 2,
                'title'       => 'How Indoor Air Quality Impacts Workplace Productivity',
                'slug'        => 'how-indoor-air-quality-impacts-workplace-productivity',
                'short_des'   => 'New environmental research reveals how reducing CO2 and PM2.5 enhances cognitive performance.',
                'description' => '<p>Modern offices often trap volatile organic compounds (VOCs) and carbon dioxide. Installing smart IAQ continuous filtration systems increases oxygenation, cuts absenteeism, and boosts overall team focus by up to 25%. Learn how proper ventilation correlates directly with employee health.</p>',
                'meta_title'       => 'Indoor Air Quality and Workplace Productivity | Aire',
                'meta_keyword'     => 'indoor air quality, workplace wellness, IAQ monitoring, office air purifier',
                'meta_description' => 'Explore the scientific correlation between purified indoor air, reduced CO2 levels, and workplace cognitive productivity.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'Modern Office Air Quality System',
                'publish_date'     => Carbon::now()->subDays(5),
                'status'           => '1',
                'createdBy'        => $adminId,
                'updatedBy'        => $adminId,
                'category_ids'     => [1],
            ],
            [
                'id'          => 3,
                'title'       => 'The Essential Guide to Purifier Filter Replacement and Care',
                'slug'        => 'the-essential-guide-to-purifier-filter-replacement-and-care',
                'short_des'   => 'Maximize the lifespan and airflow efficiency of your residential and commercial purifiers.',
                'description' => '<p>Maintaining optimal airflow requires timely pre-filter vacuuming and periodic carbon block replacement. Learn how Aire IoT sensors automatically calculate filter saturation based on real particle density and runtime hours.</p>',
                'meta_title'       => 'Air Purifier Maintenance & Filter Replacement Guide | Aire',
                'meta_keyword'     => 'filter replacement, air purifier maintenance, HEPA lifespan, clean air tips',
                'meta_description' => 'Essential maintenance tips to keep your air purifiers running silently and capturing allergens effectively.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'Filter Replacement Process',
                'publish_date'     => Carbon::now()->subDays(7),
                'status'           => '1',
                'createdBy'        => $adminId,
                'updatedBy'        => $adminId,
                'category_ids'     => [5],
            ],
            [
                'id'          => 4,
                'title'       => 'Smart Cleanrooms: The Future of Sterile Manufacturing',
                'slug'        => 'smart-cleanrooms-the-future-of-sterile-manufacturing',
                'short_des'   => 'How automated ventilation pressure balances safeguard biotech laboratories.',
                'description' => '<p>Biomedical research demands positive-pressure cleanrooms with automated laminar flow. Aire industrial filtration units provide seamless BMS integration, continuous differential pressure regulation, and fail-safe airflow monitoring.</p>',
                'meta_title'       => 'Smart Cleanrooms & Sterile Air Solutions | Aire',
                'meta_keyword'     => 'cleanroom ventilation, positive pressure, biotech air filtration, laminar flow',
                'meta_description' => 'Discover how Aire industrial ventilation systems empower next-generation biotech cleanrooms.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'Cleanroom Air Filtration',
                'publish_date'     => Carbon::now()->subDays(10),
                'status'           => '1',
                'createdBy'        => $adminId,
                'updatedBy'        => $adminId,
                'category_ids'     => [3],
            ],
            [
                'id'          => 5,
                'title'       => 'Tackling Seasonal Allergens and Airborne Wildfire Smoke',
                'slug'        => 'tackling-seasonal-allergens-and-airborne-wildfire-smoke',
                'short_des'   => 'Proven purification techniques to shield your family from micro-pollutants and smoke.',
                'description' => '<p>Wildfire smoke produces ultra-fine PM0.1 particles that penetrate standard AC filters. High-grade activated carbon and multi-stage HEPA scrubbers neutralise harmful odor gases and smoke particles instantly, ensuring pure breathable air indoors.</p>',
                'meta_title'       => 'Protecting Homes from Wildfire Smoke and Allergens | Aire',
                'meta_keyword'     => 'wildfire smoke filtration, seasonal allergies, PM2.5 protection, smoke air purifier',
                'meta_description' => 'How to safeguard your household against PM2.5 wildfire smoke, pollen, and airborne allergens with Aire purifiers.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'Smoke Filtration Air Purifier',
                'publish_date'     => Carbon::now()->subDays(12),
                'status'           => '1',
                'createdBy'        => $adminId,
                'updatedBy'        => $adminId,
                'category_ids'     => [4],
            ],
        ];

        foreach ($blogs as $b) {
            $catIds = $b['category_ids'];
            unset($b['category_ids']);
            $blog = Blog::create($b);
            if (!empty($catIds)) {
                $blog->syncCategories($catIds);
            }
        }
    }
}
