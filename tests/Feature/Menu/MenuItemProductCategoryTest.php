<?php

namespace Tests\Feature\Menu;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MenuItemProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \App\Models\Store::firstOrCreate([
            'id' => 1,
        ], [
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);
    }

    public function test_menu_item_supports_product_category_link_type(): void
    {
        $category = ProductCategory::firstOrCreate(
            ['slug' => 'test-purifiers-cat'],
            ['category_name' => 'Test Purifiers Cat', 'status' => 1]
        );

        $menu = Menu::firstOrCreate(
            ['name' => 'Test Navigation Menu'],
            ['position' => 'header', 'enabled' => 1]
        );

        $menuItem = MenuItem::create([
            'menu_id'             => $menu->id,
            'name'                => 'Purifiers Nav',
            'link_type'           => 'product_category',
            'product_category_id' => $category->id,
            'has_quick_view'      => 1,
            'enabled'             => true,
            'order'               => 1,
        ]);

        $this->assertEquals('product_category', $menuItem->link_type);
        $this->assertEquals($category->id, $menuItem->product_category_id);
        $this->assertTrue($menuItem->has_quick_view);
        $this->assertEquals(route('category.show', $category->slug), $menuItem->url);
        $this->assertEquals($category->id, $menuItem->productCategory->id);
    }

    public function test_api_validates_and_updates_product_category_link(): void
    {
        $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'manage-menus', 'guard_name' => 'user']);
        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        $category = ProductCategory::firstOrCreate(
            ['slug' => 'test-solutions-cat'],
            ['category_name' => 'Test Solutions Cat', 'status' => 1]
        );

        $menu = Menu::firstOrCreate(
            ['name' => 'Test API Menu'],
            ['position' => 'header', 'enabled' => 1]
        );

        $menuItem = MenuItem::create([
            'menu_id'        => $menu->id,
            'name'           => 'Custom Link',
            'link_type'      => 'url',
            'url'            => 'https://example.com',
            'has_quick_view' => 0,
            'enabled'        => true,
            'order'          => 1,
        ]);

        $response = $this->actingAs($user, 'user')->putJson("/api/menu-items/{$menuItem->id}", [
            'name'                => 'Updated Solutions',
            'link_type'           => 'product_category',
            'product_category_id' => $category->id,
            'has_quick_view'      => 1,
        ]);

        $response->assertStatus(200);

        $menuItem->refresh();
        $this->assertEquals('product_category', $menuItem->link_type);
        $this->assertEquals($category->id, $menuItem->product_category_id);
        $this->assertTrue($menuItem->has_quick_view);
        $this->assertEquals(route('category.show', $category->slug), $menuItem->url);
    }

    public function test_header_renders_dynamic_quick_view_when_has_quick_view_is_enabled(): void
    {
        Cache::forget('layout_main_header_menu_v2');

        $parentCat = ProductCategory::create([
            'category_name' => 'Commercial Purifiers',
            'slug'          => 'commercial-purifiers',
            'description'   => 'High power commercial air solutions',
            'status'        => 1,
        ]);

        $childCat = ProductCategory::create([
            'parent_id'     => $parentCat->id,
            'category_name' => 'Ceiling Mounted',
            'slug'          => 'ceiling-mounted',
            'description'   => 'Ductless ceiling units',
            'status'        => 1,
            'sort_order'    => 1,
        ]);

        $product = Product::create([
            'store_id' => 1,
            'name'     => 'Aire Ultra Pro 5000',
            'slug'     => 'aire-ultra-pro-5000',
            'model'    => 'AUP-5000',
            'price'    => 1299.00,
            'quantity' => 15,
            'status'   => 1,
        ]);
        $childCat->products()->attach($product->id);

        $headerMenu = Menu::firstOrCreate(
            ['position' => 'header'],
            ['name' => 'Main Header', 'enabled' => 1]
        );

        $menuItem = MenuItem::create([
            'menu_id'             => $headerMenu->id,
            'name'                => 'Commercial Purifiers',
            'link_type'           => 'product_category',
            'product_category_id' => $parentCat->id,
            'has_quick_view'      => 1,
            'enabled'             => true,
            'order'               => 1,
        ]);

        Cache::forget('layout_main_header_menu_v2');

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('data-megamenu-target="quickViewMenu-' . $menuItem->id . '"', false);
        $response->assertSee('id="quickViewMenu-' . $menuItem->id . '"', false);
        $response->assertSee('Commercial Purifiers');
        $response->assertSee('Ceiling Mounted');
        $response->assertSee('Aire Ultra Pro 5000');
    }

    public function test_header_does_not_render_quick_view_when_has_quick_view_is_disabled(): void
    {
        Cache::forget('layout_main_header_menu_v2');

        $parentCat = ProductCategory::create([
            'category_name' => 'Home Air Purifiers',
            'slug'          => 'home-air-purifiers',
            'status'        => 1,
        ]);

        $headerMenu = Menu::firstOrCreate(
            ['position' => 'header'],
            ['name' => 'Main Header', 'enabled' => 1]
        );

        $menuItem = MenuItem::create([
            'menu_id'             => $headerMenu->id,
            'name'                => 'Home Purifiers Link',
            'link_type'           => 'product_category',
            'product_category_id' => $parentCat->id,
            'has_quick_view'      => 0,
            'enabled'             => true,
            'order'               => 1,
        ]);

        Cache::forget('layout_main_header_menu_v2');

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertDontSee('data-megamenu-target="quickViewMenu-' . $menuItem->id . '"', false);
        $response->assertDontSee('id="quickViewMenu-' . $menuItem->id . '"', false);
    }
}
