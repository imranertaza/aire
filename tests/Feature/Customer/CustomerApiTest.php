<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\CustomerLedger;
use App\Models\CustomerPointHistory;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->admin = User::factory()->create();
    }

    public function test_can_list_customers(): void
    {
        Customer::create([
            'firstname' => 'Tanvir',
            'lastname'  => 'Hasan',
            'email'     => 'tanvir@example.com',
            'phone'     => '01711223344',
            'password'  => bcrypt('secret123'),
            'status'    => 1,
        ]);

        $response = $this->withoutMiddleware()
            ->getJson('/api/customers');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_can_search_customers(): void
    {
        Customer::create([
            'firstname' => 'Nayeem',
            'lastname'  => 'Islam',
            'email'     => 'nayeem@example.com',
            'phone'     => '01755667788',
            'password'  => bcrypt('secret123'),
            'status'    => 1,
        ]);

        $response = $this->withoutMiddleware()
            ->getJson('/api/customers?search=Nayeem');

        $response->assertStatus(200)
            ->assertJsonPath('data.data.0.firstname', 'Nayeem');
    }

    public function test_can_create_customer(): void
    {
        $payload = [
            'firstname'    => 'Mahbub',
            'lastname'     => 'Alam',
            'email'        => 'mahbub@example.com',
            'phone'        => '01899887766',
            'password'     => 'password123',
            'con_password' => 'password123',
        ];

        $response = $this->withoutMiddleware()
            ->postJson('/api/customers', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('customers', [
            'email'     => 'mahbub@example.com',
            'firstname' => 'Mahbub',
        ]);
    }

    public function test_can_show_customer(): void
    {
        $customer = Customer::create([
            'firstname' => 'Arif',
            'lastname'  => 'Hossain',
            'email'     => 'arif@example.com',
            'phone'     => '01911223344',
            'password'  => bcrypt('secret123'),
            'status'    => 1,
        ]);

        $response = $this->withoutMiddleware()
            ->getJson('/api/customers/' . $customer->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $customer->id);
    }

    public function test_can_update_customer(): void
    {
        $customer = Customer::create([
            'firstname' => 'Faruk',
            'lastname'  => 'Ahmed',
            'email'     => 'faruk@example.com',
            'phone'     => '01611223344',
            'password'  => bcrypt('secret123'),
            'status'    => 1,
        ]);

        $response = $this->withoutMiddleware()
            ->putJson('/api/customers/' . $customer->id, [
                'firstname' => 'Faruk Updated',
                'lastname'  => 'Ahmed',
                'email'     => 'faruk.updated@example.com',
                'phone'     => '01611223344',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('customers', [
            'id'        => $customer->id,
            'firstname' => 'Faruk Updated',
            'email'     => 'faruk.updated@example.com',
        ]);
    }

    public function test_can_delete_customer(): void
    {
        $customer = Customer::create([
            'firstname' => 'Delete',
            'lastname'  => 'Me',
            'email'     => 'delete.me@example.com',
            'phone'     => '01311223344',
            'password'  => bcrypt('secret123'),
            'status'    => 1,
        ]);

        $response = $this->withoutMiddleware()
            ->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_can_get_customer_ledger_and_points(): void
    {
        $customer = Customer::create([
            'firstname' => 'Ledger',
            'lastname'  => 'User',
            'email'     => 'ledger.user@example.com',
            'phone'     => '01511223344',
            'password'  => bcrypt('secret123'),
            'status'    => 1,
        ]);

        CustomerLedger::create([
            'customer_id'      => $customer->id,
            'particulars'      => 'Test deposit',
            'transaction_type' => 'Cr.',
            'amount'           => 500.00,
            'rest_balance'     => 500.00,
        ]);

        CustomerPointHistory::create([
            'customer_id'      => $customer->id,
            'particulars'      => 'Reward points',
            'transaction_type' => 'Cr.',
            'point'            => 50,
            'rest_point'       => 50,
        ]);

        $ledgerResponse = $this->withoutMiddleware()
            ->getJson('/api/customers/' . $customer->id . '/ledger');
        $ledgerResponse->assertStatus(200);

        $pointResponse = $this->withoutMiddleware()
            ->getJson('/api/customers/' . $customer->id . '/point');
        $pointResponse->assertStatus(200);
    }
}
