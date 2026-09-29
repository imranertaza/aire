<?php

namespace Tests\Feature\Auth;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \App\Models\Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);
    }

    public function test_new_customers_can_register(): void
    {
        $response = $this->post(route('signup.post'), [
            'name'                  => 'Test Customer',
            'email'                 => 'customer@example.com',
            'phone'                 => '01700000000',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticated('customer');
        $this->assertDatabaseHas('customers', [
            'email' => 'customer@example.com',
        ]);
    }
}
