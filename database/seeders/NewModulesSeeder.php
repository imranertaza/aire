<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ColorFamily;
use App\Models\Newsletter;
use App\Models\FundRequest;
use Illuminate\Support\Facades\DB;

class NewModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Color Families
        $colors = [
            ['color_name' => 'Red', 'code' => '#FF0000'],
            ['color_name' => 'Blue', 'code' => '#0000FF'],
            ['color_name' => 'Green', 'code' => '#00FF00'],
            ['color_name' => 'Black', 'code' => '#000000'],
            ['color_name' => 'White', 'code' => '#FFFFFF'],
            ['color_name' => 'Yellow', 'code' => '#FFFF00'],
            ['color_name' => 'Purple', 'code' => '#800080'],
            ['color_name' => 'Orange', 'code' => '#FFA500'],
        ];

        foreach ($colors as $color) {
            ColorFamily::firstOrCreate(['color_name' => $color['color_name']], $color);
        }

        // 2. Seed Newsletters (using a few generic customer ids or random dummy data)
        // Check if there are customers to associate
        $customer = DB::table('customers')->first();
        $customerId = $customer ? $customer->id : null;

        $newsletters = [
            ['customer_id' => $customerId, 'email' => 'subscriber1@example.com', 'status' => 1],
            ['customer_id' => null, 'email' => 'subscriber2@example.com', 'status' => 1],
            ['customer_id' => null, 'email' => 'subscriber3@example.com', 'status' => 0],
            ['customer_id' => null, 'email' => 'test_user@example.com', 'status' => 1],
        ];

        foreach ($newsletters as $newsletter) {
            Newsletter::firstOrCreate(['email' => $newsletter['email']], $newsletter);
        }

        // 3. Seed Fund Requests
        // Requires a customer and a payment method to work correctly with foreign keys
        $paymentMethod = DB::table('payment_methods')->first();

        if ($customer && $paymentMethod) {
            $fundRequests = [
                [
                    'customer_id' => $customer->id,
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => 50.00,
                    'card_name' => 'John Doe',
                    'card_number' => '411111111111111',
                    'card_expiration' => '12/25',
                    'card_cvc' => '123',
                    'status' => 'Pending',
                ],
                [
                    'customer_id' => $customer->id,
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => 100.00,
                    'card_name' => 'Jane Smith',
                    'card_number' => '555555555555555',
                    'card_expiration' => '10/24',
                    'card_cvc' => '456',
                    'status' => 'Complete',
                ],
                [
                    'customer_id' => $customer->id,
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => 20.00,
                    'card_name' => 'Bob Builder',
                    'card_number' => '422222222222222',
                    'card_expiration' => '05/26',
                    'card_cvc' => '789',
                    'status' => 'Canceled',
                ],
            ];

            foreach ($fundRequests as $request) {
                // Ensure we don't duplicate identical fund requests
                FundRequest::firstOrCreate(
                    [
                        'customer_id' => $request['customer_id'],
                        'amount' => $request['amount'],
                        'status' => $request['status']
                    ],
                    $request
                );
            }
        }
    }
}
