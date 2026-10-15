<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Main Header Menu
        $headerMenu = Menu::where('name', 'Main Header')->where('position', 'header')->first();
        if ($headerMenu) {
            $headerItems = [
                ['name' => 'Solutions', 'link_type' => 'url', 'url' => '/category/solutions', 'page_id' => null, 'order' => 1],
                ['name' => 'Products', 'link_type' => 'url', 'url' => '/category/products', 'page_id' => null, 'order' => 2],
                ['name' => 'Industries', 'link_type' => 'url', 'url' => '/category/industries', 'page_id' => null, 'order' => 3],
                ['name' => 'Technologies', 'link_type' => 'url', 'url' => '/category/technologies', 'page_id' => null, 'order' => 4],
                ['name' => 'Resources', 'link_type' => 'url', 'url' => '/docs', 'page_id' => null, 'order' => 5],
                ['name' => 'About', 'link_type' => 'url', 'url' => '/about', 'page_id' => null, 'order' => 6],
            ];

            foreach ($headerItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $headerMenu->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $headerMenu->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 2. SOLUTIONS (Footer Column 1)
        $footerSolutions = Menu::where('name', 'SOLUTIONS')->where('position', 'footer')->first();
        if ($footerSolutions) {
            $solutionsItems = [
                ['name' => 'Residential', 'link_type' => 'url', 'url' => '/solutions', 'page_id' => null, 'order' => 1],
                ['name' => 'Commercial', 'link_type' => 'url', 'url' => '/solutions', 'page_id' => null, 'order' => 2],
                ['name' => 'Healthcare', 'link_type' => 'url', 'url' => '/solutions', 'page_id' => null, 'order' => 3],
                ['name' => 'Infrastructure', 'link_type' => 'url', 'url' => '/solutions', 'page_id' => null, 'order' => 4],
                ['name' => 'Industrial', 'link_type' => 'url', 'url' => '/solutions', 'page_id' => null, 'order' => 5],
                ['name' => 'Site Map', 'link_type' => 'url', 'url' => '/solutions', 'page_id' => null, 'order' => 6],
            ];

            foreach ($solutionsItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerSolutions->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerSolutions->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 3. PRODUCTS (Footer Column 2)
        $footerProducts = Menu::where('name', 'PRODUCTS')->where('position', 'footer')->first();
        if ($footerProducts) {
            $productItems = [
                ['name' => 'Residential', 'link_type' => 'url', 'url' => '/product-filter?industry=residential', 'page_id' => null, 'order' => 1],
                ['name' => 'Commercial', 'link_type' => 'url', 'url' => '/product-filter?industry=commercial', 'page_id' => null, 'order' => 2],
                ['name' => 'Healthcare', 'link_type' => 'url', 'url' => '/product-filter?industry=healthcare', 'page_id' => null, 'order' => 3],
                ['name' => 'Infrastructure', 'link_type' => 'url', 'url' => '/product-filter', 'page_id' => null, 'order' => 4],
                ['name' => 'Industrial', 'link_type' => 'url', 'url' => '/product-filter', 'page_id' => null, 'order' => 5],
                ['name' => 'Site Map', 'link_type' => 'url', 'url' => '/products', 'page_id' => null, 'order' => 6],
            ];

            foreach ($productItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerProducts->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerProducts->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 4. COMPANY (Footer Column 3)
        $footerCompany = Menu::where('name', 'COMPANY')->where('position', 'footer')->first();
        if ($footerCompany) {
            $companyItems = [
                ['name' => 'About Us', 'link_type' => 'url', 'url' => '/about', 'page_id' => null, 'order' => 1],
                ['name' => 'Sustainability', 'link_type' => 'url', 'url' => '/about', 'page_id' => null, 'order' => 2],
                ['name' => 'Careers', 'link_type' => 'url', 'url' => '/about', 'page_id' => null, 'order' => 3],
                ['name' => 'Global Locations', 'link_type' => 'url', 'url' => '/about', 'page_id' => null, 'order' => 4],
            ];

            foreach ($companyItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerCompany->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerCompany->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 5. POLICIES & LEGAL (Footer Column 4 & Legal Page Side Navigation)
        $footerLegalPolicies = Menu::where('name', 'POLICIES & LEGAL')->where('position', 'footer')->first();
        if ($footerLegalPolicies) {
            $legalItems = [
                [
                    'name'      => 'Terms of Service',
                    'link_type' => 'page',
                    'slug'      => 'terms-of-service',
                    'fallback_id' => 7,
                    'url'       => 'https://aire.test/pages/terms-of-service',
                    'order'     => 1,
                ],
                [
                    'name'      => 'Privacy Policy',
                    'link_type' => 'page',
                    'slug'      => 'privacy-policy',
                    'fallback_id' => 6,
                    'url'       => 'https://aire.test/pages/privacy-policy',
                    'order'     => 2,
                ],
                [
                    'name'      => 'Cookie Policy',
                    'link_type' => 'page',
                    'slug'      => 'cookie-policy',
                    'fallback_id' => 5,
                    'url'       => 'https://aire.test/pages/cookie-policy',
                    'order'     => 3,
                ],
                [
                    'name'      => 'Modern Slavery Statement',
                    'link_type' => 'page',
                    'slug'      => 'modern-slavery-statement',
                    'fallback_id' => 9,
                    'url'       => 'https://aire.test/pages/modern-slavery-statement',
                    'order'     => 4,
                ],
                [
                    'name'      => 'Data Protection',
                    'link_type' => 'page',
                    'slug'      => 'data-protection',
                    'fallback_id' => 8,
                    'url'       => 'https://aire.test/pages/data-protection',
                    'order'     => 5,
                ],
                [
                    'name'      => 'Export Compliance',
                    'link_type' => 'page',
                    'slug'      => 'export-compliance',
                    'fallback_id' => 10,
                    'url'       => 'https://aire.test/pages/export-compliance',
                    'order'     => 6,
                ],
                [
                    'name'      => 'Legal Notice',
                    'link_type' => 'page',
                    'slug'      => 'legal-notice',
                    'fallback_id' => 11,
                    'url'       => 'https://aire.test/pages/legal-notice',
                    'order'     => 7,
                ],
                [
                    'name'      => 'Website Teams',
                    'link_type' => 'page',
                    'slug'      => 'terms-of-use',
                    'fallback_id' => 12,
                    'url'       => 'https://aire.test/pages/terms-of-use',
                    'order'     => 8,
                ],
            ];

            foreach ($legalItems as $item) {
                $pageId = Page::where('slug', $item['slug'])->value('id') ?? $item['fallback_id'];

                MenuItem::updateOrCreate(
                    ['menu_id' => $footerLegalPolicies->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerLegalPolicies->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'page_id'   => $pageId,
                        'url'       => $item['url'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 6. Footer Legal (Bottom Bar)
        $footerBottomLegal = Menu::where('name', 'Footer Legal')->where('position', 'footer_bottom')->first();
        if ($footerBottomLegal) {
            $bottomLegalItems = [
                ['name' => 'Privacy Policy', 'link_type' => 'url', 'url' => '/docs', 'page_id' => null, 'order' => 1],
                ['name' => 'Terms of Service', 'link_type' => 'url', 'url' => '/docs', 'page_id' => null, 'order' => 2],
            ];

            foreach ($bottomLegalItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerBottomLegal->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerBottomLegal->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 7. Industries Menu (Footer / Extra)
        $industriesMenu = Menu::where('name', 'Industries')->where('position', 'Footer')->first();
        if ($industriesMenu) {
            $industriesItems = [
                ['name' => 'Health & Wellbeing', 'link_type' => 'url', 'url' => '/', 'page_id' => null, 'order' => 0],
                ['name' => 'Energy Efficiency', 'link_type' => 'url', 'url' => '/', 'page_id' => null, 'order' => 0],
                ['name' => 'Sick Building Prevention', 'link_type' => 'url', 'url' => '/', 'page_id' => null, 'order' => 0],
            ];

            foreach ($industriesItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $industriesMenu->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $industriesMenu->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }
    }
}
