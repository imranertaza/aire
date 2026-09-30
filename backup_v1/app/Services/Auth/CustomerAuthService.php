<?php

namespace App\Services\Auth;

use App\Models\Customer;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CustomerAuthService
{
    /**
     * Attempt customer authentication with active status requirement.
     *
     * @param array $credentials ['email' => string, 'password' => string]
     * @param bool  $remember
     * @return bool
     */
    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        return Auth::guard('customer')->attempt(
            [
                'email'    => $credentials['email'],
                'password' => $credentials['password'],
                'status'   => 1,
            ],
            $remember
        );
    }

    /**
     * Check if a customer account exists but is currently deactivated.
     *
     * @param string $email
     * @return bool
     */
    public function isAccountDeactivated(string $email): bool
    {
        return Customer::where('email', $email)
            ->deactivated()
            ->exists();
    }

    /**
     * Register a new customer, fire the Registered event, and log them in.
     *
     * @param array  $data
     * @param string $ip
     * @return Customer
     */
    public function register(array $data, string $ip): Customer
    {
        // Safely split name into firstname and lastname (max 32 chars each)
        $parts = preg_split('/\s+/', trim((string) ($data['name'] ?? '')), 2);
        $firstname = Str::substr($parts[0] ?? '', 0, 32);
        $lastname  = Str::substr($parts[1] ?? '', 0, 32);

        $customer = Customer::create([
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? '',
            'password'  => Hash::make($data['password']),
            'salt'      => Str::random(9),
            'ip'        => $ip,
            'status'    => 1,
        ]);

        event(new Registered($customer));

        Auth::guard('customer')->login($customer);

        return $customer;
    }

    /**
     * Generate password reset token and dispatch reset notification.
     *
     * @param string $email
     * @throws \RuntimeException
     * @return void
     */
    public function sendResetLink(string $email): void
    {
        $customer = Customer::where('email', $email)->active()->first();

        if (! $customer) {
            return;
        }

        /** @var \Illuminate\Auth\Passwords\PasswordBroker $broker */
        $broker = Password::broker('customers');
        $token = $broker->createToken($customer);

        $customer->sendPasswordResetNotification($token);
    }

    /**
     * Reset the customer's password and fire the PasswordReset event.
     *
     * @param array $credentials ['email' => string, 'password' => string, 'password_confirmation' => string, 'token' => string]
     * @return string Status constant from Password broker
     */
    public function resetPassword(array $credentials): string
    {
        return Password::broker('customers')->reset(
            $credentials,
            function (Customer $customer, string $password) {
                $customer->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($customer));
            }
        );
    }

    /**
     * Logout customer from session and invalidate session tokens.
     */
    public function logout(): void
    {
        Auth::guard('customer')->logout();
    }
}
