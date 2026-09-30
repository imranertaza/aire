<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFilterWizardTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;
    private ProductCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->category = ProductCategory::create([
            'category_name' => 'Commercial Purifiers',
            'slug'          => 'commercial-purifiers',
            'status'        => 1,
        ]);

        $this->product = Product::create([
            'name'     => 'Industrial Air Scrubber 5000',
            'slug'     => 'industrial-air-scrubber-5000',
            'model'    => 'IAS-5000',
            'price'    => 2500.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        $this->product->categories()->attach($this->category->id);
    }

    public function test_filter_wizard_api_returns_structured_matches(): void
    {
        $response = $this->postJson(route('api.filter-step.query'), [
            'category' => $this->category->slug,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ])
            ->assertJsonStructure([
                'status',
                'count',
                'total',
                'available_options',
                'products',
            ]);

        $this->assertGreaterThanOrEqual(1, $response->json('count'));
    }

    public function test_filter_wizard_api_handles_empty_query_gracefully(): void
    {
        $response = $this->postJson(route('api.filter-step.query'), []);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function test_product_filter_page_returns_successful_response(): void
    {
        $response = $this->get(route('products.filter', $this->category->slug));

        $response->assertStatus(200);
    }
}
