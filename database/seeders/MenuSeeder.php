<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name'     => 'Main Header',
                'position' => 'header',
                'enabled'  => true,
            ],
            [
                'name'     => 'COMPANY',
                'position' => 'footer',
                'enabled'  => true,
            ],
            [
                'name'     => 'POLICIES & LEGAL',
                'position' => 'footer',
                'enabled'  => true,
            ],
            [
                'name'     => 'Footer Legal',
                'position' => 'footer_bottom',
                'enabled'  => true,
            ],
            [
                'name'     => 'Floating Top Menu',
                'position' => 'Floating Top',
                'enabled'  => true,
            ],
            [
                'name'     => 'Industries',
                'position' => 'Footer',
                'enabled'  => true,
            ],
            [
                'name'     => 'GET IN TOUCH',
                'position' => 'footer',
                'enabled'  => true,
            ],
            [
                'name'     => 'CUSTOMER CARE',
                'position' => 'footer',
                'enabled'  => true,
            ],
        ];

        foreach ($menus as $menuData) {
            Menu::updateOrCreate(
                ['name' => $menuData['name'], 'position' => $menuData['position']],
                $menuData
            );
        }
    }
}
