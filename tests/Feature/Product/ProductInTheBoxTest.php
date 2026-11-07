<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDescription;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProductInTheBoxTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Store::firstOrCreate(['id' => 1], [
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);
    }

    public function test_product_descriptions_table_has_nullable_in_the_box_columns(): void
    {
        $this->assertTrue(Schema::hasColumn('product_descriptions', 'in_the_box_badge'));
        $this->assertTrue(Schema::hasColumn('product_descriptions', 'in_the_box_title'));
        $this->assertTrue(Schema::hasColumn('product_descriptions', 'in_the_box_description'));
        $this->assertTrue(Schema::hasColumn('product_descriptions', 'in_the_box_image'));
        $this->assertTrue(Schema::hasColumn('product_descriptions', 'in_the_box_items'));

        $product = Product::create([
            'store_id' => 1,
            'name'     => 'Sample Purifier',
            'slug'     => 'sample-purifier',
            'model'    => 'SP-1',
            'price'    => 499.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        $desc = ProductDescription::create([
            'product_id' => $product->id,
        ]);

        $this->assertNull($desc->in_the_box_badge);
        $this->assertNull($desc->in_the_box_title);
        $this->assertNull($desc->in_the_box_description);
        $this->assertNull($desc->in_the_box_image);
        $this->assertNull($desc->in_the_box_items);
    }

    public function test_product_description_casts_in_the_box_items_as_array(): void
    {
        $product = Product::create([
            'store_id' => 1,
            'name'     => 'Cast Test Unit',
            'slug'     => 'cast-test-unit',
            'model'    => 'CTU-1',
            'price'    => 350.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        $items = [
            ['title' => 'Main Air Unit', 'description' => 'Pre-assembled core'],
            ['title' => 'Magnetic Filter', 'description' => 'H13 HEPA module'],
        ];

        $desc = ProductDescription::create([
            'product_id'             => $product->id,
            'in_the_box_badge'       => 'PACKAGE CONTENTS',
            'in_the_box_title'       => 'Included In The Box',
            'in_the_box_description' => 'Everything needed for installation.',
            'in_the_box_items'       => $items,
        ]);

        $fresh = $desc->fresh();
        $this->assertIsArray($fresh->in_the_box_items);
        $this->assertCount(2, $fresh->in_the_box_items);
        $this->assertEquals('Main Air Unit', $fresh->in_the_box_items[0]['title']);
    }

    public function test_api_store_product_persists_in_the_box_data(): void
    {
        Storage::fake('public');

        $permission = Permission::firstOrCreate(['name' => 'create-products', 'guard_name' => 'user']);
        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        $category = ProductCategory::create([
            'category_name' => 'Ventilation',
            'slug'          => 'ventilation',
            'status'        => 1,
        ]);

        $mainImage = UploadedFile::fake()->image('main.jpg', 800, 800);
        $items = [
            ['title' => 'Ventilation Blower', 'description' => 'Ultra-quiet ECM motor'],
            ['title' => 'Mounting Hardware', 'description' => 'Brackets and vibration dampeners'],
            ['title' => 'Wireless Controller', 'description' => 'Pre-paired smart controller'],
        ];

        $response = $this->actingAs($user, 'user')->postJson('/api/products', [
            'name'                   => 'Pro Ventilator X1',
            'model'                  => 'PV-X1',
            'price'                  => 799.00,
            'quantity'               => 12,
            'status'                 => 1,
            'category_ids'           => [$category->id],
            'main_image'             => $mainImage,
            'in_the_box_badge'       => 'BOX CONTENTS',
            'in_the_box_title'       => 'What Is Included',
            'in_the_box_description' => 'Complete setup kit inside each box.',
            'in_the_box_items'       => json_encode($items),
        ]);

        $response->assertStatus(200);

        $product = Product::where('model', 'PV-X1')->first();
        $this->assertNotNull($product);
        $this->assertNotNull($product->description);
        $this->assertEquals('BOX CONTENTS', $product->description->in_the_box_badge);
        $this->assertEquals('What Is Included', $product->description->in_the_box_title);
        $this->assertIsArray($product->description->in_the_box_items);
        $this->assertCount(3, $product->description->in_the_box_items);
        $this->assertEquals('Ventilation Blower', $product->description->in_the_box_items[0]['title']);
    }

    public function test_api_update_product_updates_in_the_box_data(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'edit-products', 'guard_name' => 'user']);
        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        $category = ProductCategory::create([
            'category_name' => 'Sensors',
            'slug'          => 'sensors',
            'status'        => 1,
        ]);

        $product = Product::create([
            'store_id' => 1,
            'name'     => 'IAQ Monitor S1',
            'slug'     => 'iaq-monitor-s1',
            'model'    => 'IAQ-S1',
            'price'    => 299.00,
            'quantity' => 15,
            'status'   => 1,
        ]);
        $product->categories()->attach($category->id);

        $updatedItems = [
            ['title' => 'Sensor Hub', 'description' => 'Multi-parameter optical sensor'],
            ['title' => 'USB-C Cable', 'description' => '2-meter braided power cable'],
        ];

        $response = $this->actingAs($user, 'user')->postJson("/api/products/{$product->id}", [
            'name'                   => 'IAQ Monitor S1 Updated',
            'model'                  => 'IAQ-S1',
            'price'                  => 310.00,
            'quantity'               => 10,
            'status'                 => 1,
            'category_ids'           => [$category->id],
            'in_the_box_badge'       => 'INCLUDED HARDWARE',
            'in_the_box_title'       => 'Package Contents',
            'in_the_box_description' => 'Detailed list of package parts.',
            'in_the_box_items'       => json_encode($updatedItems),
        ]);

        $response->assertStatus(200);

        $product->refresh();
        $this->assertEquals('INCLUDED HARDWARE', $product->description->in_the_box_badge);
        $this->assertCount(2, $product->description->in_the_box_items);
        $this->assertEquals('Sensor Hub', $product->description->in_the_box_items[0]['title']);
    }

    public function test_storefront_renders_in_the_box_section_when_data_exists(): void
    {
        $category = ProductCategory::create([
            'category_name' => 'Fresh Air Systems',
            'slug'          => 'fresh-air-systems',
            'status'        => 1,
        ]);

        $product = Product::create([
            'store_id' => 1,
            'name'     => 'Fresh Air Unit FB2',
            'slug'     => 'fresh-air-unit-fb2',
            'model'    => 'FAU-FB2',
            'price'    => 1200.00,
            'quantity' => 8,
            'status'   => 1,
        ]);
        $product->categories()->attach($category->id);

        ProductDescription::create([
            'product_id'             => $product->id,
            'in_the_box_badge'       => 'PACKAGE CONTENTS',
            'in_the_box_title'       => 'What is in the box',
            'in_the_box_description' => 'Every single component engineered for seamless installation.',
            'in_the_box_items'       => [
                ['title' => 'Central Air Unit', 'description' => 'High-efficiency motor chassis'],
                ['title' => 'H13 Carbon Filter', 'description' => 'Factory-sealed dual filtration module'],
                ['title' => 'Remote Controller', 'description' => 'Backlit wall mount controller'],
            ],
        ]);

        $response = $this->get(route('products.detail', $product->slug));
        $response->assertStatus(200);

        // Section header and content should appear
        $response->assertSee('id="box"', false);
        $response->assertSee('box-banner', false);
        $response->assertSee('box-glass-card', false);
        $response->assertSee('PACKAGE CONTENTS');
        $response->assertSee('What is in the box');
        $response->assertSee('Central Air Unit');
        $response->assertSee('High-efficiency motor chassis');
        $response->assertSee('01');
        $response->assertSee('02');
        $response->assertSee('03');
    }

    public function test_storefront_hides_in_the_box_section_when_data_is_null_or_empty(): void
    {
        $category = ProductCategory::create([
            'category_name' => 'Air Purifiers',
            'slug'          => 'air-purifiers',
            'status'        => 1,
        ]);

        $product = Product::create([
            'store_id' => 1,
            'name'     => 'Simple Purifier Basic',
            'slug'     => 'simple-purifier-basic',
            'model'    => 'SP-BASIC',
            'price'    => 199.00,
            'quantity' => 20,
            'status'   => 1,
        ]);
        $product->categories()->attach($category->id);

        ProductDescription::create([
            'product_id'             => $product->id,
            'in_the_box_badge'       => null,
            'in_the_box_title'       => null,
            'in_the_box_description' => null,
            'in_the_box_items'       => null,
        ]);

        $response = $this->get(route('products.detail', $product->slug));
        $response->assertStatus(200);

        // Section #box must NOT be present
        $response->assertDontSee('<section id="box"', false);
    }
}
