<?php

namespace Tests\Feature\Cart;

use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartProductOptionTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;
    private Option $sizeOption;
    private OptionValue $largeValue;
    private OptionValue $smallValue;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->product = Product::create([
            'name'     => 'Aire Pro Purifier',
            'slug'     => 'aire-pro-purifier',
            'model'    => 'APP-100',
            'price'    => 500.00,
            'quantity' => 15,
            'status'   => 1,
        ]);

        $this->sizeOption = Option::create([
            'name' => 'Coverage Size',
            'type' => 'select',
        ]);

        $this->largeValue = OptionValue::create([
            'option_id' => $this->sizeOption->id,
            'name'      => 'Large (800 sq ft)',
        ]);

        $this->smallValue = OptionValue::create([
            'option_id' => $this->sizeOption->id,
            'name'      => 'Compact (300 sq ft)',
        ]);

        ProductOption::create([
            'product_id'      => $this->product->id,
            'option_id'       => $this->sizeOption->id,
            'option_value_id' => $this->largeValue->id,
            'price'           => 100.00,
            'price_prefix'    => '+',
        ]);

        ProductOption::create([
            'product_id'      => $this->product->id,
            'option_id'       => $this->sizeOption->id,
            'option_value_id' => $this->smallValue->id,
            'price'           => 50.00,
            'price_prefix'    => '-',
        ]);
    }

    public function test_adding_product_with_positive_option_price_increases_cart_price(): void
    {
        $response = $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity'   => 1,
            'options'    => [
                $this->largeValue->id => [
                    'name'  => 'Coverage Size',
                    'value' => 'Large (800 sq ft)',
                ],
            ],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success'    => true,
                'cart_count' => 1,
            ]);

        $cart = session()->get('cart');
        $expectedKey = $this->product->id . '_' . $this->largeValue->id;

        $this->assertArrayHasKey($expectedKey, $cart);
        // Base 500 + Option 100 = 600
        $this->assertEquals(600.00, $cart[$expectedKey]['price']);
        $this->assertEquals(100.00, $cart[$expectedKey]['option_price_diff']);
    }

    public function test_adding_product_with_negative_option_price_reduces_cart_price(): void
    {
        $response = $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity'   => 2,
            'options'    => [
                $this->smallValue->id => [
                    'name'  => 'Coverage Size',
                    'value' => 'Compact (300 sq ft)',
                ],
            ],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success'    => true,
                'cart_count' => 2,
            ]);

        $cart = session()->get('cart');
        $expectedKey = $this->product->id . '_' . $this->smallValue->id;

        $this->assertArrayHasKey($expectedKey, $cart);
        // Base 500 - Option 50 = 450
        $this->assertEquals(450.00, $cart[$expectedKey]['price']);
        $this->assertEquals(-50.00, $cart[$expectedKey]['option_price_diff']);
    }

    public function test_product_with_options_prompts_to_select_options_if_omitted(): void
    {
        $response = $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity'   => 1,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success'     => false,
                'has_options' => true,
            ]);
    }
}
