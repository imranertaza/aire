<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            // Core E-Commerce & System Modules (1-19)
            ['id' => 1,  'name' => 'Points',                'module_key' => 'point',                 'status' => 0],
            ['id' => 2,  'name' => 'Top Search',            'module_key' => 'top_search',            'status' => 1],
            ['id' => 3,  'name' => 'Wishlist',              'module_key' => 'wishlist',              'status' => 1],
            ['id' => 4,  'name' => 'Compare',               'module_key' => 'compare',               'status' => 1],
            ['id' => 5,  'name' => 'Bulk Edit Products',    'module_key' => 'bulk_edit_products',    'status' => 1],
            ['id' => 6,  'name' => 'Contact With Whatsapp', 'module_key' => 'contact_with_whatsapp', 'status' => 1],
            ['id' => 7,  'name' => 'Coupon',                'module_key' => 'coupon',                'status' => 0],
            ['id' => 8,  'name' => 'Image Crop',            'module_key' => 'image_crop',            'status' => 1],
            ['id' => 9,  'name' => 'Review',                'module_key' => 'review',                'status' => 1],
            ['id' => 10, 'name' => 'Multi option',          'module_key' => 'multi_option',          'status' => 1],
            ['id' => 11, 'name' => 'Multi attribute',       'module_key' => 'multi_attribute',       'status' => 1],
            ['id' => 12, 'name' => 'Watermark Image',       'module_key' => 'watermark',             'status' => 1],
            ['id' => 13, 'name' => 'Multi Category',        'module_key' => 'multi_category',        'status' => 1],
            ['id' => 14, 'name' => 'Album',                 'module_key' => 'album',                 'status' => 1],
            ['id' => 15, 'name' => 'Multi Status Update',   'module_key' => 'multi_status_update',   'status' => 1],
            ['id' => 16, 'name' => 'Blog',                  'module_key' => 'blog',                  'status' => 1],
            ['id' => 17, 'name' => 'Both Products',         'module_key' => 'both_products',         'status' => 1],
            ['id' => 18, 'name' => 'Product Guides',        'module_key' => 'product_guides',        'status' => 1],
            ['id' => 19, 'name' => 'Other Products',        'module_key' => 'other_products',        'status' => 1],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('module_settings')->truncate();
        DB::table('modules')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Seed or update all modules first
        foreach ($modules as $module) {
            DB::table('modules')->insert([
                'id'         => $module['id'],
                'name'       => $module['name'],
                'module_key' => $module['module_key'],
                'status'     => $module['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Define settings using 'module_key' instead of hardcoded IDs
        $moduleSettings = [
            [
                'module_key'  => 'point',
                'setting_key' => 'point_par_doller',
                'title'       => 'Point Par Doller ($1)',
                'value'       => '1',
            ],
            [
                'module_key'  => 'contact_with_whatsapp',
                'setting_key' => 'whatsapp_number',
                'title'       => 'Whatsapp number',
                'value'       => '01923121212',
            ],
        ];

        // 3. Dynamically fetch the module ID and insert/update settings safely
        foreach ($moduleSettings as $setting) {
            $moduleId = DB::table('modules')
                ->where('module_key', $setting['module_key'])
                ->value('id');

            if ($moduleId) {
                DB::table('module_settings')->insert([
                    'module_id'   => $moduleId,
                    'setting_key' => $setting['setting_key'],
                    'title'      => $setting['title'],
                    'value'      => $setting['value'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
