<?php

namespace Tests\Feature\Product;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WishlistAndCompareTest extends TestCase
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
     * Test guest user can toggle product in wishlist (stored in session).
     */
    public function test_guest_can_toggle_wishlist(): void
    {
        $product = Product::create([
            'name'     => 'Wishlist Item 1',
            'model'    => 'WI-01',
            'price'    => 120.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        // 1. Add to wishlist
        $response = $this->postJson(route('favorite.toggle'), [
            'product_id' => $product->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'added'   => true,
        ]);
        $this->assertContains($product->id, session()->get('favorites', []));

        // 2. Remove from wishlist
        $response2 = $this->postJson(route('favorite.toggle'), [
            'product_id' => $product->id,
        ]);

        $response2->assertStatus(200);
        $response2->assertJson([
            'success' => true,
            'added'   => false,
        ]);
        $this->assertNotContains($product->id, session()->get('favorites', []));
    }

    /**
     * Test authenticated customer can toggle wishlist (persisted to database).
     */
    public function test_customer_can_toggle_wishlist(): void
    {
        $customer = Customer::create([
            'firstname' => 'Wish',
            'lastname'  => 'Lover',
            'email'     => 'wish@example.com',
            'phone'     => '01733333333',
            'password'  => Hash::make('password123'),
            'status'    => 1,
        ]);

        $this->actingAs($customer, 'customer');

        $product = Product::create([
            'name'     => 'Wishlist Item 2',
            'model'    => 'WI-02',
            'price'    => 250.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        $response = $this->postJson(route('favorite.toggle'), [
            'product_id' => $product->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'added'   => true,
        ]);

        $customerWishlist = json_decode($customer->fresh()->wishlist, true);
        $this->assertContains($product->id, $customerWishlist);
    }

    /**
     * Test adding and removing products from Compare list.
     */
    public function test_can_add_and_remove_products_in_compare(): void
    {
        $product = Product::create([
            'name'     => 'Compare Model Pro',
            'model'    => 'CMP-01',
            'price'    => 350.00,
            'quantity' => 8,
            'status'   => 1,
        ]);

        // Add to compare
        $response = $this->postJson(route('compare.add'), [
            'product_id' => $product->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'count'   => 1,
        ]);

        // Remove from compare
        $removeResponse = $this->postJson(route('compare.remove'), [
            'product_id' => $product->id,
        ]);

        $removeResponse->assertStatus(200);
        $removeResponse->assertJson([
            'success' => true,
            'count'   => 0,
        ]);
    }
}
