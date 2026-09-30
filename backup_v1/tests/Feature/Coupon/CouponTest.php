<?php

namespace Tests\Feature\Coupon;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Store;
use App\Services\Cart\CartService;
use App\Services\Coupon\CouponService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    protected CouponService $couponService;
    protected CartService $cartService;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->couponService = new CouponService();
        $this->cartService = new CartService($this->couponService);
    }

    /**
     * Test applying percentage discount coupon.
     */
    public function test_can_apply_percentage_coupon_successfully(): void
    {
        $coupon = Coupon::create([
            'name'          => '10% Discount',
            'code'          => 'SAVE10',
            'discount_type' => 1, // Percentage
            'discount_on'   => 1, // Product
            'discount'      => 10.00,
            'date_start'    => Carbon::now()->subDays(5)->toDateString(),
            'date_end'      => Carbon::now()->addDays(5)->toDateString(),
            'status'        => 1,
        ]);

        $product = Product::create([
            'name'     => 'Air Purifier 300',
            'model'    => 'AP-300',
            'price'    => 200.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        $cart = [
            (string) $product->id => [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => 200.00,
                'quantity' => 1,
            ],
        ];

        $response = $this->withSession(['cart' => $cart])
            ->postJson(route('coupon.apply'), [
                'coupon_code' => 'SAVE10',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success'  => true,
            'discount' => 20.00, // 10% of 200.00 = 20.00
        ]);
    }

    /**
     * Test applying expired coupon returns error.
     */
    public function test_cannot_apply_expired_coupon(): void
    {
        Coupon::create([
            'name'          => 'Expired Deal',
            'code'          => 'EXPIRED',
            'discount_type' => 2, // Flat
            'discount_on'   => 1,
            'discount'      => 50.00,
            'date_start'    => Carbon::now()->subDays(20)->toDateString(),
            'date_end'      => Carbon::now()->subDays(1)->toDateString(),
            'status'        => 1,
        ]);

        $response = $this->postJson(route('coupon.apply'), [
            'coupon_code' => 'EXPIRED',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid or expired coupon code.',
        ]);
    }

    /**
     * Test removing applied coupon.
     */
    public function test_can_remove_applied_coupon(): void
    {
        $coupon = Coupon::create([
            'name'          => 'Flat 15',
            'code'          => 'FLAT15',
            'discount_type' => 2,
            'discount_on'   => 1,
            'discount'      => 15.00,
            'date_start'    => Carbon::now()->subDays(1)->toDateString(),
            'date_end'      => Carbon::now()->addDays(5)->toDateString(),
            'status'        => 1,
        ]);

        $response = $this->withSession(['applied_coupon' => $coupon])
            ->postJson(route('coupon.remove'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }
}
