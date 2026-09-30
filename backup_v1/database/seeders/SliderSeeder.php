<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sliders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ensure home slide images exist in public/storage/sliders/home
        $srcDir = public_path('themes/default/assets/img/slider');
        $homeDestDir = public_path('storage/sliders/home');
        if (!File::exists($homeDestDir)) {
            File::makeDirectory($homeDestDir, 0755, true);
        }
        foreach ([1, 2, 3] as $id) {
            $srcFile = "{$srcDir}/slide-{$id}.jpg";
            $destFile = "{$homeDestDir}/slide-{$id}.jpg";
            if (File::exists($srcFile) && !File::exists($destFile)) {
                File::copy($srcFile, $destFile);
            }
        }

        // ==========================================
        // 1. ORIGINAL SIDEBAR / CATALOG AD SLIDERS
        // ==========================================
        Slider::create([
            'key'         => 'category_sidebar,featured_ad,about_us,products,filter,compare,favorite',
            'image'       => 'sliders/1/images/slider_image_6a86800198ad7.png',
            'title'       => 'The Future of Pure Living',
            'subtitle'    => null,
            'description' => 'Experience the pinnacle of air technology seamlessly integrated into your architectural vision. The AIRE Pro series.',
            'link'        => '/products',
            'button_text' => null,
            'order'       => 1,
            'enabled'     => 0,
        ]);

        Slider::create([
            'key'         => 'category_sidebar,featured_ad,about_us,compare,products,filter,favorite',
            'image'       => 'sliders/2/images/slider_image_6a86800ba8ba3.png',
            'title'       => 'Smart Climate Control',
            'subtitle'    => null,
            'description' => "Control your entire home's air quality directly from your smartphone with our new AIRE IoT integration. Pure air, instantly.",
            'link'        => '/products-filter',
            'button_text' => null,
            'order'       => 2,
            'enabled'     => 0,
        ]);

        Slider::create([
            'key'         => 'category_sidebar,featured_ad,about_us,compare,products,filter,favorite',
            'image'       => 'sliders/3/images/slider_image_6a868016dd9da.png',
            'title'       => 'Enterprise Grade Purity',
            'subtitle'    => null,
            'description' => 'Deploy industrial-grade filtration disguised in beautiful architectural units designed specifically for modern corporate lobbies.',
            'link'        => '/category/solutions',
            'button_text' => null,
            'order'       => 3,
            'enabled'     => 0,
        ]);

        // ==========================================
        // 2. SEPARATE HOMEPAGE HERO SLIDERS
        // ==========================================
        Slider::create([
            'key'         => 'banner_section',
            'image'       => 'sliders/home/slide-1.jpg',
            'title'       => 'Pure Air, Pure Life',
            'subtitle'    => 'Close-up purifier with cinematic gradient background.',
            'description' => 'Experience the pinnacle of air technology seamlessly integrated into your architectural vision. The AIRE Pro series.',
            'link'        => '/products-filter',
            'button_text' => 'Shop Now',
            'order'       => 1,
            'enabled'     => 1,
        ]);

        Slider::create([
            'key'         => 'banner_section',
            'image'       => 'sliders/home/slide-2.jpg',
            'title'       => 'Breathe Healthy, Live Clean',
            'subtitle'    => 'Medical-grade multi-layer HEPA filtration engineered for modern family living.',
            'description' => "Control your entire home's air quality directly from your smartphone with our new AIRE IoT integration. Pure air, instantly.",
            'link'        => '/products-filter',
            'button_text' => 'Shop Now',
            'order'       => 2,
            'enabled'     => 1,
        ]);

        Slider::create([
            'key'         => 'banner_section',
            'image'       => 'sliders/home/slide-3.jpg',
            'title'       => 'Whisper Quiet, Absolute Purity',
            'subtitle'    => 'Advanced purification eliminating 99.97% of airborne allergens and dust.',
            'description' => 'Deploy industrial-grade filtration disguised in beautiful architectural units designed specifically for modern corporate lobbies.',
            'link'        => '/category/solutions',
            'button_text' => 'Shop Now',
            'order'       => 3,
            'enabled'     => 1,
        ]);

        // Invalidate slider caches
        Slider::clearCache();
    }
}
