<?php

namespace Tests\Feature\Checkout;

use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\Store;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutShippingTest extends TestCase
{
    use RefreshDatabase;

    private Country $country;
    private Zone $zone;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->country = Country::create([
            'name'       => 'Bangladesh',
            'iso_code_2' => 'BD',
            'iso_code_3' => 'BGD',
            'status'     => 1,
        ]);

        $this->zone = Zone::create([
            'country_id' => $this->country->id,
            'name'       => 'Dhaka City',
            'code'       => 'DHK',
            'status'     => 1,
        ]);

        ShippingMethod::create([
            'name'   => 'Standard Courier',
            'code'   => 'standard',
            'cost'   => 60.00,
            'status' => 1,
        ]);

        PaymentMethod::create([
            'name'   => 'Cash On Delivery',
            'code'   => 'cod',
            'status' => 1,
        ]);
    }

    public function test_get_zones_returns_correct_list(): void
    {
        $response = $this->postJson(route('checkout.zones'), [
            'country_id' => $this->country->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertCount(1, $response->json('zones'));
        $this->assertEquals('Dhaka City', $response->json('zones.0.name'));
    }

    public function test_get_zones_empty_country_returns_empty_list(): void
    {
        $response = $this->postJson(route('checkout.zones'), [
            'country_id' => null,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'zones'   => [],
            ]);
    }

    public function test_shipping_rate_calculates_summary(): void
    {
        $product = Product::create([
            'name'     => 'Air Filter HEPA',
            'slug'     => 'air-filter-hepa',
            'model'    => 'AF-100',
            'price'    => 1200.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        // Place item in cart
        session()->put('cart', [
            (string) $product->id => [
                'id'             => $product->id,
                'name'           => $product->name,
                'quantity'       => 1,
                'price'          => 1200.00,
                'original_price' => 1200.00,
                'free_delivery'  => false,
            ],
        ]);

        $response = $this->postJson(route('checkout.shipping-rate'), [
            'country_id' => $this->country->id,
            'city_id'    => (string) $this->zone->id,
            'paymethod'  => 'standard',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'charge',
                'subtotal',
                'grand_total',
            ]);
    }
}
