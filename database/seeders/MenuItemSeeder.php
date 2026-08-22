<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headerMenu = Menu::where('position', 'header')->first();
        $footerSolutions = Menu::where('name', 'SOLUTIONS')->where('position', 'footer')->first();
        $footerProducts = Menu::where('name', 'PRODUCTS')->where('position', 'footer')->first();
        $footerCompany = Menu::where('name', 'COMPANY')->where('position', 'footer')->first();
        $footerResources = Menu::where('name', 'RESOURCES')->where('position', 'footer')->first();
        $footerLegal = Menu::where('name', 'Footer Legal')->orWhere('position', 'footer_bottom')->first();

        // Fallback if footer menus were named lowercase
        if (!$footerSolutions) $footerSolutions = Menu::where('position', 'footer')->skip(0)->first();
        if (!$footerProducts) $footerProducts = Menu::where('position', 'footer')->skip(1)->first();
        if (!$footerCompany) $footerCompany = Menu::where('position', 'footer')->skip(2)->first();
        if (!$footerResources) $footerResources = Menu::where('position', 'footer')->skip(3)->first();

        /**
         * 1. Header Menu Items
         */
        if ($headerMenu) {
            MenuItem::where('menu_id', $headerMenu->id)->delete();

            $headerItems = [
                ['name' => 'Solutions', 'url' => '/category/solutions', 'order' => 1],
                ['name' => 'Products', 'url' => '/category/products', 'order' => 2],
                ['name' => 'Industries', 'url' => '/category/industries', 'order' => 3],
                ['name' => 'Technologies', 'url' => '/category/technologies', 'order' => 4],
                ['name' => 'Resources', 'url' => '/docs', 'order' => 5],
                ['name' => 'About', 'url' => '/about', 'order' => 6],
            ];

            foreach ($headerItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $headerMenu->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $headerMenu->id,
                        'name'      => $item['name'],
                        'link_type' => 'url',
                        'url'       => $item['url'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        /**
         * 2. Footer Menu Column 1: SOLUTIONS
         */
        if ($footerSolutions) {
            $solutionsItems = [
                ['name' => 'Residential', 'url' => '/solutions', 'order' => 1],
                ['name' => 'Commercial', 'url' => '/solutions', 'order' => 2],
                ['name' => 'Healthcare', 'url' => '/solutions', 'order' => 3],
                ['name' => 'Infrastructure', 'url' => '/solutions', 'order' => 4],
                ['name' => 'Industrial', 'url' => '/solutions', 'order' => 5],
                ['name' => 'Site Map', 'url' => '/solutions', 'order' => 6],
            ];

            foreach ($solutionsItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerSolutions->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerSolutions->id,
                        'name'      => $item['name'],
                        'link_type' => 'url',
                        'url'       => $item['url'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        /**
         * 3. Footer Menu Column 2: PRODUCTS
         */
        if ($footerProducts) {
            $productItems = [
                ['name' => 'Residential', 'url' => '/product-filter?industry=residential', 'order' => 1],
                ['name' => 'Commercial', 'url' => '/product-filter?industry=commercial', 'order' => 2],
                ['name' => 'Healthcare', 'url' => '/product-filter?industry=healthcare', 'order' => 3],
                ['name' => 'Infrastructure', 'url' => '/product-filter', 'order' => 4],
                ['name' => 'Industrial', 'url' => '/product-filter', 'order' => 5],
                ['name' => 'Site Map', 'url' => '/products', 'order' => 6],
            ];

            foreach ($productItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerProducts->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerProducts->id,
                        'name'      => $item['name'],
                        'link_type' => 'url',
                        'url'       => $item['url'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        /**
         * 4. Footer Menu Column 3: COMPANY
         */
        if ($footerCompany) {
            $companyItems = [
                ['name' => 'About Us', 'url' => '/about', 'order' => 1],
                ['name' => 'Sustainability', 'url' => '/about', 'order' => 2],
                ['name' => 'Careers', 'url' => '/about', 'order' => 3],
                ['name' => 'Global Locations', 'url' => '/about', 'order' => 4],
            ];

            foreach ($companyItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerCompany->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerCompany->id,
                        'name'      => $item['name'],
                        'link_type' => 'url',
                        'url'       => $item['url'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        /**
         * 5. Footer Menu Column 4: RESOURCES
         */
        if ($footerResources) {
            $resourceItems = [
                ['name' => 'Technology', 'url' => '/solutions', 'order' => 1],
                ['name' => 'Monitoring', 'url' => '/solutions', 'order' => 2],
                ['name' => 'Documentation', 'url' => '/docs', 'order' => 3],
                ['name' => 'Compare Systems', 'url' => '/compare', 'order' => 4],
            ];

            foreach ($resourceItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerResources->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerResources->id,
                        'name'      => $item['name'],
                        'link_type' => 'url',
                        'url'       => $item['url'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        /**
         * 6. Footer Legal Links (Bottom bar)
         */
        if ($footerLegal) {
            $legalItems = [
                ['name' => 'Privacy Policy', 'url' => '/docs', 'order' => 1],
                ['name' => 'Terms of Service', 'url' => '/docs', 'order' => 2],
            ];

            foreach ($legalItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerLegal->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerLegal->id,
                        'name'      => $item['name'],
                        'link_type' => 'url',
                        'url'       => $item['url'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }
    }
}
