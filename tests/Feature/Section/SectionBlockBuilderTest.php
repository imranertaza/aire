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
}
