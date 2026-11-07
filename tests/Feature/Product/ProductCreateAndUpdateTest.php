<?php

namespace Tests\Feature\Product;

use App\Models\Brand;
use App\Models\FilterOption;
use App\Models\FilterOptionValue;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductAttributeGroup;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductLanding;
use App\Models\ProductShowcase;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProductCreateAndUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Store $store;
    protected Brand $brand;
    protected ProductCategory $category;
    protected Option $option;
    protected OptionValue $optionValue;
    protected FilterOption $filterOption;
    protected FilterOptionValue $filterOptionValue;
    protected ProductAttributeGroup $attributeGroup;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // 1. Create default store
        $this->store = Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        // 2. Create permissions
        Permission::findOrCreate('view-products', 'user');
        Permission::findOrCreate('create-products', 'user');
        Permission::findOrCreate('edit-products', 'user');
        Permission::findOrCreate('delete-products', 'user');

        // 3. Create admin user with permissions
        $this->admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@aire.test',
            'password' => bcrypt('password'),
        ]);
        $this->admin->givePermissionTo(['view-products', 'create-products', 'edit-products', 'delete-products']);

        // 4. Create shared relational dependencies
        $this->brand = Brand::create(['name' => 'AIRE Official', 'status' => 1]);
        $this->category = ProductCategory::create(['category_name' => 'Ductless Systems', 'slug' => 'ductless-systems', 'status' => 1]);

        $this->option = Option::create(['name' => 'Color', 'type' => 'radio', 'status' => 1]);
        $this->optionValue = OptionValue::create(['option_id' => $this->option->id, 'name' => 'Matte White']);

        $this->filterOption = FilterOption::create(['name' => 'Room Size', 'type' => 'checkbox', 'status' => 1]);
        $this->filterOptionValue = FilterOptionValue::create(['filter_option_id' => $this->filterOption->id, 'name' => 'Up to 500 sq ft']);

        $this->attributeGroup = ProductAttributeGroup::create(['name' => 'Technical Specifications', 'status' => 1]);
    }

    /**
     * Test guests cannot access product store, update or delete endpoints.
     */
    public function test_unauthenticated_user_cannot_access_product_endpoints(): void
    {
        $this->postJson(route('products.store'), ['name' => 'Test'])->assertStatus(401);
        $this->postJson(route('products.update', 1), ['name' => 'Test'])->assertStatus(401);
        $this->deleteJson(route('products.destroy', 1))->assertStatus(401);
    }

    /**
     * Test authenticated user without appropriate permissions is forbidden.
     */
    public function test_user_without_permission_cannot_create_or_update_product(): void
    {
        $limitedUser = User::create([
            'name'     => 'Limited Staff',
            'email'    => 'limited@aire.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($limitedUser, 'user')
            ->postJson(route('products.store'), ['name' => 'Test'])
            ->assertStatus(403);

        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Sample Unit',
            'model'    => 'SU-01',
            'price'    => 100,
            'quantity' => 1,
        ]);

        $this->actingAs($limitedUser, 'user')
            ->postJson(route('products.update', $product->id), ['name' => 'Updated'])
            ->assertStatus(403);
    }

    /**
     * Test validation rules on product creation.
     */
    public function test_product_creation_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('products.store'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'model', 'price', 'quantity', 'main_image']);
    }

    /**
     * Test full product creation including Showcase Card, Landing Page, Options, FAQs, Media and Pointers.
     */
    public function test_admin_can_create_product_with_all_relations_and_showcase_card(): void
    {
        // Supporting products for relations
        $relatedProd = Product::create(['store_id' => $this->store->id, 'name' => 'Related Filter', 'model' => 'RF-01', 'price' => 29.99, 'quantity' => 50]);
        $boughtTogetherProd = Product::create(['store_id' => $this->store->id, 'name' => 'Wall Mount Bracket', 'model' => 'WMB-01', 'price' => 49.99, 'quantity' => 20]);

        $mainImage = UploadedFile::fake()->image('main_unit.jpg', 800, 800);
        $gallery1 = UploadedFile::fake()->image('gallery_angle1.jpg', 800, 800);
        $gallery2 = UploadedFile::fake()->image('gallery_angle2.jpg', 800, 800);
        $heroBg = UploadedFile::fake()->image('showcase_hero_bg.jpg', 1200, 800);
        $diagramCutout = UploadedFile::fake()->image('diagram_transparent.png', 600, 500);

        $payload = [
            // Core
            'name'                      => 'AIRE Pro Ductless S1',
            'slug'                      => 'aire-pro-ductless-s1',
            'model'                     => 'AP-S1-2026',
            'product_code'              => 'SKU-AIRE-S1',
            'brand_id'                  => $this->brand->id,
            'price'                     => 599.99,
            'quantity'                  => 40,
            'weight'                    => 12.5,
            'length'                    => 45.0,
            'width'                     => 30.0,
            'height'                    => 18.0,
            'status'                    => 1,
            'featured'                  => 1,
            'sort_order'                => 1,
            'product_free_delivery'     => 1,
            'special_price'             => 549.99,
            'special_start_date'        => '2026-01-01',
            'special_end_date'          => '2026-12-31',

            // SEO & Descriptions
            'description'               => 'High performance residential fresh air ventilator.',
            'tag'                       => 'air purifier, fresh air, ductless, hepa',
            'meta_title'                => 'AIRE Pro Ductless S1 - Premium Fresh Air Purifier',
            'meta_description'          => 'Discover the AIRE Pro Ductless S1 with medical grade HEPA filtration.',
            'meta_keyword'              => 'aire, fresh air, purifiers',

            // Media
            'main_image'                => $mainImage,
            'gallery_images'            => [$gallery1, $gallery2],

            // Pivot Relations
            'category_ids'              => json_encode([$this->category->id]),
            'related_ids'               => json_encode([$relatedProd->id]),
            'bought_together_ids'       => json_encode([$boughtTogetherProd->id]),

            // Options & Filter Options & Attributes
            'options'                   => json_encode([
                [
                    'option_id'       => $this->option->id,
                    'option_value_id' => $this->optionValue->id,
                    'quantity'        => 40,
                    'price'           => 0,
                    'price_prefix'    => '+',
                    'subtract'        => 1,
                ],
            ]),
            'filter_options'            => json_encode([
                [
                    'filter_option_id'       => $this->filterOption->id,
                    'filter_option_value_id' => $this->filterOptionValue->id,
                ],
            ]),
            'attributes'                => json_encode([
                [
                    'attribute_group_id' => $this->attributeGroup->id,
                    'name'               => 'Airflow Rate',
                    'details'            => '100 m³/h',
                    'sort_order'         => 1,
                ],
            ]),

            // FAQs
            'faqs'                      => [
                ['question' => 'How often should filters be replaced?', 'answer' => 'Every 6-12 months depending on usage.', 'sort_order' => 1],
            ],

            // Applications
            'applications'              => [
                [
                    'title'       => 'Master Bedrooms & Living Rooms',
                    'description' => 'Provides silent and continuous fresh airflow while sleeping.',
                    'badge'       => 'Quiet Comfort',
                    'grid_width'  => 'col-lg-8',
                    'sort_order'  => 0,
                ],
            ],

            // Overview Section
            'overview_title'            => 'Clean Air Engineering',
            'overview_description'      => 'Delivers 100% fresh outdoor air with heat recovery efficiency.',
            'overview_feature1_icon'    => 'bi bi-shield-check',
            'overview_feature1_title'   => 'HEPA H13 Filtration',
            'overview_feature1_desc'    => 'Captures 99.9% of microscopic particles.',
            'overview_feature2_icon'    => 'bi bi-wind',
            'overview_feature2_title'   => 'Positive Pressure',
            'overview_feature2_desc'    => 'Keeps contaminated outdoor air from infiltrating.',

            // Showcase Card Tab Configuration
            'showcase_title'                => 'Single Room Ductless Pro',
            'showcase_subtitle'             => 'Compact and powerful room purifiers',
            'showcase_modal_subtitle'       => 'Single Room Ductless Fresh Air Ventilator',
            'showcase_series_badge'         => 'PRO S1 SERIES',
            'showcase_badge_residential'    => 'Residential',
            'showcase_badge_fresh_air'      => 'Small Fresh Air',
            'showcase_diagram_brand'        => 'AIRE',
            'showcase_diagram_model'        => 'AP-S1-2026',
            'showcase_diagram_system'       => 'Wall-Mounted Ductless Ventilation System',
            'showcase_airflow'              => '100 m³/h',
            'showcase_power'                => '25 W',
            'showcase_coverage_area'        => '30–50 m²',
            'showcase_feature_pills'        => json_encode([
                ['icon' => 'bi bi-arrows-fullscreen', 'text' => '200–500 sq ft', 'subtext' => ''],
                ['icon' => 'bi bi-arrow-repeat', 'text' => 'Heat Recovery 70%', 'subtext' => ''],
                ['icon' => 'bi bi-wind', 'text' => '100% Fresh Air', 'subtext' => 'No Recycled Air'],
            ]),
            'showcase_spec_highlights'      => json_encode([
                ['icon' => 'bi bi-wind', 'label' => 'Airflow', 'value' => '100 m³/h'],
                ['icon' => 'bi bi-lightning-charge', 'label' => 'Power', 'value' => '25 W'],
                ['icon' => 'bi bi-soundwave', 'label' => 'Noise', 'value' => '< 28 dB'],
            ]),
            'showcase_matched_features'     => json_encode([
                ['icon' => 'bi bi-house', 'text' => 'Residential'],
                ['icon' => 'bi bi-wind', 'text' => 'Fresh Air'],
                ['icon' => 'bi bi-shield-check', 'text' => 'HEPA PM2.5'],
            ]),
            'showcase_health_tags'          => json_encode([
                ['icon' => 'bi bi-shield-check', 'text' => 'PM2.5: 99.9%'],
                ['icon' => 'bi bi-heart-pulse', 'text' => 'HCHO: 65 m³/h'],
            ]),
            'showcase_hero_bg_image_file'   => $heroBg,
            'showcase_diagram_image_file'   => $diagramCutout,
        ];

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('products.store'), $payload);

        $response->assertStatus(200);

        // 1. Assert Product Table
        $this->assertDatabaseHas('products', [
            'name'       => 'AIRE Pro Ductless S1',
            'model'      => 'AP-S1-2026',
            'brand_id'   => $this->brand->id,
            'price'      => 599.99,
            'quantity'   => 40,
            'featured'   => 1,
            'status'     => 1,
        ]);

        $product = Product::where('model', 'AP-S1-2026')->firstOrFail();

        // 2. Assert Gallery Images
        $this->assertCount(2, $product->images);
        /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
        $storage = Storage::disk('public');
        foreach ($product->images as $galleryImg) {
            $storage->assertExists($galleryImg->image);
        }

        // 3. Assert Free Delivery & Specials
        $this->assertDatabaseHas('product_free_deliveries', ['product_id' => $product->id]);
        $this->assertDatabaseHas('product_specials', ['product_id' => $product->id, 'special_price' => 549.99]);

        // 4. Assert Pivot Relations
        $this->assertTrue($product->categories->contains($this->category->id));
        $this->assertTrue($product->relatedProducts->contains($relatedProd->id));
        $this->assertTrue($product->boughtTogether->contains($boughtTogetherProd->id));

        // 5. Assert Options, Filter Options & Attributes
        $this->assertDatabaseHas('product_options', ['product_id' => $product->id, 'option_id' => $this->option->id]);
        $this->assertDatabaseHas('product_filter_options', ['product_id' => $product->id, 'filter_option_id' => $this->filterOption->id]);
        $this->assertDatabaseHas('product_attributes', ['product_id' => $product->id, 'name' => 'Airflow Rate']);

        // 6. Assert FAQs & Applications
        $this->assertDatabaseHas('product_faqs', ['product_id' => $product->id, 'question' => 'How often should filters be replaced?']);
        $this->assertDatabaseHas('product_applications', ['product_id' => $product->id, 'title' => 'Master Bedrooms & Living Rooms']);

        // 7. Assert Overview
        $this->assertDatabaseHas('product_overviews', ['product_id' => $product->id, 'title' => 'Clean Air Engineering']);

        // 8. Assert Showcase Card Record & Files
        $this->assertDatabaseHas('product_showcases', [
            'product_id'        => $product->id,
            'title'             => 'Single Room Ductless Pro',
            'subtitle'          => 'Compact and powerful room purifiers',
            'series_badge'      => 'PRO S1 SERIES',
            'airflow'           => '100 m³/h',
            'power'             => '25 W',
            'coverage_area'     => '30–50 m²',
        ]);

        $showcase = ProductShowcase::where('product_id', $product->id)->firstOrFail();
        $this->assertCount(3, $showcase->feature_pills);
        $this->assertCount(3, $showcase->spec_highlights);
        $this->assertCount(3, $showcase->matched_features);
        $this->assertCount(2, $showcase->health_tags);
        /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
        $storage = Storage::disk('public');
        $storage->assertExists($showcase->hero_bg_image);
        $storage->assertExists($showcase->diagram_image);
    }

    /**
     * Test updating product core data, options, relations, showcase card, and removing media via deleted_images.
     */
    public function test_admin_can_update_product_and_modify_relations_and_showcase(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Initial Unit',
            'model'    => 'INIT-01',
            'price'    => 299.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        $existingImg = ProductImage::create([
            'product_id' => $product->id,
            'image'      => "product/{$product->id}/gallery/old_photo.jpg",
            'alt_name'   => 'Old Photo',
        ]);
        Storage::disk('public')->put($existingImg->image, 'dummy binary');

        $showcase = ProductShowcase::create([
            'product_id'     => $product->id,
            'title'          => 'Original Showcase Title',
            'subtitle'       => 'Original Subtitle',
            'hero_bg_image'  => "product/{$product->id}/showcase/old_hero.jpg",
            'feature_pills'  => [['icon' => 'bi bi-wind', 'text' => 'Old Pill']],
        ]);
        Storage::disk('public')->put($showcase->hero_bg_image, 'dummy hero binary');

        $newHeroImage = UploadedFile::fake()->image('fresh_hero.jpg', 1200, 800);
        $newGalleryImage = UploadedFile::fake()->image('fresh_gallery.jpg', 800, 800);

        $updatePayload = [
            'name'                        => 'Updated Unit Ultra',
            'model'                       => 'INIT-01-ULTRA',
            'price'                       => 399.00,
            'quantity'                    => 20,
            'status'                      => 1,
            'deleted_images'              => json_encode([$existingImg->id]),
            'gallery_images'              => [$newGalleryImage],

            // Updated Showcase details
            'showcase_title'              => 'Updated Showcase Title Ultra',
            'showcase_subtitle'           => 'Enhanced purification system',
            'showcase_series_badge'       => 'ULTRA SERIES',
            'showcase_airflow'            => '180 m³/h',
            'showcase_power'              => '30 W',
            'showcase_coverage_area'      => '60 m²',
            'showcase_feature_pills'      => json_encode([
                ['icon' => 'bi bi-wind', 'text' => '180 m³/h Ultra Fresh Air', 'subtext' => 'Continuous Clean Flow'],
            ]),
            'showcase_hero_bg_image_file' => $newHeroImage,
        ];

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('products.update', $product->id), $updatePayload);

        $response->assertStatus(200);

        // Verify product was updated
        $this->assertDatabaseHas('products', [
            'id'    => $product->id,
            'name'  => 'Updated Unit Ultra',
            'model' => 'INIT-01-ULTRA',
            'price' => 399.00,
        ]);

        // Verify old gallery image was deleted from db and storage
        $this->assertDatabaseMissing('product_images', ['id' => $existingImg->id]);
        Storage::disk('public')->assertMissing($existingImg->image);

        // Verify new gallery image was attached
        $this->assertDatabaseHas('product_images', ['product_id' => $product->id]);

        // Verify showcase card was updated
        $this->assertDatabaseHas('product_showcases', [
            'product_id'   => $product->id,
            'title'        => 'Updated Showcase Title Ultra',
            'series_badge' => 'ULTRA SERIES',
            'airflow'      => '180 m³/h',
        ]);

        $showcase->refresh();
        $this->assertEquals('180 m³/h Ultra Fresh Air', $showcase->feature_pills[0]['text']);
        /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
        $storage = Storage::disk('public');
        $storage->assertExists($showcase->hero_bg_image);
    }

    /**
     * Test single product status toggle.
     */
    public function test_admin_can_toggle_product_status(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Status Product',
            'model'    => 'ST-01',
            'price'    => 50.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        // Toggle to inactive (0)
        $response = $this->actingAs($this->admin, 'user')
            ->patchJson(route('products.toggle', $product->id));

        $response->assertStatus(200)->assertJsonPath('data.status', 0);
        $this->assertEquals(0, $product->fresh()->status);

        // Toggle back to active (1)
        $response2 = $this->actingAs($this->admin, 'user')
            ->patchJson(route('products.toggle', $product->id));

        $response2->assertStatus(200)->assertJsonPath('data.status', 1);
        $this->assertEquals(1, $product->fresh()->status);
    }

    /**
     * Test bulk status updates for multiple products.
     */
    public function test_admin_can_bulk_update_product_status(): void
    {
        $p1 = Product::create(['store_id' => $this->store->id, 'name' => 'Prod 1', 'model' => 'P-1', 'price' => 10, 'quantity' => 1, 'status' => 1]);
        $p2 = Product::create(['store_id' => $this->store->id, 'name' => 'Prod 2', 'model' => 'P-2', 'price' => 10, 'quantity' => 1, 'status' => 1]);

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('products.bulk-status'), [
                'product_ids' => [$p1->id, $p2->id],
                'status'      => 0,
            ]);

        $response->assertStatus(200);
        $this->assertEquals(0, $p1->fresh()->status);
        $this->assertEquals(0, $p2->fresh()->status);
    }

    /**
     * Test copying/replicating an existing product.
     */
    public function test_admin_can_copy_existing_product(): void
    {
        $original = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Master Purifier Unit',
            'model'    => 'MPU-100',
            'price'    => 750.00,
            'quantity' => 8,
            'status'   => 1,
        ]);

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('products.copy'), [
                'product_ids' => [$original->id],
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name'   => 'Copy of Master Purifier Unit',
            'status' => 0, // Copies are inactive by default
        ]);
    }

    /**
     * Test deleting a product and bulk deleting products.
     */
    public function test_admin_can_delete_and_bulk_delete_products(): void
    {
        $p1 = Product::create(['store_id' => $this->store->id, 'name' => 'Del 1', 'model' => 'D-1', 'price' => 10, 'quantity' => 1]);
        $p2 = Product::create(['store_id' => $this->store->id, 'name' => 'Del 2', 'model' => 'D-2', 'price' => 10, 'quantity' => 1]);
        $p3 = Product::create(['store_id' => $this->store->id, 'name' => 'Del 3', 'model' => 'D-3', 'price' => 10, 'quantity' => 1]);

        // Single destroy
        $this->actingAs($this->admin, 'user')
            ->deleteJson(route('products.destroy', $p1->id))
            ->assertStatus(200);

        $this->assertDatabaseMissing('products', ['id' => $p1->id]);

        // Bulk delete
        $this->actingAs($this->admin, 'user')
            ->deleteJson(route('products.bulk-delete'), [
                'product_ids' => [$p2->id, $p3->id],
            ])
            ->assertStatus(200);

        $this->assertDatabaseMissing('products', ['id' => $p2->id]);
        $this->assertDatabaseMissing('products', ['id' => $p3->id]);
    }

    /**
     * Test retrieving a product includes all eager-loaded relations (including showcase, landing, faqs, options).
     */
    public function test_show_endpoint_returns_complete_product_with_all_relations(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Detailed Product Unit',
            'model'    => 'DPU-01',
            'price'    => 450.00,
            'quantity' => 12,
            'status'   => 1,
        ]);

        ProductShowcase::create([
            'product_id'      => $product->id,
            'title'           => 'Showcase Detail Title',
            'series_badge'    => 'PRO S1 SERIES',
            'feature_pills'   => [['icon' => 'bi bi-wind', 'text' => '100 m³/h']],
            'spec_highlights' => [['icon' => 'bi bi-lightning', 'label' => 'Power', 'value' => '25W']],
        ]);

        $response = $this->actingAs($this->admin, 'user')
            ->getJson(route('products.show', $product->id));

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Detailed Product Unit')
            ->assertJsonPath('data.showcase.title', 'Showcase Detail Title')
            ->assertJsonPath('data.showcase.series_badge', 'PRO S1 SERIES')
            ->assertJsonPath('data.showcase.feature_pills.0.text', '100 m³/h')
            ->assertJsonPath('data.showcase.spec_highlights.0.value', '25W');
    }

    /**
     * Test creating and updating product landing page fields and images.
     */
    public function test_admin_can_create_and_update_product_landing_page(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Landing Test Unit',
            'model'    => 'LTU-100',
            'price'    => 499.00,
            'quantity' => 15,
            'status'   => 1,
        ]);

        $heroImg = UploadedFile::fake()->image('landing_hero.jpg', 1200, 800);
        $scienceImg = UploadedFile::fake()->image('landing_science.jpg', 800, 800);
        $specGroupImg = UploadedFile::fake()->image('spec_group_0.png', 500, 500);

        $updatePayload = [
            'name'                          => 'Landing Test Unit',
            'model'                         => 'LTU-100',
            'price'                         => 499.00,
            'quantity'                      => 15,
            'status'                        => 1,
            'landing_enabled'               => 1,
            'landing_hero_tag'              => 'HERO-TAG-100',
            'landing_hero_title'            => 'Revolutionary Clean Air',
            'landing_hero_description'      => 'Detailed description of hero section',
            'landing_hero_button_text'      => 'Discover More',
            'landing_hero_button_url'       => '/discover',
            'landing_hero_image_file'       => $heroImg,
            'landing_science_tag'           => 'SCIENCE',
            'landing_science_title'         => 'Pure Science',
            'landing_science_description'   => 'UV-C and HEPA synergy',
            'landing_science_stat1_value'   => '99.99%',
            'landing_science_stat1_label'   => 'VIRUS REDUCTION',
            'landing_science_stat2_value'   => '0.1um',
            'landing_science_stat2_label'   => 'PARTICLE SIZE',
            'landing_science_image_file'    => $scienceImg,
            'landing_science_features'      => json_encode([
                ['title' => 'Custom Filtration', 'desc' => 'Multi-layer activated carbon and HEPA'],
            ]),
            'landing_lifestyle_tag'         => 'LIFESTYLE',
            'landing_lifestyle_title'       => 'Modern Living',
            'landing_lifestyle_description' => 'Fits in any modern room',
            'landing_filter_tech_title'     => 'H13 Medical HEPA',
            'landing_filter_tech_description' => 'Medical grade standard',
            'landing_filter_tech_badge_text'  => 'ISO certified filtration',
            'landing_specs_title'           => 'Engineered Specs',
            'landing_specs_subtitle'        => 'Unmatched efficiency',
            'landing_specs_groups'          => json_encode([
                ['tag' => '01/FILTRATION', 'title' => 'Filtration Spec', 'image' => '', 'items' => [['label' => 'CADR', 'value' => '500m3/h']]],
            ]),
            'landing_specs_group_images'    => [
                0 => $specGroupImg,
            ],
        ];

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('products.update', $product->id), $updatePayload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products_landing', [
            'product_id'          => $product->id,
            'status'              => 1,
            'hero_tag'            => 'HERO-TAG-100',
            'hero_title'          => 'Revolutionary Clean Air',
            'science_stat1_value' => '99.99%',
            'filter_tech_title'   => 'H13 Medical HEPA',
            'specs_title'         => 'Engineered Specs',
        ]);

        $landing = ProductLanding::where('product_id', $product->id)->firstOrFail();
        $this->assertCount(1, $landing->science_features);
        $this->assertCount(1, $landing->specs_groups);
        $this->assertNotEmpty($landing->specs_groups[0]['image']);
        /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
        $storage = Storage::disk('public');
        $storage->assertExists($landing->hero_image);
        $storage->assertExists($landing->science_image);
        $storage->assertExists($landing->specs_groups[0]['image']);
    }

    /**
     * Test admin can filter products by 3-level category hierarchy.
     */
    public function test_admin_can_filter_products_by_category_levels(): void
    {
        $parentCat = ProductCategory::create([
            'category_name' => 'Fresh Air Systems',
            'slug'          => 'fresh-air-systems',
            'status'        => 1,
            'parent_id'     => null,
        ]);

        $subCat = ProductCategory::create([
            'category_name' => 'Commercial Ventilators',
            'slug'          => 'commercial-ventilators',
            'status'        => 1,
            'parent_id'     => $parentCat->id,
        ]);

        $childCat = ProductCategory::create([
            'category_name' => 'Roof Mounted Units',
            'slug'          => 'roof-mounted-units',
            'status'        => 1,
            'parent_id'     => $subCat->id,
        ]);

        $otherCat = ProductCategory::create([
            'category_name' => 'Standalone Purifiers',
            'slug'          => 'standalone-purifiers',
            'status'        => 1,
            'parent_id'     => null,
        ]);

        // Product in child category
        $prod1 = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Industrial Roof Ventilator 900',
            'slug'     => 'industrial-roof-ventilator-900',
            'model'    => 'IRV-900',
            'price'    => 1500.00,
            'quantity' => 10,
            'status'   => 1,
        ]);
        $prod1->categories()->attach($childCat->id);

        // Product in standalone category
        $prod2 = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Compact Home Purifier H1',
            'slug'     => 'compact-home-purifier-h1',
            'model'    => 'CHP-H1',
            'price'    => 250.00,
            'quantity' => 20,
            'status'   => 1,
        ]);
        $prod2->categories()->attach($otherCat->id);

        // 1. Filter by Level 1 (Parent): Should return child product via recursive descendant match
        $resLevel1 = $this->actingAs($this->admin, 'user')
            ->getJson("/api/products?level1_id={$parentCat->id}");
        $resLevel1->assertStatus(200);
        $data1 = $resLevel1->json('data.data');
        $ids1 = collect($data1)->pluck('id')->all();
        $this->assertContains($prod1->id, $ids1);
        $this->assertNotContains($prod2->id, $ids1);

        // 2. Filter by Level 2 (Sub)
        $resLevel2 = $this->actingAs($this->admin, 'user')
            ->getJson("/api/products?level2_id={$subCat->id}");
        $resLevel2->assertStatus(200);
        $data2 = $resLevel2->json('data.data');
        $ids2 = collect($data2)->pluck('id')->all();
        $this->assertContains($prod1->id, $ids2);
        $this->assertNotContains($prod2->id, $ids2);

        // 3. Filter by Level 3 (Child)
        $resLevel3 = $this->actingAs($this->admin, 'user')
            ->getJson("/api/products?level3_id={$childCat->id}");
        $resLevel3->assertStatus(200);
        $data3 = $resLevel3->json('data.data');
        $ids3 = collect($data3)->pluck('id')->all();
        $this->assertContains($prod1->id, $ids3);
        $this->assertNotContains($prod2->id, $ids3);

        // 4. Filter by other category: Should only return prod2
        $resOther = $this->actingAs($this->admin, 'user')
            ->getJson("/api/products?level1_id={$otherCat->id}");
        $resOther->assertStatus(200);
        $dataOther = $resOther->json('data.data');
        $idsOther = collect($dataOther)->pluck('id')->all();
        $this->assertContains($prod2->id, $idsOther);
        $this->assertNotContains($prod1->id, $idsOther);
    }
}

