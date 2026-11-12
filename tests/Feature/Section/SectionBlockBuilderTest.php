<?php

namespace Tests\Feature\Section;

use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SectionBlockBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure permission exists
        Permission::firstOrCreate(['name' => 'manage-frontend', 'guard_name' => 'user']);

        // Create authenticated admin user
        $this->admin = User::factory()->create([
            'email' => 'builder_admin_' . uniqid() . '@example.com',
        ]);
        $this->admin->givePermissionTo('manage-frontend');
    }

    public function test_admin_can_create_new_builder_section_via_api(): void
    {
        $payload = [
            'name' => 'test_builder_hero_' . uniqid(),
            'data' => [
                'title' => 'Revolutionary Air Purity',
                'background_color' => '#0d1b2a',
                'container_type' => 'container',
                'padding_y' => [
                    'desktop' => 'py-5',
                    'mobile' => 'py-3',
                ],
                'blocks' => [
                    [
                        'id' => 'blk_101',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Atmospheric Filtration Standard',
                            'tag' => 'h2',
                            'align' => [
                                'desktop' => 'text-start',
                                'mobile' => 'text-center',
                            ],
                            'color' => '#ffffff',
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('sections', [
            'name' => $payload['name'],
        ]);

        $section = Section::where('name', $payload['name'])->first();
        $this->assertNotNull($section);
        $this->assertEquals('Revolutionary Air Purity', $section->data['title']);
        $this->assertEquals('heading', $section->data['blocks'][0]['type']);
    }

    public function test_admin_can_upload_image_for_builder_block(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('banner_hero.jpg', 1200, 600);

        $response = $this->actingAs($this->admin, 'user')
            ->post('/api/sections/upload-image', [
                'image' => $file,
            ]);

        $response->assertStatus(200);
        $url = $response->json('data.url');
        $filename = $response->json('data.filename');

        $this->assertStringStartsWith('storage/sections/builder/', $url);
        Storage::disk('public')->assertExists('sections/builder/' . $filename);
    }

    public function test_admin_can_update_builder_section_with_nested_columns_and_responsive_settings(): void
    {
        $section = Section::create([
            'name' => 'test_builder_columns_' . uniqid(),
            'data' => ['blocks' => []],
        ]);

        $payload = [
            'data' => [
                'title' => 'Updated Showcase Section',
                'background_color' => '#f8fafc',
                'blocks' => [
                    [
                        'id' => 'blk_col_root',
                        'type' => 'container',
                        'settings' => [
                            'columnsCount' => 2,
                            'layout' => [
                                'desktop' => 'col-lg-6',
                                'tablet' => 'col-md-6',
                                'mobile' => 'col-12',
                            ],
                            'stackOrderMobile' => 'reverse',
                            'gap' => [
                                'desktop' => 'g-4',
                                'mobile' => 'g-3',
                            ],
                        ],
                        'columns' => [
                            [
                                [
                                    'id' => 'blk_sub_img',
                                    'type' => 'image',
                                    'settings' => [
                                        'url' => 'themes/default/assets/img/photograph.webp',
                                        'alt' => 'Mask Hardware',
                                        'rounded' => 'rounded-4',
                                    ],
                                ],
                            ],
                            [
                                [
                                    'id' => 'blk_sub_text',
                                    'type' => 'paragraph',
                                    'settings' => [
                                        'text' => 'Precision air filtration powered by dual fans.',
                                        'align' => [
                                            'desktop' => 'text-start',
                                            'mobile' => 'text-center',
                                        ],
                                    ],
                                ],
                                [
                                    'id' => 'blk_sub_btn',
                                    'type' => 'button',
                                    'settings' => [
                                        'text' => 'Order Now',
                                        'url' => '/products',
                                        'variant' => 'btn-primary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($this->admin, 'user')
            ->putJson("/api/sections/{$section->id}", $payload);

        $response->assertStatus(200);

        $fresh = $section->fresh();
        $this->assertEquals('Updated Showcase Section', $fresh->data['title']);
        $this->assertEquals('container', $fresh->data['blocks'][0]['type']);
        $this->assertEquals('reverse', $fresh->data['blocks'][0]['settings']['stackOrderMobile']);
        $this->assertCount(2, $fresh->data['blocks'][0]['columns']);
    }

    public function test_updating_builder_section_busts_section_cache(): void
    {
        $name = 'test_builder_cache_' . uniqid();
        $section = Section::create([
            'name' => $name,
            'data' => ['title' => 'Initial Title'],
        ]);

        Cache::put("section_{$name}", 'cached_version', 3600);
        $this->assertTrue(Cache::has("section_{$name}"));

        $this->actingAs($this->admin, 'user')
            ->putJson("/api/sections/{$section->id}", [
                'data' => ['title' => 'Updated Title'],
            ]);

        $this->assertFalse(Cache::has("section_{$name}"));
    }

    public function test_storefront_renders_responsive_blocks_correctly(): void
    {
        $section = new Section([
            'name' => 'custom_showcase_section',
            'data' => [
                'title' => 'Innovative Air Systems',
                'badge' => 'TECHNOLOGY',
                'background_color' => '#0d1b2a',
                'container_type' => 'container',
                'padding_y' => [
                    'desktop' => 'py-5',
                    'mobile' => 'py-3',
                ],
                'blocks' => [
                    [
                        'id' => 'b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Active Sensor Array IAQ',
                            'tag' => 'h2',
                            'fontSize' => 'title-2',
                            'align' => [
                                'desktop' => 'text-start',
                                'mobile' => 'text-center',
                            ],
                        ],
                    ],
                    [
                        'id' => 'b2',
                        'type' => 'container',
                        'settings' => [
                            'columnsCount' => 2,
                            'layout' => [
                                'desktop' => 'col-lg-6',
                                'tablet' => 'col-md-6',
                                'mobile' => 'col-12',
                            ],
                            'stackOrderMobile' => 'reverse',
                            'gap' => [
                                'desktop' => 'g-4',
                                'mobile' => 'g-3',
                            ],
                        ],
                        'columns' => [
                            [
                                [
                                    'id' => 'b3',
                                    'type' => 'image',
                                    'settings' => [
                                        'url' => 'themes/default/assets/img/photograph.webp',
                                        'alt' => 'Air Pro Mask Preview',
                                        'rounded' => 'rounded-4',
                                    ],
                                ],
                            ],
                            [
                                [
                                    'id' => 'b4',
                                    'type' => 'card',
                                    'settings' => [
                                        'title' => 'Bilateral Filtration',
                                        'description' => 'Two independent air channels for inhalation and exhaust.',
                                        'number' => '01',
                                        'isGlass' => true,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $renderedHtml = view('themes.default.sections.builder', ['section' => $section])->render();

        // Assert section wrapper & headers
        $this->assertStringContainsString('id="custom_showcase_section"', $renderedHtml);
        $this->assertStringContainsString('Active Sensor Array IAQ', $renderedHtml);
        $this->assertStringContainsString('TECHNOLOGY', $renderedHtml);

        // Assert responsive alignment classes
        $this->assertStringContainsString('text-center text-md-start', $renderedHtml);

        // Assert responsive container classes & reverse mobile stack order
        $this->assertStringContainsString('col-12 col-md-6 col-lg-6', $renderedHtml);
        $this->assertStringContainsString('flex-column-reverse flex-md-row', $renderedHtml);
        $this->assertStringContainsString('g-3 g-md-4', $renderedHtml);

        // Assert card and image
        $this->assertStringContainsString('box-glass-card', $renderedHtml);
        $this->assertStringContainsString('Bilateral Filtration', $renderedHtml);
        $this->assertStringContainsString('Air Pro Mask Preview', $renderedHtml);
        $this->assertStringContainsString('rounded-4', $renderedHtml);
    }

    public function test_render_section_helper_and_blade_directive_renders_properly(): void
    {
        $section = Section::create([
            'name' => 'featured_showcase_block',
            'data' => [
                'title' => 'Revolutionary Clean Air',
                'badge' => 'TECHNOLOGY',
                'blocks' => [
                    [
                        'id' => 'h1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Direct Pure Air Stream',
                            'tag' => 'h3',
                            'fontSize' => 'title-3',
                        ],
                    ],
                ],
            ],
        ]);

        // 1. Helper function
        $helperHtml = render_section('featured_showcase_block');
        $this->assertStringContainsString('id="featured_showcase_block"', $helperHtml);
        $this->assertStringContainsString('Direct Pure Air Stream', $helperHtml);
        $this->assertStringContainsString('TECHNOLOGY', $helperHtml);

        // 2. Non-existent section should return empty string
        $emptyHtml = render_section('non_existent_section_key_xyz');
        $this->assertSame('', $emptyHtml);

        // 3. Blade directive evaluation
        $bladeDirectiveOutput = \Illuminate\Support\Facades\Blade::render("@renderSection('featured_showcase_block')");
        $this->assertStringContainsString('Direct Pure Air Stream', $bladeDirectiveOutput);
    }

    public function test_storefront_renders_dynamic_product_block_properly(): void
    {
        \App\Models\Store::firstOrCreate(['id' => 1], ['name' => 'Default Store', 'is_default' => 1]);

        $product = \App\Models\Product::create([
            'store_id' => 1,
            'name' => 'Aire Smart Purifier Pro',
            'slug' => 'aire-smart-purifier-pro-' . uniqid(),
            'model' => 'ASP-PRO',
            'price' => 499.00,
            'quantity' => 15,
            'status' => 1,
            'featured' => 1,
        ]);

        $section = Section::create([
            'name' => 'home_featured_products_' . uniqid(),
            'data' => [
                'title' => 'Featured Catalog',
                'blocks' => [
                    [
                        'id' => 'prod_blk_1',
                        'type' => 'products',
                        'settings' => [
                            'source' => 'featured',
                            'limit' => 4,
                            'columns_desktop' => 'col-lg-3',
                            'columns_mobile' => 'col-6',
                        ],
                    ],
                ],
            ],
        ]);

        $renderedHtml = view('themes.default.sections.builder', ['section' => $section])->render();

        $this->assertStringContainsString('builder-block-products', $renderedHtml);
        $this->assertStringContainsString('Aire Smart Purifier Pro', $renderedHtml);
    }

    public function test_storefront_renders_accordion_block_properly(): void
    {
        $section = Section::create([
            'name' => 'home_faq_accordion_' . uniqid(),
            'data' => [
                'title' => 'Frequently Asked Questions',
                'blocks' => [
                    [
                        'id' => 'acc_blk_1',
                        'type' => 'accordion',
                        'settings' => [
                            'style' => 'separated',
                            'first_open' => true,
                            'items' => [
                                [
                                    'id' => 'faq_item_1',
                                    'title' => 'How often should filters be replaced?',
                                    'content' => 'Replace filters every 6 to 12 months for optimal performance.',
                                ],
                                [
                                    'id' => 'faq_item_2',
                                    'title' => 'What is the filtration efficiency rate?',
                                    'content' => 'Our True HEPA captures 99.97% of particulates.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $renderedHtml = view('themes.default.sections.builder', ['section' => $section])->render();

        $this->assertStringContainsString('builder-block-accordion', $renderedHtml);
        $this->assertStringContainsString('How often should filters be replaced?', $renderedHtml);
        $this->assertStringContainsString('Replace filters every 6 to 12 months for optimal performance.', $renderedHtml);
        $this->assertStringContainsString('What is the filtration efficiency rate?', $renderedHtml);
        $this->assertStringContainsString('Our True HEPA captures 99.97% of particulates.', $renderedHtml);
    }

    public function test_storefront_renders_news_block_properly(): void
    {
        \App\Models\News::create([
            'news_title' => 'Breakthrough in Nano HEPA Air Filtration',
            'slug' => 'breakthrough-nano-hepa-air-filtration',
            'short_des' => 'Clinical test reports show significant particulate reduction.',
            'description' => 'Clinical test reports show significant particulate reduction.',
            'f_image' => 'news/featured.jpg',
            'status' => 1,
            'createdBy' => $this->admin->id,
        ]);

        $section = Section::create([
            'name' => 'home_news_block_' . uniqid(),
            'data' => [
                'title' => 'Latest Insights',
                'blocks' => [
                    [
                        'id' => 'news_blk_1',
                        'type' => 'news',
                        'settings' => [
                            'limit' => 3,
                            'columns_desktop' => 'col-lg-4',
                            'columns_mobile' => 'col-12',
                        ],
                    ],
                ],
            ],
        ]);

        $renderedHtml = view('themes.default.sections.builder', ['section' => $section])->render();

        $this->assertStringContainsString('builder-block-news', $renderedHtml);
        $this->assertStringContainsString('Breakthrough in Nano HEPA Air Filtration', $renderedHtml);
    }

    public function test_storefront_renders_categories_block_properly(): void
    {
        \App\Models\ProductCategory::create([
            'category_name' => 'Industrial Purifiers',
            'slug' => 'industrial-purifiers',
            'status' => 1,
            'sort_order' => 1,
        ]);

        $section = Section::create([
            'name' => 'home_categories_block_' . uniqid(),
            'data' => [
                'title' => 'Browse Categories',
                'blocks' => [
                    [
                        'id' => 'cat_blk_1',
                        'type' => 'categories',
                        'settings' => [
                            'limit' => 6,
                            'columns_desktop' => 'col-lg-2',
                            'show_count' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $renderedHtml = view('themes.default.sections.builder', ['section' => $section])->render();

        $this->assertStringContainsString('builder-block-categories', $renderedHtml);
        $this->assertStringContainsString('Industrial Purifiers', $renderedHtml);
    }

    public function test_storefront_renders_brands_block_properly(): void
    {
        \App\Models\Brand::create([
            'name' => 'Dyson Clean Tech',
            'status' => 1,
            'sort_order' => 1,
        ]);

        $section = Section::create([
            'name' => 'home_brands_block_' . uniqid(),
            'data' => [
                'title' => 'Brand Showcase',
                'blocks' => [
                    [
                        'id' => 'brands_blk_1',
                        'type' => 'brands',
                        'settings' => [
                            'limit' => 6,
                            'columns_desktop' => 'col-lg-2',
                            'grayscale' => true,
                            'boxed' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $renderedHtml = view('themes.default.sections.builder', ['section' => $section])->render();

        $this->assertStringContainsString('builder-block-brands', $renderedHtml);
        $this->assertStringContainsString('Dyson Clean Tech', $renderedHtml);
    }

    public function test_admin_can_fetch_available_blocks_for_slot_injection(): void
    {
        Section::create([
            'name' => 'promo_custom_banner',
            'data' => [
                'title' => 'Special Promo Banner',
                'blocks' => [
                    ['id' => 'b1', 'type' => 'heading', 'settings' => ['text' => 'Winter Sale']],
                ],
            ],
        ]);

        $response = $this->actingAs($this->admin, 'user')
            ->getJson('/api/sections/available-blocks');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'promo_custom_banner',
            'title' => 'Special Promo Banner',
        ]);
    }

    public function test_admin_can_get_and_save_page_layout_pipeline(): void
    {
        $getResponse = $this->actingAs($this->admin, 'user')
            ->getJson('/api/sections/layout/home');

        $getResponse->assertStatus(200);
        $this->assertIsArray($getResponse->json('data.slots'));

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/home', [
                'slots' => [
                    'after:slider_section' => [
                        ['key' => 'promo_custom_banner', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $this->assertDatabaseHas('sections', [
            'name' => 'home_layout',
        ]);

        $section = Section::where('name', 'home_layout')->first();
        $this->assertArrayHasKey('after:slider_section', $section->data['slots']);
    }

    public function test_render_page_slot_renders_active_blocks_and_skips_inactive(): void
    {
        $block = Section::create([
            'name' => 'feature_highlight_block',
            'status' => 1,
            'data' => [
                'title' => 'Innovative Air Ionizer',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'h1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Breathe Pure Mountain Air',
                            'tag' => 'h2',
                        ],
                    ],
                ],
            ],
        ]);

        Section::create([
            'name' => 'home_layout',
            'status' => 1,
            'data' => [
                'slots' => [
                    'after:slider_section' => [
                        ['key' => 'feature_highlight_block', 'enabled' => true],
                        ['key' => 'inactive_block', 'enabled' => false],
                    ],
                ],
            ],
        ]);

        Cache::forget('page_layout_home_v1');

        $rendered = render_page_slot('home', 'after:slider_section');

        $this->assertStringContainsString('Breathe Pure Mountain Air', $rendered);
        $this->assertStringNotContainsString('inactive_block', $rendered);
    }

    public function test_admin_can_save_and_render_product_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'pdp_warranty_badge_block',
            'status' => 1,
            'data' => [
                'title' => 'Lifetime Warranty Protection',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'pdp_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => '10-Year Clean Air Guarantee',
                            'tag' => 'h3',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/product', [
                'slots' => [
                    'after:overview' => [
                        ['key' => 'pdp_warranty_badge_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $rendered = render_page_slot('product', 'after:overview');
        $this->assertStringContainsString('10-Year Clean Air Guarantee', $rendered);
    }

    public function test_admin_can_save_and_render_contact_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'contact_faq_support_block',
            'status' => 1,
            'data' => [
                'title' => 'Support & Warranty Center FAQ',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'faq_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Frequently Asked Support Questions',
                            'tag' => 'h2',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/contact', [
                'slots' => [
                    'after:contact_form' => [
                        ['key' => 'contact_faq_support_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $rendered = render_page_slot('contact', 'after:contact_form');
        $this->assertStringContainsString('Frequently Asked Support Questions', $rendered);
    }

    public function test_admin_can_save_and_render_category_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'catalog_seasonal_promo_block',
            'status' => 1,
            'data' => [
                'title' => 'Winter IAQ Clean Air Campaign',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'promo_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Save 20% on Certified High Efficiency Purifiers',
                            'tag' => 'h2',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/category', [
                'slots' => [
                    'before:catalog_content' => [
                        ['key' => 'catalog_seasonal_promo_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $rendered = render_page_slot('category', 'before:catalog_content');
        $this->assertStringContainsString('Save 20% on Certified High Efficiency Purifiers', $rendered);
    }

    public function test_admin_can_save_and_render_news_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'news_newsletter_subscription_block',
            'status' => 1,
            'data' => [
                'title' => 'AIRE Research Digest Subscription',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'news_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Subscribe to Global Air Quality Intelligence',
                            'tag' => 'h2',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/news', [
                'slots' => [
                    'after:featured_spotlight' => [
                        ['key' => 'news_newsletter_subscription_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $rendered = render_page_slot('news', 'after:featured_spotlight');
        $this->assertStringContainsString('Subscribe to Global Air Quality Intelligence', $rendered);
    }

    public function test_admin_can_save_and_render_news_detail_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'article_author_bio_block',
            'status' => 1,
            'data' => [
                'title' => 'Editorial Contributor Spotlight',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'art_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Meet the Environmental Engineering Authors',
                            'tag' => 'h3',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/news_detail', [
                'slots' => [
                    'after:article_body' => [
                        ['key' => 'article_author_bio_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $rendered = render_page_slot('news_detail', 'after:article_body');
        $this->assertStringContainsString('Meet the Environmental Engineering Authors', $rendered);
    }

    public function test_admin_can_save_and_render_order_confirm_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'order_filter_subscription_block',
            'status' => 1,
            'data' => [
                'title' => 'VIP Replacement Filter Auto-Ship',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'ord_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Never Forget a Fresh Filter: Join Auto-Ship & Save 20%',
                            'tag' => 'h3',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/order_confirm', [
                'slots' => [
                    'after:order_summary' => [
                        ['key' => 'order_filter_subscription_block', 'enabled' => true],
                    ],
                    'after:order_confirmation' => [
                        ['key' => 'order_filter_subscription_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $renderedSidebar = render_page_slot('order_confirm', 'after:order_summary');
        $this->assertStringContainsString('Never Forget a Fresh Filter: Join Auto-Ship', $renderedSidebar);

        $renderedBottom = render_page_slot('order_confirm', 'after:order_confirmation');
        $this->assertStringContainsString('Never Forget a Fresh Filter: Join Auto-Ship', $renderedBottom);
    }

    public function test_admin_can_save_and_render_cart_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'cart_cross_sell_accessories_block',
            'status' => 1,
            'data' => [
                'title' => 'Complete Your Air Purification Setup',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'cart_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Frequently Bought Together Accessories',
                            'tag' => 'h3',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/cart', [
                'slots' => [
                    'after:cart_items' => [
                        ['key' => 'cart_cross_sell_accessories_block', 'enabled' => true],
                    ],
                    'after:order_summary' => [
                        ['key' => 'cart_cross_sell_accessories_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $renderedItems = render_page_slot('cart', 'after:cart_items');
        $this->assertStringContainsString('Frequently Bought Together Accessories', $renderedItems);

        $renderedSidebar = render_page_slot('cart', 'after:order_summary');
        $this->assertStringContainsString('Frequently Bought Together Accessories', $renderedSidebar);
    }

    public function test_admin_can_save_and_render_not_found_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'error_bestsellers_recovery_block',
            'status' => 1,
            'data' => [
                'title' => 'Top Precision Air Purifiers & Clean Air Systems',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'nf_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Looking for clean air solutions? Discover our bestselling purifiers',
                            'tag' => 'h3',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/not_found', [
                'slots' => [
                    'after:search_box' => [
                        ['key' => 'error_bestsellers_recovery_block', 'enabled' => true],
                    ],
                    'after:error_content' => [
                        ['key' => 'error_bestsellers_recovery_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $renderedInside = render_page_slot('not_found', 'after:search_box');
        $this->assertStringContainsString('Looking for clean air solutions? Discover our bestselling purifiers', $renderedInside);

        $renderedBottom = render_page_slot('not_found', 'after:error_content');
        $this->assertStringContainsString('Looking for clean air solutions? Discover our bestselling purifiers', $renderedBottom);
    }

    public function test_admin_can_save_and_render_favorite_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'fav_curated_collection_block',
            'status' => 1,
            'data' => [
                'title' => 'Curated Pure Air Collections',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'fav_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Recommended Companions for Your Saved Items',
                            'tag' => 'h3',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/favorite', [
                'slots' => [
                    'after:favorite_grid' => [
                        ['key' => 'fav_curated_collection_block', 'enabled' => true],
                    ],
                    'after:favorite_content' => [
                        ['key' => 'fav_curated_collection_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $renderedGrid = render_page_slot('favorite', 'after:favorite_grid');
        $this->assertStringContainsString('Recommended Companions for Your Saved Items', $renderedGrid);

        $renderedBottom = render_page_slot('favorite', 'after:favorite_content');
        $this->assertStringContainsString('Recommended Companions for Your Saved Items', $renderedBottom);
    }

    public function test_admin_can_save_and_render_compare_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'compare_technical_guide_block',
            'status' => 1,
            'data' => [
                'title' => 'Technical CADR & HEPA Comparison Guide',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'comp_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Understanding Air Quality Metrics: CADR, Filter Grades and Coverage',
                            'tag' => 'h3',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/compare', [
                'slots' => [
                    'after:compare_matrix' => [
                        ['key' => 'compare_technical_guide_block', 'enabled' => true],
                    ],
                    'after:compare_content' => [
                        ['key' => 'compare_technical_guide_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $renderedMatrix = render_page_slot('compare', 'after:compare_matrix');
        $this->assertStringContainsString('Understanding Air Quality Metrics: CADR, Filter Grades and Coverage', $renderedMatrix);

        $renderedBottom = render_page_slot('compare', 'after:compare_content');
        $this->assertStringContainsString('Understanding Air Quality Metrics: CADR, Filter Grades and Coverage', $renderedBottom);
    }

    public function test_admin_can_save_and_render_resources_page_layout_pipeline(): void
    {
        $block = Section::create([
            'name' => 'resources_enterprise_cta_block',
            'status' => 1,
            'data' => [
                'title' => 'Enterprise Engineering & Consultation Support',
                'container_type' => 'container',
                'blocks' => [
                    [
                        'id' => 'res_b1',
                        'type' => 'heading',
                        'settings' => [
                            'text' => 'Need Technical Air Flow and HVAC System Calculations?',
                            'tag' => 'h3',
                        ],
                    ],
                ],
            ],
        ]);

        $saveResponse = $this->actingAs($this->admin, 'user')
            ->postJson('/api/sections/layout/resources', [
                'slots' => [
                    'before:catalog' => [
                        ['key' => 'resources_enterprise_cta_block', 'enabled' => true],
                    ],
                    'after:catalog' => [
                        ['key' => 'resources_enterprise_cta_block', 'enabled' => true],
                    ],
                ],
            ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        $renderedBefore = render_page_slot('resources', 'before:catalog');
        $this->assertStringContainsString('Need Technical Air Flow and HVAC System Calculations?', $renderedBefore);

        $renderedAfter = render_page_slot('resources', 'after:catalog');
        $this->assertStringContainsString('Need Technical Air Flow and HVAC System Calculations?', $renderedAfter);
    }

    public function test_storefront_renders_video_block_properly(): void
    {
        // 1. YouTube Video Block
        $ytSection = Section::create([
            'name' => 'home_video_yt_' . uniqid(),
            'data' => [
                'title' => 'YouTube Showcase',
                'blocks' => [
                    [
                        'id' => 'video_blk_yt',
                        'type' => 'video',
                        'settings' => [
                            'source' => 'youtube',
                            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            'aspectRatio' => '16:9',
                            'caption' => 'Official Demonstration Video',
                        ],
                    ],
                ],
            ],
        ]);

        $renderedYt = view('themes.default.sections.builder', ['section' => $ytSection])->render();
        $this->assertStringContainsString('block-render-video', $renderedYt);
        $this->assertStringContainsString('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', $renderedYt);
        $this->assertStringContainsString('Official Demonstration Video', $renderedYt);

        // 2. HTML5 Video Block
        $html5Section = Section::create([
            'name' => 'home_video_html5_' . uniqid(),
            'data' => [
                'title' => 'HTML5 Showcase',
                'blocks' => [
                    [
                        'id' => 'video_blk_html5',
                        'type' => 'video',
                        'settings' => [
                            'source' => 'html5',
                            'url' => 'https://example.com/videos/demo.mp4',
                            'controls' => true,
                            'autoplay' => true,
                            'loop' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $renderedHtml5 = view('themes.default.sections.builder', ['section' => $html5Section])->render();
        $this->assertStringContainsString('<video', $renderedHtml5);
        $this->assertStringContainsString('https://example.com/videos/demo.mp4', $renderedHtml5);

        // 3. Fallback from image block when video url is supplied
        $fallbackSection = Section::create([
            'name' => 'fallback_video_' . uniqid(),
            'data' => [
                'blocks' => [
                    [
                        'id' => 'img_video_fallback',
                        'type' => 'image',
                        'settings' => [
                            'url' => 'https://youtu.be/dQw4w9WgXcQ',
                        ],
                    ],
                ],
            ],
        ]);

        $renderedFallback = view('themes.default.sections.builder', ['section' => $fallbackSection])->render();
        $this->assertStringContainsString('block-render-video', $renderedFallback);
        $this->assertStringContainsString('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', $renderedFallback);
    }
}
