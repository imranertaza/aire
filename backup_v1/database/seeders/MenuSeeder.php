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
        // 1. Header Menu
        Menu::updateOrCreate(
            ['name' => 'Main Header'],
            [
                'name'     => 'Main Header',
                'position' => 'header',
                'enabled'  => true,
            ]
        );

        // 2. AIRE Footer Menus (4 Columns)
        Menu::updateOrCreate(
            ['name' => 'SOLUTIONS'],
            [
                'name'     => 'SOLUTIONS',
                'position' => 'footer',
                'enabled'  => true,
            ]
        );

        Menu::updateOrCreate(
            ['name' => 'PRODUCTS'],
            [
                'name'     => 'PRODUCTS',
                'position' => 'footer',
                'enabled'  => true,
            ]
        );

        Menu::updateOrCreate(
            ['name' => 'COMPANY'],
            [
                'name'     => 'COMPANY',
                'position' => 'footer',
                'enabled'  => true,
            ]
        );

        Menu::updateOrCreate(
            ['name' => 'RESOURCES'],
            [
                'name'     => 'RESOURCES',
                'position' => 'footer',
                'enabled'  => true,
            ]
        );

        // 3. Footer Legal / Bottom Links
        Menu::updateOrCreate(
            ['name' => 'Footer Legal'],
            [
                'name'     => 'Footer Legal',
                'position' => 'footer_bottom',
                'enabled'  => true,
            ]
        );

        // 4. Floating Top Menu
        Menu::updateOrCreate(
            ['name' => 'Floating Top Menu'],
            [
                'name'     => 'Floating Top Menu',
                'position' => 'Floating Top',
                'enabled'  => true,
            ]
        );
    }
}
