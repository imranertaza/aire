<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use App\Models\ProductFreeDelivery;
use App\Models\Store;
use App\Services\Cart\CartService;
use App\Services\Coupon\CouponService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected CartService $cartService;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->cartService = new CartService(new CouponService());
    }

    /**
     * Test adding a valid in-stock product to cart.
     */
    public function test_can_add_product_to_cart_successfully(): void
    {
        $product = Product::create([
            'name'     => 'Air Purifier Pro X',
            'model'    => 'AP-PRO-X',
            'price'    => 199.99,
            'quantity' => 10,
            'status'   => 1,
        ]);

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success'    => true,
            'cart_count' => 2,
        ]);

        $cart = session()->get('cart', []);
        $this->assertArrayHasKey((string) $product->id, $cart);
        $this->assertEquals(2, $cart[(string) $product->id]['quantity']);
        $this->assertEquals(199.99, $cart[(string) $product->id]['price']);
    }

    /**
     * Test adding an out-of-stock product returns an error.
     */
    public function test_cannot_add_out_of_stock_product(): void
    {
        $product = Product::create([
            'name'     => 'Out of Stock Purifier',
            'model'    => 'AP-ZERO',
            'price'    => 99.00,
            'quantity' => 0,
            'status'   => 1,
        ]);

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Product is currently out of stock.',
        ]);
    }

    /**
     * Test updating product quantity in cart.
     */
    public function test_can_update_cart_quantity(): void
    {
        $product = Product::create([
            'name'     => 'Air Filter Replacement',
            'model'    => 'AF-100',
            'price'    => 49.50,
            'quantity' => 15,
            'status'   => 1,
        ]);

        // Add 1 to cart
        $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        // Update to 3
        $response = $this->postJson(route('cart.update'), [
            'product_id' => (string) $product->id,
            'quantity'   => 3,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success'    => true,
            'cart_count' => 3,
        ]);

        $cart = session()->get('cart', []);
        $this->assertEquals(3, $cart[(string) $product->id]['quantity']);
    }

    /**
     * Test removing an item from cart.
     */
    public function test_can_remove_item_from_cart(): void
    {
        $product = Product::create([
            'name'     => 'Pre-Filter Mesh',
            'model'    => 'PF-01',
            'price'    => 20.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $response = $this->postJson(route('cart.remove'), [
            'product_id' => (string) $product->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success'    => true,
            'cart_count' => 0,
            'cart_empty' => true,
        ]);

        $cart = session()->get('cart', []);
        $this->assertEmpty($cart);
    }

    /**
     * Test Save for Later and Move back to Cart flow.
     */
    public function test_save_for_later_and_move_back_to_cart(): void
    {
        $product = Product::create([
            'name'     => 'HEPA 13 Filter',
            'model'    => 'HEPA-13',
            'price'    => 75.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);

        // Save for later
        $saveResponse = $this->postJson(route('cart.save-later'), [
            'product_id' => (string) $product->id,
        ]);

        $saveResponse->assertStatus(200);
        $this->assertEmpty(session()->get('cart', []));
        $this->assertArrayHasKey((string) $product->id, session()->get('saved_for_later', []));

        // Move back to cart
        $moveResponse = $this->postJson(route('cart.move-to-cart'), [
            'product_id' => (string) $product->id,
        ]);

        $moveResponse->assertStatus(200);
        $this->assertArrayHasKey((string) $product->id, session()->get('cart', []));
        $this->assertEmpty(session()->get('saved_for_later', []));
    }

    /**
     * Test Cart Subtotal and Free Delivery calculation.
     */
    public function test_cart_subtotal_and_free_delivery_detection(): void
    {
        $product1 = Product::create([
            'name'     => 'Product A',
            'model'    => 'PA-1',
            'price'    => 100.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        $product2 = Product::create([
            'name'     => 'Product B',
            'model'    => 'PB-2',
            'price'    => 50.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        ProductFreeDelivery::create([
            'product_id' => $product2->id,
        ]);

        $cart = [
            (string) $product1->id => [
                'id'            => $product1->id,
                'name'          => $product1->name,
                'quantity'      => 2,
                'price'         => 100.00,
                'free_delivery' => false,
            ],
            (string) $product2->id => [
                'id'            => $product2->id,
                'name'          => $product2->name,
                'quantity'      => 1,
                'price'         => 50.00,
                'free_delivery' => true,
            ],
        ];

        $subtotal = $this->cartService->getSubtotal($cart);
        $this->assertEquals(250.00, $subtotal);

        $isFreeDelivery = $this->cartService->isFreeDelivery($cart);
        $this->assertTrue($isFreeDelivery);
    }
}
