<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);
    }

    /**
     * Test categories catalog page returns 200 OK.
     */
    public function test_categories_page_returns_successful_response(): void
    {
        $response = $this->get(route('categories'));

        $response->assertStatus(200);
    }

    /**
     * Test product detail page returns 200 OK.
     */
    public function test_product_detail_page_returns_successful_response(): void
    {
        $product = Product::create([
            'name'     => 'Industrial Air Scrubber 500',
            'model'    => 'IAS-500',
            'price'    => 899.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        $response = $this->get(route('products.detail', $product->slug));

        $response->assertStatus(200);
        $response->assertSee('Industrial Air Scrubber 500');
    }

    /**
     * Test inactive product detail returns 404.
     */
    public function test_inactive_product_detail_returns_404(): void
    {
        $product = Product::create([
            'name'     => 'Deactivated Product',
            'model'    => 'DP-00',
            'price'    => 100.00,
            'quantity' => 10,
            'status'   => 0, // Inactive
        ]);

        $response = $this->get(route('products.detail', $product->slug));

        $response->assertStatus(404);
    }

    /**
     * Test live dropdown search returns JSON results.
     */
    public function test_dropdown_search_returns_json_matches(): void
    {
        $product = Product::create([
            'name'     => 'Smart Carbon Filter',
            'model'    => 'SCF-99',
            'price'    => 120.00,
            'quantity' => 20,
            'status'   => 1,
        ]);

        $response = $this->getJson(route('product.dropdown', ['search' => 'Carbon']));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
        ]);
    }
}
