<?php

namespace Tests\Unit;

use App\Services\Cart\CartService;
use App\Services\Coupon\CouponService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCalculationUnitTest extends TestCase
{
    use RefreshDatabase;
    private CartService $cartService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartService = new CartService(new CouponService());
    }

    public function test_subtotal_calculates_correctly_for_multiple_items(): void
    {
        $cart = [
            'item_1' => ['id' => 1, 'price' => 200.00, 'quantity' => 2], // 400.00
            'item_2' => ['id' => 2, 'price' => 150.50, 'quantity' => 1], // 150.50
            'item_3' => ['id' => 3, 'price' => 50.00,  'quantity' => 3], // 150.00
        ];

        $subtotal = $this->cartService->getSubtotal($cart);

        $this->assertEquals(700.50, $subtotal);
    }

    public function test_subtotal_returns_zero_for_empty_cart(): void
    {
        $subtotal = $this->cartService->getSubtotal([]);

        $this->assertEquals(0.00, $subtotal);
    }

    public function test_free_delivery_detected_from_item_flag(): void
    {
        $cartWithFreeDelivery = [
            'item_1' => ['id' => 1, 'price' => 200.00, 'quantity' => 1, 'free_delivery' => true],
            'item_2' => ['id' => 2, 'price' => 100.00, 'quantity' => 1, 'free_delivery' => false],
        ];

        $this->assertTrue($this->cartService->isFreeDelivery($cartWithFreeDelivery));
    }

    public function test_free_delivery_returns_false_when_no_item_has_flag(): void
    {
        $cartWithoutFreeDelivery = [
            'item_1' => ['id' => 1, 'price' => 200.00, 'quantity' => 1, 'free_delivery' => false],
        ];

        $this->assertFalse($this->cartService->isFreeDelivery($cartWithoutFreeDelivery));
    }
}
