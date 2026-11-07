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
                ['name' => 'Resources', 'link_type' => 'url', 'url' => '/resources', 'page_id' => null, 'order' => 5],
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


        // 2. COMPANY (Footer)
        $footerCompany = Menu::where('name', 'COMPANY')->where('position', 'footer')->first();
        if ($footerCompany) {
            $companyItems = [
                ['name' => 'About Us', 'link_type' => 'url', 'url' => '/about', 'icon' => 'bi-building', 'page_id' => null, 'order' => 1],
                ['name' => 'Sustainability', 'link_type' => 'url', 'url' => '/about', 'icon' => 'bi-recycle', 'page_id' => null, 'order' => 2],
                ['name' => 'Careers', 'link_type' => 'url', 'url' => '/about', 'icon' => 'bi-briefcase', 'page_id' => null, 'order' => 3],
                ['name' => 'Global Locations', 'link_type' => 'url', 'url' => '/about', 'icon' => 'bi-globe-americas', 'page_id' => null, 'order' => 4],
            ];

            foreach ($companyItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $footerCompany->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $footerCompany->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'icon'      => $item['icon'] ?? null,
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 3. POLICIES & LEGAL (Footer & Legal Page Side Navigation)
        $footerLegalPolicies = Menu::where('name', 'POLICIES & LEGAL')->where('position', 'footer')->first();
        if ($footerLegalPolicies) {
            // Clean up any legacy misnamed items like 'Website Teams'
            MenuItem::where('menu_id', $footerLegalPolicies->id)->where('name', 'Website Teams')->delete();

            $legalItems = [
                [
                    'name'        => 'Terms of Service',
                    'icon'        => 'bi-file-earmark-text',
                    'link_type'   => 'page',
                    'slug'        => 'terms-of-service',
                    'fallback_id' => 7,
                    'url'         => '/pages/terms-of-service',
                    'order'       => 1,
                ],
                [
                    'name'        => 'Privacy Policy',
                    'icon'        => 'bi-lock',
                    'link_type'   => 'page',
                    'slug'        => 'privacy-policy',
                    'fallback_id' => 6,
                    'url'         => '/pages/privacy-policy',
                    'order'       => 2,
                ],
                [
                    'name'        => 'Cookie Policy',
                    'icon'        => 'bi-shield-check',
                    'link_type'   => 'page',
                    'slug'        => 'cookie-policy',
                    'fallback_id' => 5,
                    'url'         => '/pages/cookie-policy',
                    'order'       => 3,
                ],
                [
                    'name'        => 'Modern Slavery Statement',
                    'icon'        => 'bi-globe2',
                    'link_type'   => 'page',
                    'slug'        => 'modern-slavery-statement',
                    'fallback_id' => 9,
                    'url'         => '/pages/modern-slavery-statement',
                    'order'       => 4,
                ],
                [
                    'name'        => 'Data Protection',
                    'icon'        => 'bi-shield-lock',
                    'link_type'   => 'page',
                    'slug'        => 'data-protection',
                    'fallback_id' => 8,
                    'url'         => '/pages/data-protection',
                    'order'       => 5,
                ],
                [
                    'name'        => 'Export Compliance',
                    'icon'        => 'bi-check2-circle',
                    'link_type'   => 'page',
                    'slug'        => 'export-compliance',
                    'fallback_id' => 10,
                    'url'         => '/pages/export-compliance',
                    'order'       => 6,
                ],
                [
                    'name'        => 'Legal Notice',
                    'icon'        => 'bi-info-circle',
                    'link_type'   => 'page',
                    'slug'        => 'legal-notice',
                    'fallback_id' => 11,
                    'url'         => '/pages/legal-notice',
                    'order'       => 7,
                ],
                [
                    'name'        => 'Website Terms of Use',
                    'icon'        => 'bi-journal-text',
                    'link_type'   => 'page',
                    'slug'        => 'terms-of-use',
                    'fallback_id' => 12,
                    'url'         => '/pages/terms-of-use',
                    'order'       => 8,
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
                        'icon'      => $item['icon'] ?? null,
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 4. Footer Legal (Bottom Bar)
        $footerBottomLegal = Menu::where('name', 'Footer Legal')->where('position', 'footer_bottom')->first();
        if ($footerBottomLegal) {
            $privacyPageId = Page::where('slug', 'privacy-policy')->value('id');
            $termsPageId = Page::where('slug', 'terms-of-service')->value('id');

            $bottomLegalItems = [
                ['name' => 'Privacy Policy', 'link_type' => 'page', 'url' => '/pages/privacy-policy', 'page_id' => $privacyPageId, 'order' => 1],
                ['name' => 'Terms of Service', 'link_type' => 'page', 'url' => '/pages/terms-of-service', 'page_id' => $termsPageId, 'order' => 2],
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

        // 5. Industries Menu (Footer / Extra)
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

        // 6. GET IN TOUCH Menu
        $getInTouchMenu = Menu::where('name', 'GET IN TOUCH')->where('position', 'footer')->first();
        if ($getInTouchMenu) {
            $getInTouchItems = [
                ['name' => 'Contact Us', 'link_type' => 'url', 'url' => '/contact', 'icon' => 'bi-envelope-at', 'page_id' => null, 'order' => 1],
                ['name' => 'Talk to an Expert', 'link_type' => 'url', 'url' => '/contact?type=expert', 'icon' => 'bi-headset', 'page_id' => null, 'order' => 2],
                ['name' => 'Request a Quote', 'link_type' => 'url', 'url' => '/contact?type=quote', 'icon' => 'bi-file-earmark-spreadsheet', 'page_id' => null, 'order' => 3],
                ['name' => 'Find a Sales Representative', 'link_type' => 'url', 'url' => '/contact?type=sales', 'icon' => 'bi-person-badge', 'page_id' => null, 'order' => 4],
                ['name' => 'Partner With Us', 'link_type' => 'url', 'url' => '/contact?type=partner', 'icon' => 'bi-briefcase', 'page_id' => null, 'order' => 5],
                ['name' => 'Media Inquiries', 'link_type' => 'url', 'url' => '/contact?type=media', 'icon' => 'bi-megaphone', 'page_id' => null, 'order' => 6],
                ['name' => 'Office Locations', 'link_type' => 'url', 'url' => '/about', 'icon' => 'bi-geo-alt', 'page_id' => null, 'order' => 7],
            ];

            foreach ($getInTouchItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $getInTouchMenu->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $getInTouchMenu->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'icon'      => $item['icon'] ?? null,
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }

        // 7. CUSTOMER CARE Menu
        $customerCareMenu = Menu::where('name', 'CUSTOMER CARE')->where('position', 'footer')->first();
        if ($customerCareMenu) {
            $warrantyPageId = Page::where('slug', 'warranty-policy')->value('id');
            $faqPageId = Page::where('slug', 'faq')->value('id');

            $customerCareItems = [
                ['name' => 'Product Support', 'link_type' => 'url', 'url' => '/contact?type=support', 'icon' => 'bi-headset', 'page_id' => null, 'order' => 1],
                ['name' => 'After-Sales Service', 'link_type' => 'url', 'url' => '/contact?type=service', 'icon' => 'bi-wrench-adjustable', 'page_id' => null, 'order' => 2],
                ['name' => 'Warranty Information', 'link_type' => $warrantyPageId ? 'page' : 'url', 'url' => '/pages/warranty-policy', 'icon' => 'bi-shield-check', 'page_id' => $warrantyPageId, 'order' => 3],
                ['name' => 'Spare Parts & Accessories', 'link_type' => 'url', 'url' => '/products', 'icon' => 'bi-tools', 'page_id' => null, 'order' => 4],
                ['name' => 'Service Centres', 'link_type' => 'url', 'url' => '/contact?type=service-centres', 'icon' => 'bi-geo-alt', 'page_id' => null, 'order' => 5],
                ['name' => 'Installation Support', 'link_type' => 'url', 'url' => '/resources', 'icon' => 'bi-gear-wide-connected', 'page_id' => null, 'order' => 6],
                ['name' => 'Maintenance Support', 'link_type' => 'url', 'url' => '/resources', 'icon' => 'bi-activity', 'page_id' => null, 'order' => 7],
                ['name' => 'Technical Help', 'link_type' => $faqPageId ? 'page' : 'url', 'url' => '/pages/faq', 'icon' => 'bi-question-circle', 'page_id' => $faqPageId, 'order' => 8],
            ];

            foreach ($customerCareItems as $item) {
                MenuItem::updateOrCreate(
                    ['menu_id' => $customerCareMenu->id, 'name' => $item['name']],
                    [
                        'menu_id'   => $customerCareMenu->id,
                        'name'      => $item['name'],
                        'link_type' => $item['link_type'],
                        'url'       => $item['url'],
                        'icon'      => $item['icon'] ?? null,
                        'page_id'   => $item['page_id'],
                        'enabled'   => true,
                        'order'     => $item['order'],
                    ]
                );
            }
        }
    }
}
