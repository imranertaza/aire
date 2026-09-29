<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerDashboardTest extends TestCase
{
    use RefreshDatabase;

    private Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();

        \App\Models\Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->customer = Customer::create([
            'firstname' => 'Rahim',
            'lastname'  => 'Uddin',
            'email'     => 'rahim@example.com',
            'phone'     => '01700000000',
            'password'  => bcrypt('secret123'),
            'status'    => 1,
        ]);
    }

    public function test_guest_is_redirected_when_accessing_dashboard(): void
    {
        $response = $this->get(route('customer.dashboard'));

        $response->assertRedirect(route('signin'));
    }

    public function test_authenticated_customer_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->get(route('customer.dashboard'));

        $response->assertStatus(200);
    }

    public function test_authenticated_customer_can_view_orders_and_invoice(): void
    {
        $status = OrderStatus::create([
            'name' => 'Pending',
        ]);

        $order = Order::create([
            'customer_id'       => $this->customer->id,
            'status'            => $status->id,
            'total'             => 1500,
            'shipping_firstname'=> 'Rahim',
            'shipping_lastname' => 'Uddin',
            'shipping_address_1'=> 'Dhaka, Bangladesh',
            'shipping_city'     => 'Dhaka',
            'payment_method'    => 'cod',
            'ip'                => '127.0.0.1',
        ]);

        $product = Product::create([
            'name'     => 'Sample Order Item',
            'slug'     => 'sample-order-item',
            'price'    => 1500,
            'quantity' => 10,
            'status'   => 1,
        ]);

        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'name'       => $product->name,
            'quantity'   => 1,
            'price'      => 1500,
            'total'      => 1500,
        ]);

        // Test orders list
        $ordersResponse = $this->actingAs($this->customer, 'customer')
            ->get(route('customer.orders'));
        $ordersResponse->assertStatus(200);

        // Test order detail
        $detailResponse = $this->actingAs($this->customer, 'customer')
            ->get(route('customer.orders.detail', $order->id));
        $detailResponse->assertStatus(200);

        // Test order invoice
        $invoiceResponse = $this->actingAs($this->customer, 'customer')
            ->get(route('customer.invoice', $order->id));
        $invoiceResponse->assertStatus(200);
    }

    public function test_customer_can_update_profile(): void
    {
        $response = $this->actingAs($this->customer, 'customer')
            ->post(route('customer.profile.update'), [
                'firstname' => 'Karim',
                'lastname'  => 'Chowdhury',
                'email'     => 'karim@example.com',
                'phone'     => '01811112233',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('customers', [
            'id'        => $this->customer->id,
            'firstname' => 'Karim',
            'lastname'  => 'Chowdhury',
            'email'     => 'karim@example.com',
            'phone'     => '01811112233',
        ]);
    }

    public function test_customer_can_view_wallet_and_submit_fund_request(): void
    {
        $paymentMethod = PaymentMethod::create([
            'name'   => 'bKash Manual',
            'code'   => 'bkash_manual',
            'status' => 1,
        ]);

        // Wallet page view
        $walletResponse = $this->actingAs($this->customer, 'customer')
            ->get(route('customer.wallet'));
        $walletResponse->assertStatus(200);

        // Add fund request
        $addFundResponse = $this->actingAs($this->customer, 'customer')
            ->post(route('customer.wallet.add-funds'), [
                'amount'            => 500,
                'payment_method_id' => $paymentMethod->id,
                'notes'             => 'TrxID: 9X8Y7Z',
            ]);

        $addFundResponse->assertSessionHasNoErrors();
        $addFundResponse->assertRedirect();

        $this->assertDatabaseHas('fund_requests', [
            'customer_id'       => $this->customer->id,
            'amount'            => 500,
            'payment_method_id' => $paymentMethod->id,
            'status'            => 'Pending',
        ]);
    }
}
