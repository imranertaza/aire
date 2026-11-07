<?php

namespace Tests\Feature\Product;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProductQuickviewImageTest extends TestCase
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

    public function test_products_table_has_nullable_quickview_image_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'quickview_image'));

        $product = Product::create([
            'store_id' => 1,
            'name'     => 'Sample Purifier No Quickview',
            'slug'     => 'sample-purifier-no-quickview',
            'model'    => 'SP-NQ-1',
            'price'    => 499.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        $this->assertNull($product->quickview_image);
    }

    public function test_product_can_be_created_with_quickview_image_via_api(): void
    {
        Storage::fake('public');

        $permission = Permission::firstOrCreate(['name' => 'create-products', 'guard_name' => 'user']);
        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        $category = ProductCategory::create([
            'category_name' => 'Air Cleaners',
            'slug'          => 'air-cleaners',
            'status'        => 1,
        ]);

        $mainImage = UploadedFile::fake()->image('main.jpg', 800, 800);
        $quickviewImage = UploadedFile::fake()->image('quickview.png', 400, 400);

        $response = $this->actingAs($user, 'user')->postJson('/api/products', [
            'name'            => 'Air Cleaner Pro 200',
            'model'           => 'ACP-200',
            'price'           => 650.00,
            'quantity'        => 5,
            'status'          => 1,
            'category_ids'    => [$category->id],
            'main_image'      => $mainImage,
            'quickview_image' => $quickviewImage,
        ]);

        $response->assertStatus(200);

        $product = Product::where('model', 'ACP-200')->first();
        $this->assertNotNull($product);
        $this->assertNotNull($product->quickview_image);
        $this->assertStringContainsString('quickview', $product->quickview_image);
        Storage::disk('public')->assertExists($product->quickview_image);
    }

    public function test_product_can_update_or_delete_quickview_image(): void
    {
        Storage::fake('public');

        $permission = Permission::firstOrCreate(['name' => 'edit-products', 'guard_name' => 'user']);
        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        $category = ProductCategory::create([
            'category_name' => 'Sensors',
            'slug'          => 'sensors',
            'status'        => 1,
        ]);

        $product = Product::create([
            'store_id'        => 1,
            'name'            => 'IAQ Sensor Mini',
            'slug'            => 'iaq-sensor-mini',
            'model'           => 'ISM-10',
            'price'           => 199.00,
            'quantity'        => 20,
            'status'          => 1,
            'main_image'      => 'product/1/main.jpg',
            'quickview_image' => 'product/1/old-quickview.png',
        ]);
        $product->categories()->attach($category->id);

        // Upload new quickview image
        $newQuickviewImage = UploadedFile::fake()->image('new-quickview.webp', 400, 400);

        $updateResponse = $this->actingAs($user, 'user')->postJson("/api/products/{$product->id}", [
            'name'            => 'IAQ Sensor Mini Updated',
            'model'           => 'ISM-10',
            'price'           => 199.00,
            'quantity'        => 20,
            'status'          => 1,
            'category_ids'    => [$category->id],
            'quickview_image' => $newQuickviewImage,
        ]);

        $updateResponse->assertStatus(200);

        $product->refresh();
        $this->assertNotNull($product->quickview_image);
        Storage::disk('public')->assertExists($product->quickview_image);

        // Remove quickview image via deleted_files
        $deleteResponse = $this->actingAs($user, 'user')->postJson("/api/products/{$product->id}", [
            'name'          => 'IAQ Sensor Mini Updated',
            'model'         => 'ISM-10',
            'price'         => 199.00,
            'quantity'      => 20,
            'status'        => 1,
            'category_ids'  => [$category->id],
            'deleted_files' => ['quickview_image'],
        ]);

        $deleteResponse->assertStatus(200);

        $product->refresh();
        $this->assertNull($product->quickview_image);
    }

    public function test_megamenu_quick_view_prioritizes_quickview_image_and_falls_back_to_main_image(): void
    {
        Cache::forget('layout_main_header_menu_v2');

        $parentCat = ProductCategory::create([
            'category_name' => 'HVAC Systems',
            'slug'          => 'hvac-systems',
            'status'        => 1,
        ]);

        $childCat = ProductCategory::create([
            'parent_id'     => $parentCat->id,
            'category_name' => 'Ductless Units',
            'slug'          => 'ductless-units',
            'status'        => 1,
            'sort_order'    => 1,
        ]);

        // Product 1 with custom quickview_image
        $product1 = Product::create([
            'store_id'        => 1,
            'name'            => 'Custom Quickview Purifier',
            'slug'            => 'custom-quickview-purifier',
            'model'           => 'CQP-1',
            'price'           => 899.00,
            'quantity'        => 5,
            'status'          => 1,
            'main_image'      => 'https://example.com/regular-main.jpg',
            'quickview_image' => 'https://example.com/exclusive-quickview.png',
        ]);
        $childCat->products()->attach($product1->id);

        // Product 2 without quickview_image (fallback to main_image)
        $product2 = Product::create([
            'store_id'        => 1,
            'name'            => 'Fallback Main Purifier',
            'slug'            => 'fallback-main-purifier',
            'model'           => 'FMP-2',
            'price'           => 699.00,
            'quantity'        => 5,
            'status'          => 1,
            'main_image'      => 'https://example.com/fallback-main.jpg',
            'quickview_image' => null,
        ]);
        $childCat->products()->attach($product2->id);

        $headerMenu = Menu::firstOrCreate(
            ['position' => 'header'],
            ['name' => 'Main Header', 'enabled' => 1]
        );

        MenuItem::create([
            'menu_id'             => $headerMenu->id,
            'name'                => 'HVAC Systems',
            'link_type'           => 'product_category',
            'product_category_id' => $parentCat->id,
            'has_quick_view'      => 1,
            'enabled'             => true,
            'order'               => 1,
        ]);

        Cache::forget('layout_main_header_menu_v2');

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        // Product 1 renders exclusive-quickview.png
        $response->assertSee('exclusive-quickview.png');
        // Product 2 falls back to fallback-main.jpg
        $response->assertSee('fallback-main.jpg');
    }
}
