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
            ['id' => 1, 'name' => 'Top Search', 'module_key' => 'top_search', 'status' => 1],
            ['id' => 2, 'name' => 'Wishlist', 'module_key' => 'wishlist', 'status' => 1],
            ['id' => 3, 'name' => 'Compare', 'module_key' => 'compare', 'status' => 1],
            ['id' => 4, 'name' => 'Bulk Edit Products', 'module_key' => 'bulk_edit_products', 'status' => 1],
            ['id' => 5, 'name' => 'Contact With Whatsapp', 'module_key' => 'contact_with_whatsapp', 'status' => 1],
            ['id' => 6, 'name' => 'Coupon', 'module_key' => 'coupon', 'status' => 1],
            ['id' => 7, 'name' => 'Image Crop', 'module_key' => 'image_crop', 'status' => 1],
            ['id' => 8, 'name' => 'Review', 'module_key' => 'review', 'status' => 1],
            ['id' => 9, 'name' => 'Multi option', 'module_key' => 'multi_option', 'status' => 1],
            ['id' => 10, 'name' => 'Multi attribute', 'module_key' => 'multi_attribute', 'status' => 1],
            ['id' => 11, 'name' => 'Watermark Image', 'module_key' => 'watermark', 'status' => 1],
            ['id' => 12, 'name' => 'Multi Category', 'module_key' => 'multi_category', 'status' => 1],
            ['id' => 13, 'name' => 'Album', 'module_key' => 'album', 'status' => 1],
            ['id' => 14, 'name' => 'Multi Status Update', 'module_key' => 'multi_status_update', 'status' => 1],
            ['id' => 15, 'name' => 'Blog', 'module_key' => 'blog', 'status' => 1],
            ['id' => 16, 'name' => 'Points', 'module_key' => 'point', 'status' => 1],
            ['id' => 17, 'name' => 'Both Products', 'module_key' => 'both_products', 'status' => 1],
            ['id' => 18, 'name' => 'Product Guides', 'module_key' => 'product_guides', 'status' => 1],
            ['id' => 19, 'name' => 'Other Products', 'module_key' => 'other_products', 'status' => 1],
        ];

        DB::table('modules')->insertOrIgnore($modules);

        $moduleSettings = [
            [
                'module_id' => 5,
                'setting_key' => 'whatsapp_number',
                'title' => 'Whatsapp number',
                'value' => '01923121212',
                'created_at' => '2023-10-08 09:56:20',
                'updated_at' => '2023-12-04 11:01:27',
            ],
            [
                'module_id' => 16,
                'setting_key' => 'point_par_doller',
                'title' => 'Point Par Doller ($1)',
                'value' => '1',
                'created_at' => '2025-03-03 12:11:36',
                'updated_at' => '2025-04-05 10:47:12',
            ],
        ];

        // Use updateOrInsert to update if setting_key exists, or insert if not
        foreach ($moduleSettings as $setting) {
            DB::table('module_settings')->updateOrInsert(
                ['setting_key' => $setting['setting_key']], // Match by setting_key
                $setting // Insert or update values
            );
        }
    }
}
