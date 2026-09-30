<?php

namespace Tests\Unit;

use App\Models\Coupon;
use App\Services\Coupon\CouponService;
use Tests\TestCase;

class CouponCalculationUnitTest extends TestCase
{
    private CouponService $couponService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->couponService = new CouponService();
    }

    public function test_percentage_discount_calculated_correctly(): void
    {
        $coupon = new Coupon([
            'discount_type' => 1, // Percentage
            'discount_on'   => 1, // Product
            'discount'      => 15.00, // 15%
        ]);

        $subtotal = 1000.00;
        $discount = $this->couponService->calculateDiscount($subtotal, 0.00, $coupon);

        $this->assertEquals(150.00, $discount);
    }

    public function test_flat_discount_calculated_correctly(): void
    {
        $coupon = new Coupon([
            'discount_type' => 2, // Flat
            'discount_on'   => 1, // Product
            'discount'      => 75.00, // $75 Flat
        ]);

        $subtotal = 500.00;
        $discount = $this->couponService->calculateDiscount($subtotal, 0.00, $coupon);

        $this->assertEquals(75.00, $discount);
    }

    public function test_discount_cannot_exceed_total_amount(): void
    {
        $coupon = new Coupon([
            'discount_type' => 2, // Flat
            'discount_on'   => 1,
            'discount'      => 500.00,
        ]);

        $subtotal = 200.00;
        $shipping = 50.00;
        $discount = $this->couponService->calculateDiscount($subtotal, $shipping, $coupon);

        // Max discount cannot exceed $250 ($200 + $50)
        $this->assertEquals(250.00, $discount);
    }

    public function test_shipping_percentage_discount_calculated_correctly(): void
    {
        $coupon = new Coupon([
            'discount_type' => 1, // Percentage
            'discount_on'   => 2, // Shipping
            'discount'      => 50.00, // 50% off shipping
        ]);

        $subtotal = 1000.00;
        $shipping = 100.00;
        $discount = $this->couponService->calculateDiscount($subtotal, $shipping, $coupon);

        $this->assertEquals(50.00, $discount);
    }
}
