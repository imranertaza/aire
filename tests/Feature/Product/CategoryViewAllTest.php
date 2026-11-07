<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CategoryViewAllTest extends TestCase
{
    use RefreshDatabase;

    protected ProductCategory $parentCategory;
    protected ProductCategory $childCategory;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();

        Store::firstOrCreate(['id' => 1], [
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->parentCategory = ProductCategory::create([
            'category_name' => 'Air Purifiers',
            'slug'          => 'air-purifiers',
            'description'   => 'Clean air equipment for home and commercial spaces.',
            'status'        => 1,
            'sort_order'    => 1,
        ]);

        $this->childCategory = ProductCategory::create([
            'parent_id'     => $this->parentCategory->id,
            'category_name' => 'Home Air Purifiers',
            'slug'          => 'home-air-purifiers',
            'description'   => 'Dedicated purifiers engineered for living spaces.',
            'status'        => 1,
            'sort_order'    => 1,
        ]);

        $this->product = Product::create([
            'store_id' => 1,
            'name'     => 'AIRE Fresh Air S100',
            'slug'     => 'aire-fresh-air-s100',
            'model'    => 'S100-PRO',
            'price'    => 650.00,
            'quantity' => 15,
            'status'   => 1,
        ]);

        $this->product->categories()->attach($this->childCategory->id);
    }

    /**
     * Test that category overview page contains "View All" buttons for each category section.
     */
    public function test_category_overview_page_displays_view_all_buttons(): void
    {
        $response = $this->get('/category/air-purifiers');
        $response->assertStatus(200);
        $response->assertSee('category-view-all-link', false);
        $response->assertSee('View All');
        $response->assertSee(route('category.all', $this->childCategory->slug));
    }

    /**
     * Test that dedicated category view-all page loads with status 200 and displays category info.
     */
    public function test_category_view_all_page_renders_successfully(): void
    {
        $response = $this->get(route('category.all', $this->childCategory->slug));
        $response->assertStatus(200);
        $response->assertSee($this->childCategory->category_name);
        $response->assertSee('category-viewall-header-card', false);
        $response->assertSee('ductless-showcase-card', false);
        $response->assertSee('AIRE Fresh Air S100');
    }

    /**
     * Test that category view-all page only returns products belonging to that category.
     */
    public function test_category_view_all_shows_only_products_of_that_category(): void
    {
        // Create an unrelated category and product
        $otherCategory = ProductCategory::create([
            'category_name' => 'Industrial Masks',
            'slug'          => 'industrial-masks',
            'status'        => 1,
        ]);

        $otherProduct = Product::create([
            'store_id' => 1,
            'name'     => 'N95 Pro Respirator',
            'slug'     => 'n95-pro-respirator',
            'model'    => 'N95-PRO',
            'price'    => 45.00,
            'quantity' => 50,
            'status'   => 1,
        ]);
        $otherProduct->categories()->attach($otherCategory->id);

        $response = $this->get(route('category.all', $this->childCategory->slug));
        $response->assertStatus(200);
        $response->assertSee('AIRE Fresh Air S100');
        $response->assertDontSee('N95 Pro Respirator');
    }

    /**
     * Test that searching within a category filters the results.
     */
    public function test_category_view_all_search_filtering(): void
    {
        $response = $this->get(route('category.all', [
            'slug'   => $this->childCategory->slug,
            'search' => 'S100',
        ]));

        $response->assertStatus(200);
        $response->assertSee('AIRE Fresh Air S100');
        $response->assertSee('Showing results for');
    }

    /**
     * Test that a non-existent category returns 404.
     */
    public function test_category_view_all_invalid_category_returns_404(): void
    {
        $response = $this->get('/category/non-existent-category-slug-xyz123/all');
        $response->assertStatus(404);
    }

    /**
     * Test that the legacy category.detail route continues to work.
     */
    public function test_legacy_category_detail_route_still_works(): void
    {
        $response = $this->get(route('category.detail', $this->childCategory->slug));
        $response->assertStatus(200);
        $response->assertSee($this->childCategory->category_name);
    }
}
