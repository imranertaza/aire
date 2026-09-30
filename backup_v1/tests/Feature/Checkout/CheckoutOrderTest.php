<?php

namespace Tests\Feature\Checkout;

use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\Store;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CheckoutOrderTest extends TestCase
{
    use RefreshDatabase;

    protected Country $country;
    protected Zone $zone;
    protected PaymentMethod $paymentMethod;
    protected ShippingMethod $shippingMethod;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->country = Country::create([
            'name'       => 'United States',
            'iso_code_2' => 'US',
            'iso_code_3' => 'USA',
            'status'     => 1,
        ]);

        $this->zone = Zone::create([
            'country_id' => $this->country->id,
            'name'       => 'California',
            'code'       => 'CA',
            'status'     => 1,
        ]);

        $this->paymentMethod = PaymentMethod::create([
            'name'   => 'Cash On Delivery',
            'code'   => 'cod',
            'status' => 1,
        ]);

        $this->shippingMethod = ShippingMethod::create([
            'name'   => 'Standard Shipping',
            'code'   => 'standard',
            'cost'   => 10.00,
            'status' => 1,
        ]);
    }

    /**
     * Test successful checkout creates order and decrements product stock.
     */
    public function test_checkout_creates_order_and_reduces_stock_successfully(): void
    {
        $product = Product::create([
            'name'     => 'Smart Air Purifier',
            'model'    => 'SAP-100',
            'price'    => 200.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        $cart = [
            (string) $product->id => [
                'id'             => $product->id,
                'name'           => $product->name,
                'quantity'       => 2,
                'price'          => 200.00,
                'original_price' => 200.00,
                'free_delivery'  => false,
            ],
        ];

        $checkoutPayload = [
            'payment_firstname'  => 'John',
            'payment_lastname'   => 'Doe',
            'email'              => 'john@example.com',
            'phone'              => '1234567890',
            'address_1'          => '123 Main St',
            'payment_city'       => 'Los Angeles',
            'payment_country_id' => $this->country->id,
            'payment_zone_id'    => $this->zone->id,
            'zip'                => '90001',
            'payment_method'     => 'cod',
            'shippingMethod'     => 'standard',
        ];

        $response = $this->withSession(['cart' => $cart])
            ->post(route('checkout.post'), $checkoutPayload);

        $response->assertRedirect(route('order.confirm'));

        // Assert order exists in database
        $this->assertDatabaseHas('orders', [
            'email'     => 'john@example.com',
            'total'     => 400.00,
            'telephone' => '1234567890',
        ]);

        // Assert stock decremented by 2 (10 - 2 = 8)
        $this->assertEquals(8, $product->fresh()->quantity);
    }

    /**
     * Test checkout fails and rolls back when product runs out of stock (Pessimistic Locking check).
     */
    public function test_checkout_fails_gracefully_if_stock_is_insufficient(): void
    {
        $product = Product::create([
            'name'     => 'Limited Edition Purifier',
            'model'    => 'LEP-01',
            'price'    => 500.00,
            'quantity' => 1, // Only 1 left in stock
            'status'   => 1,
        ]);

        // Trying to buy 2 items when only 1 is available
        $cart = [
            (string) $product->id => [
                'id'             => $product->id,
                'name'           => $product->name,
                'quantity'       => 2,
                'price'          => 500.00,
                'original_price' => 500.00,
                'free_delivery'  => false,
            ],
        ];

        $checkoutPayload = [
            'payment_firstname'  => 'Jane',
            'payment_lastname'   => 'Smith',
            'email'              => 'jane@example.com',
            'phone'              => '0987654321',
            'address_1'          => '456 Oak St',
            'payment_city'       => 'San Francisco',
            'payment_country_id' => $this->country->id,
            'payment_zone_id'    => $this->zone->id,
            'zip'                => '94101',
            'payment_method'     => 'cod',
            'shippingMethod'     => 'standard',
        ];

        $response = $this->withSession(['cart' => $cart])
            ->post(route('checkout.post'), $checkoutPayload);

        // Expect validation redirect back with errors
        $response->assertSessionHasErrors(['cart']);

        // Assert order was NOT created
        $this->assertDatabaseMissing('orders', [
            'email' => 'jane@example.com',
        ]);

        // Assert original stock remains 1
        $this->assertEquals(1, $product->fresh()->quantity);
    }

    /**
     * Test registered customer checkout with eWallet payment debits balance safely.
     */
    public function test_ewallet_checkout_debits_customer_balance(): void
    {
        $walletPayment = PaymentMethod::create([
            'name'   => 'eWallet',
            'code'   => 'u_wallet',
            'status' => 1,
        ]);

        $customer = Customer::create([
            'firstname' => 'Alice',
            'lastname'  => 'Wonder',
            'email'     => 'alice@example.com',
            'phone'     => '1122334455',
            'password'  => Hash::make('password123'),
            'balance'   => 500.00,
            'status'    => 1,
        ]);

        $product = Product::create([
            'name'     => 'Eco Purifier Mini',
            'model'    => 'EPM-01',
            'price'    => 150.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        $cart = [
            (string) $product->id => [
                'id'             => $product->id,
                'name'           => $product->name,
                'quantity'       => 1,
                'price'          => 150.00,
                'original_price' => 150.00,
                'free_delivery'  => false,
            ],
        ];

        $checkoutPayload = [
            'payment_firstname'  => 'Alice',
            'payment_lastname'   => 'Wonder',
            'email'              => 'alice@example.com',
            'phone'              => '1122334455',
            'address_1'          => '789 Pine St',
            'payment_city'       => 'San Jose',
            'payment_country_id' => $this->country->id,
            'payment_zone_id'    => $this->zone->id,
            'zip'                => '95101',
            'payment_method'     => 'u_wallet',
            'shippingMethod'     => 'standard',
        ];

        $response = $this->actingAs($customer, 'customer')
            ->withSession(['cart' => $cart])
            ->post(route('checkout.post'), $checkoutPayload);

        $response->assertRedirect(route('order.confirm'));

        // Assert customer balance is debited (500 - 150 = 350)
        $this->assertEquals(350.00, $customer->fresh()->balance);

        // Assert customer ledger entry was created
        $this->assertDatabaseHas('customer_ledgers', [
            'customer_id'      => $customer->id,
            'transaction_type' => 'Dr.',
            'amount'           => 150.00,
        ]);
    }
}
