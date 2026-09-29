<?php

namespace Tests\Feature\Auth;

use App\Mail\CustomerResetPasswordMail;
use App\Models\Customer;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
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

    public function test_reset_password_link_can_be_requested(): void
    {
        Mail::fake();

        $customer = Customer::create([
            'firstname' => 'Reset',
            'lastname'  => 'User',
            'email'     => 'reset@example.com',
            'phone'     => '01722222222',
            'password'  => Hash::make('password123'),
            'status'    => 1,
        ]);

        $response = $this->post(route('password.email'), [
            'email' => $customer->email,
        ]);

        $response->assertSessionHasNoErrors();
        Mail::assertSent(CustomerResetPasswordMail::class, function ($mail) use ($customer) {
            return $mail->hasTo($customer->email);
        });
    }
}
