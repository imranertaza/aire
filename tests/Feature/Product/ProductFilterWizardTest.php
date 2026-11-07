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

    public function test_guided_product_finder_routes_return_successful_response(): void
    {
        $response1 = $this->get(route('products.filter-step'));
        $response1->assertStatus(200);

        $response2 = $this->get(route('products.finder'));
        $response2->assertStatus(200);
    }

    public function test_filter_option_supports_guided_finder_fields(): void
    {
        $option = \App\Models\FilterOption::create([
            'name'                  => 'Application Environment',
            'type'                  => 'radio',
            'show_in_catalog'       => 1,
            'show_in_guided_finder' => 1,
            'guided_step_number'    => 1,
            'guided_question'       => '01 WHERE WILL YOU USE IT?',
            'guided_subtitle'       => 'Select environment',
            'has_unknown_option'    => 1,
            'unknown_option_label'  => "I don't know",
            'status'                => 1,
        ]);

        $val = $option->optionValues()->create([
            'name'        => 'Single Room',
            'explanation' => 'Selected: Single Room. Routes user to room solutions.',
            'sort_order'  => 0,
            'status'      => 1,
        ]);

        $this->assertEquals(1, $option->show_in_guided_finder);
        $this->assertEquals(1, $option->guided_step_number);
        $this->assertEquals('01 WHERE WILL YOU USE IT?', $option->guided_question);
        $this->assertEquals('Selected: Single Room. Routes user to room solutions.', $val->explanation);
    }
}
