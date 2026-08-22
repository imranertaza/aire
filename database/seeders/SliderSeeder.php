<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        Slider::create([
            'key'         => 'category_sidebar',
            'image'       => 'themes/default/assets/img/featured/1.png',
            'title'       => 'The Future of Pure Living',
            'description' => 'Experience the pinnacle of air technology seamlessly integrated into your architectural vision. The AIRE Pro series.',
            'link'        => '/products',
            'order'       => 1,
            'enabled'     => 1,
        ]);

        Slider::create([
            'key'         => 'category_sidebar',
            'image'       => 'themes/default/assets/img/featured/2.png',
            'title'       => 'Smart Climate Control',
            'description' => 'Control your entire home\'s air quality directly from your smartphone with our new AIRE IoT integration. Pure air, instantly.',
            'link'        => '/product-filter',
            'order'       => 2,
            'enabled'     => 1,
        ]);

        Slider::create([
            'key'         => 'category_sidebar',
            'image'       => 'themes/default/assets/img/featured/3.png',
            'title'       => 'Enterprise Grade Purity',
            'description' => 'Deploy industrial-grade filtration disguised in beautiful architectural units designed specifically for modern corporate lobbies.',
            'link'        => '/category/solutions',
            'order'       => 3,
            'enabled'     => 1,
        ]);
    }
}
