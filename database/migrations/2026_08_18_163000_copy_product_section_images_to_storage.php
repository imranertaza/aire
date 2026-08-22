<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $targetDir = storage_path('app/public/products');
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        // Map of source theme image -> target storage filename
        $imagesToCopy = [
            public_path('themes/default/assets/img/products/features.png')               => $targetDir . '/features.png',
            public_path('themes/default/assets/img/airpro_mask_fb2.png')                => $targetDir . '/airpro_mask_fb2.png',
            public_path('themes/default/assets/img/products/technology.png')            => $targetDir . '/technology.png',
            public_path('themes/default/assets/img/products/R&D Laboratories1.png')      => $targetDir . '/rd_laboratories.png',
            public_path('themes/default/assets/img/products/Precision Manufacturing.png') => $targetDir . '/precision_manufacturing.png',
            public_path('themes/default/assets/img/products/Urban Mobility.png')        => $targetDir . '/urban_mobility.png',
        ];

        foreach ($imagesToCopy as $src => $dest) {
            if (File::exists($src) && !File::exists($dest)) {
                File::copy($src, $dest);
            }
        }

        // Also copy directly to public/storage/products if public/storage is a direct directory
        $publicStorageDir = public_path('storage/products');
        if (File::exists(public_path('storage')) && !is_link(public_path('storage'))) {
            if (!File::exists($publicStorageDir)) {
                File::makeDirectory($publicStorageDir, 0755, true);
            }
            foreach ($imagesToCopy as $src => $dest) {
                $destPublic = $publicStorageDir . '/' . basename($dest);
                if (File::exists($src) && !File::exists($destPublic)) {
                    File::copy($src, $destPublic);
                }
            }
        }

        // Update database records in product_descriptions
        if (Schema::hasTable('product_descriptions')) {
            $updateData = [];
            if (Schema::hasColumn('product_descriptions', 'features_image')) {
                DB::table('product_descriptions')
                    ->where('features_image', 'like', '%features.png%')
                    ->orWhereNull('features_image')
                    ->orWhere('features_image', '')
                    ->update(['features_image' => 'products/features.png']);
            }
            if (Schema::hasColumn('product_descriptions', 'technology_image')) {
                DB::table('product_descriptions')
                    ->where('technology_image', 'like', '%airpro_mask_fb2.png%')
                    ->orWhere('technology_image', 'like', '%technology.png%')
                    ->orWhereNull('technology_image')
                    ->orWhere('technology_image', '')
                    ->update(['technology_image' => 'products/airpro_mask_fb2.png']);
            }
        }

        // Update database records in product_applications
        if (Schema::hasTable('product_applications')) {
            DB::table('product_applications')
                ->where('title', 'like', '%R&D%')
                ->update([
                    'image'    => 'products/rd_laboratories.png',
                    'bg_image' => 'products/rd_laboratories.png',
                ]);

            DB::table('product_applications')
                ->where('title', 'like', '%Manufacturing%')
                ->update([
                    'image'    => 'products/precision_manufacturing.png',
                    'bg_image' => 'products/precision_manufacturing.png',
                ]);

            DB::table('product_applications')
                ->where('title', 'like', '%Mobility%')
                ->update([
                    'image'    => 'products/urban_mobility.png',
                    'bg_image' => 'products/urban_mobility.png',
                ]);
        }
    }

    public function down(): void
    {
        // No-op
    }
};
