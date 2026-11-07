<?php

namespace Tests\Feature\Storefront;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DynamicPageTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@aire.test',
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_dynamic_page_loads_successfully(): void
    {
        $page = Page::create([
            'page_title'       => 'Custom Air Quality Guide',
            'slug'             => 'custom-air-quality-guide',
            'breadcrumb'       => 'Guide',
            'short_des'        => 'A detailed guide on cleanroom ventilation standards.',
            'page_description' => '<p>This is dynamic cleanroom ventilation content with H13 HEPA specifications.</p>',
            'meta_title'       => 'Custom Air Quality Guide | Aire',
            'meta_description' => 'A detailed guide on cleanroom ventilation standards.',
            'status'           => 1,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(200);
        $response->assertSee('Custom Air Quality Guide');
        $response->assertSee('cleanroom ventilation content');
        $response->assertSee('Verified IAQ Content');
    }

    public function test_inactive_dynamic_page_returns_404(): void
    {
        $page = Page::create([
            'page_title'       => 'Draft Page',
            'slug'             => 'draft-page',
            'breadcrumb'       => 'Draft',
            'short_des'        => 'Draft page short description.',
            'page_description' => '<p>Draft content</p>',
            'status'           => 0,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(404);
    }

    public function test_non_existent_page_returns_404(): void
    {
        $response = $this->get('/page/non-existent-random-slug-999');

        $response->assertStatus(404);
    }

    public function test_associated_quick_links_menu_page_loads_and_renders_menu(): void
    {
        $menu = \App\Models\Menu::create([
            'name'     => 'QUICK LINKS',
            'position' => 'Footer',
            'enabled'  => 1,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $menu->id,
            'name'      => 'Sick Building Prevention',
            'url'       => '/sick-building-prevention',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 1,
        ]);

        $page = Page::create([
            'page_title'       => 'Sick Building Prevention Guide',
            'slug'             => 'sick-building-prevention',
            'temp'             => 'legal',
            'menu_id'          => $menu->id,
            'breadcrumb'       => 'Quick Links',
            'short_des'        => 'Prevent sick building issues with AIRE tech.',
            'page_description' => '<p>Air quality solutions for sick building syndrome.</p>',
            'status'           => 1,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(200);
        $response->assertSee('Sick Building Prevention Guide');
        $response->assertSee('QUICK LINKS');
        $response->assertSee('Sick Building Prevention');
    }

    public function test_associated_company_menu_page_loads_and_renders_menu(): void
    {
        $menu = \App\Models\Menu::create([
            'name'     => 'COMPANY',
            'position' => 'footer',
            'enabled'  => 1,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $menu->id,
            'name'      => 'Global Locations',
            'url'       => '/about',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 1,
        ]);

        $page = Page::create([
            'page_title'       => 'About AIRE Global',
            'slug'             => 'about-aire-global',
            'temp'             => 'legal',
            'menu_id'          => $menu->id,
            'breadcrumb'       => 'Company',
            'short_des'        => 'Global locations and impact.',
            'page_description' => '<p>Leading clean air solutions worldwide.</p>',
            'status'           => 1,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(200);
        $response->assertSee('About AIRE Global');
        $response->assertSee('COMPANY');
        $response->assertSee('Global Locations');
    }

    public function test_legal_template_with_custom_menu_id_renders_selected_menu(): void
    {
        $customMenu = \App\Models\Menu::create([
            'name'     => 'CUSTOM INVESTOR RELATIONS',
            'position' => 'footer',
            'enabled'  => 1,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $customMenu->id,
            'name'      => 'Annual Reports 2026',
            'url'       => '/reports',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 1,
        ]);

        $page = Page::create([
            'page_title'       => 'Investor Hub',
            'slug'             => 'investor-hub',
            'temp'             => 'legal',
            'menu_id'          => $customMenu->id,
            'breadcrumb'       => 'Investors',
            'short_des'        => 'Overview of corporate disclosures.',
            'page_description' => '<p>Financial highlights and compliance reports.</p>',
            'status'           => 1,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(200);
        $response->assertSee('Investor Hub');
        $response->assertSee('CUSTOM INVESTOR RELATIONS');
        $response->assertSee('Annual Reports 2026');
    }

    public function test_legal_template_without_menu_id_falls_back_to_default_policies_menu(): void
    {
        $defaultLegalMenu = \App\Models\Menu::create([
            'name'     => 'POLICIES & LEGAL',
            'position' => 'footer',
            'enabled'  => 1,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $defaultLegalMenu->id,
            'name'      => 'Privacy Policy',
            'url'       => '/privacy-policy',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 1,
        ]);

        $page = Page::create([
            'page_title'       => 'Terms of Service',
            'slug'             => 'terms-of-service',
            'temp'             => 'legal',
            'menu_id'          => null,
            'breadcrumb'       => 'Legal',
            'short_des'        => 'Website terms of service.',
            'page_description' => '<p>Legal terms governing your usage.</p>',
            'status'           => 1,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(200);
        $response->assertSee('Terms of Service');
        $response->assertSee('POLICIES & LEGAL');
        $response->assertSee('Privacy Policy');
    }

    public function test_menu_items_are_rendered_strictly_in_order_by_order_column(): void
    {
        $menu = \App\Models\Menu::create([
            'name'     => 'ORDER TEST MENU',
            'position' => 'footer',
            'enabled'  => 1,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $menu->id,
            'name'      => 'Beta Omega Menu Item',
            'url'       => '/beta-omega',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 30,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $menu->id,
            'name'      => 'Alpha Prime Menu Item',
            'url'       => '/alpha-prime',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 10,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $menu->id,
            'name'      => 'Gamma Central Menu Item',
            'url'       => '/gamma-central',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 20,
        ]);

        $page = Page::create([
            'page_title'       => 'Order Verification Page',
            'slug'             => 'order-verification-page',
            'temp'             => 'legal',
            'menu_id'          => $menu->id,
            'breadcrumb'       => 'Ordering',
            'short_des'        => 'Verification of menu order.',
            'page_description' => '<p>Verifying strict order sorting.</p>',
            'status'           => 1,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(200);
        $content = $response->getContent();

        $posAlpha = strpos($content, 'Alpha Prime Menu Item');
        $posGamma = strpos($content, 'Gamma Central Menu Item');
        $posBeta  = strpos($content, 'Beta Omega Menu Item');

        $this->assertNotFalse($posAlpha, 'Alpha Prime Menu Item must be in HTML');
        $this->assertNotFalse($posGamma, 'Gamma Central Menu Item must be in HTML');
        $this->assertNotFalse($posBeta, 'Beta Omega Menu Item must be in HTML');

        $this->assertTrue($posAlpha < $posGamma, 'Alpha (order 10) must appear before Gamma (order 20)');
        $this->assertTrue($posGamma < $posBeta, 'Gamma (order 20) must appear before Beta (order 30)');
    }

    public function test_template_sidebar_menu_respects_sort_order(): void
    {
        $menu = \App\Models\Menu::create([
            'name'     => 'QUICK LINKS',
            'position' => 'Footer',
            'enabled'  => 1,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $menu->id,
            'name'      => 'Zeta Second Link',
            'url'       => '/zeta',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 5,
        ]);

        \App\Models\MenuItem::create([
            'menu_id'   => $menu->id,
            'name'      => 'Delta First Link',
            'url'       => '/delta',
            'link_type' => 'url',
            'enabled'   => 1,
            'order'     => 2,
        ]);

        $page = Page::create([
            'page_title'       => 'Quick Links Order Page',
            'slug'             => 'quick-links-order-page',
            'temp'             => 'legal',
            'menu_id'          => $menu->id,
            'breadcrumb'       => 'Quick Links',
            'short_des'        => 'Testing template sidebar ordering.',
            'page_description' => '<p>Content</p>',
            'status'           => 1,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(200);
        $content = $response->getContent();

        $posDelta = strpos($content, 'Delta First Link');
        $posZeta  = strpos($content, 'Zeta Second Link');

        $this->assertNotFalse($posDelta, 'Delta First Link must be in HTML');
        $this->assertNotFalse($posZeta, 'Zeta Second Link must be in HTML');
        $this->assertTrue($posDelta < $posZeta, 'Delta (order 2) must appear before Zeta (order 5)');
    }
}
