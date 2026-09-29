<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // -----------------------------------
        // 1. Create Categories
        // -----------------------------------
        $categories = [
            ['category_name' => 'Air Quality & Health', 'parent_id' => null, 'status' => 1],
            ['category_name' => 'Filtration Technology', 'parent_id' => null, 'status' => 1],
            ['category_name' => 'Smart Cleanrooms', 'parent_id' => null, 'status' => 1],
            ['category_name' => 'HVAC & Ventilation', 'parent_id' => null, 'status' => 1],
            ['category_name' => 'Guides & Maintenance', 'parent_id' => null, 'status' => 1],
        ];

        foreach ($categories as $cat) {
            $cat['slug'] = Str::slug($cat['category_name']);
            BlogCategory::create($cat);
        }

        // -----------------------------------
        // 2. Create Blogs
        // -----------------------------------
        $blogs = [
            [
                'title'       => 'Understanding HEPA H13 vs H14 Filtration Standards',
                'short_des'   => 'Discover the scientific differences between True HEPA H13 and medical-grade H14 filters.',
                'description' => '<p>When evaluating clean air performance, particle capture efficiency is critical. HEPA H13 filters capture 99.95% of particulates down to 0.1 microns, while H14 filters achieve 99.995% efficiency, making them the standard choice for semiconductor cleanrooms and surgical suites...</p>',
                'meta_title'       => 'HEPA H13 vs H14 Filtration Standards Explained | Aire',
                'meta_keyword'     => 'HEPA H13, HEPA H14, air filtration efficiency, cleanroom standards',
                'meta_description' => 'A comprehensive guide explaining the efficiency, airflow, and applications of HEPA H13 and H14 filtration.',
                'image' => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'HEPA Filter Cross Section',
                'publish_date'     => Carbon::now()->subDays(2),
                'createdBy'        => 1,
                'updatedBy'        => null,
            ],
            [
                'title'       => 'How Indoor Air Quality Impacts Workplace Productivity',
                'short_des'   => 'New environmental research reveals how reducing CO2 and PM2.5 enhances cognitive performance.',
                'description' => '<p>Modern offices often trap volatile organic compounds (VOCs) and carbon dioxide. Installing smart IAQ continuous filtration systems increases oxygenation, cuts absenteeism, and boosts overall team focus by up to 25%...</p>',
                'meta_title'       => 'Indoor Air Quality and Workplace Productivity | Aire',
                'meta_keyword'     => 'indoor air quality, workplace wellness, IAQ monitoring, office air purifier',
                'meta_description' => 'Explore the scientific correlation between purified indoor air, reduced CO2 levels, and workplace cognitive productivity.',
                'image' => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'Modern Office Air Quality System',
                'publish_date'     => Carbon::now()->subDays(5),
                'createdBy'        => 1,
                'updatedBy'        => null,
            ],
            [
                'title'       => 'The Essential Guide to Purifier Filter Replacement and Care',
                'short_des'   => 'Maximize the lifespan and airflow efficiency of your residential and commercial purifiers.',
                'description' => '<p>Maintaining optimal airflow requires timely pre-filter vacuuming and periodic carbon block replacement. Learn how Aire IoT sensors automatically calculate filter saturation based on real particle density...</p>',
                'meta_title'       => 'Air Purifier Maintenance & Filter Replacement Guide | Aire',
                'meta_keyword'     => 'filter replacement, air purifier maintenance, HEPA lifespan, clean air tips',
                'meta_description' => 'Essential maintenance tips to keep your air purifiers running silently and capturing allergens effectively.',
                'image' => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'Filter Replacement Process',
                'publish_date'     => Carbon::now()->subDays(7),
                'createdBy'        => 1,
                'updatedBy'        => null,
            ],
            [
                'title'       => 'Smart Cleanrooms: The Future of Sterile Manufacturing',
                'short_des'   => 'How automated ventilation pressure balances safeguard biotech laboratories.',
                'description' => '<p>Biomedical research demands positive-pressure cleanrooms with automated laminar flow. Aire industrial filtration units provide seamless BMS integration and fail-safe airflow monitoring...</p>',
                'meta_title'       => 'Smart Cleanrooms & Sterile Air Solutions | Aire',
                'meta_keyword'     => 'cleanroom ventilation, positive pressure, biotech air filtration, laminar flow',
                'meta_description' => 'Discover how Aire industrial ventilation systems empower next-generation biotech cleanrooms.',
                'image' => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'Cleanroom Air Filtration',
                'publish_date'     => Carbon::now()->subDays(10),
                'createdBy'        => 1,
                'updatedBy'        => null,
            ],
            [
                'title'       => 'Tackling Seasonal Allergens and Airborne Wildfire Smoke',
                'short_des'   => 'Proven purification techniques to shield your family from micro-pollutants and smoke.',
                'description' => '<p>Wildfire smoke produces ultra-fine PM0.1 particles that penetrate standard AC filters. High-grade activated carbon and multi-stage HEPA scrubbers neutralise harmful odor gases and smoke particles instantly...</p>',
                'meta_title'       => 'Protecting Homes from Wildfire Smoke and Allergens | Aire',
                'meta_keyword'     => 'wildfire smoke filtration, seasonal allergies, PM2.5 protection, smoke air purifier',
                'meta_description' => 'How to safeguard your household against PM2.5 wildfire smoke, pollen, and airborne allergens with Aire purifiers.',
                'image' => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/Air-Purify.png',
                'alt_name'         => 'Smoke Filtration Air Purifier',
                'publish_date'     => Carbon::now()->subDays(12),
                'createdBy'        => 1,
                'updatedBy'        => null,
            ],
        ];

        foreach ($blogs as $blogData) {
            $blogData['slug'] = Str::slug($blogData['title']);
            $blogData['status'] = "1";
            $blog = Blog::create($blogData);

            // Auto-category matching
            if (str_contains(strtolower($blog->title), 'hepa') || str_contains(strtolower($blog->title), 'technology')) {
                $blog->syncCategories([2]); // Filtration Technology
            } elseif (str_contains(strtolower($blog->title), 'productivity') || str_contains(strtolower($blog->title), 'workplace')) {
                $blog->syncCategories([1]); // Air Quality & Health
            } elseif (str_contains(strtolower($blog->title), 'guide') || str_contains(strtolower($blog->title), 'maintenance')) {
                $blog->syncCategories([5]); // Guides & Maintenance
            } elseif (str_contains(strtolower($blog->title), 'cleanroom')) {
                $blog->syncCategories([3]); // Smart Cleanrooms
            } else {
                $blog->syncCategories([4]); // HVAC & Ventilation
            }
        }
    }
}
