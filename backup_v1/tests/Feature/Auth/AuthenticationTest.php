<?php

namespace Tests\Feature\Auth;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_can_authenticate_using_signin(): void
    {
        $customer = Customer::create([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.com',
            'phone'     => '01711111111',
            'password'  => Hash::make('password123'),
            'status'    => 1,
        ]);

        $response = $this->post(route('signin.post'), [
            'email'    => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated('customer');
    }

    public function test_customers_can_not_authenticate_with_invalid_password(): void
    {
        $customer = Customer::create([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.com',
            'phone'     => '01711111111',
            'password'  => Hash::make('password123'),
            'status'    => 1,
        ]);

        $response = $this->post(route('signin.post'), [
            'email'    => 'johndoe@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('customer');
    }

    public function test_customers_can_logout(): void
    {
        $customer = Customer::create([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.com',
            'phone'     => '01711111111',
            'password'  => Hash::make('password123'),
            'status'    => 1,
        ]);

        $this->actingAs($customer, 'customer');

        $response = $this->post(route('logout'));

        $this->assertGuest('customer');
    }
}
