<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerLedger;
use App\Models\CustomerPointHistory;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderOption;
use App\Models\OrderItem;
use App\Models\OrderHistory;
use App\Models\OrderCardDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Clean tables first to avoid overflow
        Schema::disableForeignKeyConstraints();
        CustomerLedger::truncate();
        CustomerPointHistory::truncate();
        OrderOption::truncate();
        OrderItem::truncate();
        OrderHistory::truncate();
        OrderCardDetail::truncate();
        Order::truncate();
        OrderStatus::truncate();
        Customer::truncate();
        Schema::enableForeignKeyConstraints();

        // Seed order statuses first so we can reference them
        $statuses = [
            1 => 'Pending',
            2 => 'Processing',
            3 => 'Shipped',
            5 => 'Complete',
            7 => 'Canceled',
            8 => 'Denied',
            9 => 'Canceled Reversal',
            10 => 'Failed',
            11 => 'Refunded',
            12 => 'Reversed',
            13 => 'Chargeback',
            14 => 'Expired',
            15 => 'Processed',
            16 => 'Voided'
        ];

        foreach ($statuses as $id => $name) {
            OrderStatus::firstOrCreate(
                ['id' => $id],
                ['name' => $name]
            );
        }

        // Let's create 10 customers
        for ($i = 0; $i < 10; $i++) {
            $customer = Customer::create([
                'firstname'  => $faker->firstName(),
                'lastname'   => $faker->lastName(),
                'email'      => $faker->unique()->safeEmail(),
                'phone'      => substr($faker->e164PhoneNumber(), 0, 32),
                'password'   => Hash::make('password123'),
                'balance'    => 0.00,
                'point'      => 0,
                'salt'       => Str::random(9),
                'wishlist'   => json_encode([$faker->numberBetween(1, 100)]),
                'newsletter' => $faker->boolean(30),
                'address_id' => $faker->numberBetween(1, 200),
                'ip'         => $faker->ipv4(),
                'status'     => 1,
            ]);

            // Create a real order for this customer first so we have a real order ID
            $order = Order::create([
                'invoice_no'               => 10023 + $i,
                'store_id'                 => 1,
                'customer_id'              => $customer->id,
                'firstname'                => $customer->firstname,
                'lastname'                 => $customer->lastname,
                'email'                    => $customer->email,
                'telephone'                => $customer->phone,
                'payment_firstname'        => $customer->firstname,
                'payment_lastname'         => $customer->lastname,
                'payment_address_1'        => $faker->streetAddress(),
                'payment_address_2'        => $faker->secondaryAddress(),
                'payment_city'             => $faker->city(),
                'payment_postcode'         => $faker->postcode(),
                'payment_country'          => 'Bangladesh',
                'payment_country_id'       => 18,
                'payment_phone'            => $customer->phone,
                'payment_email'            => $customer->email,
                'payment_method'           => 'Bkash',
                'payment_transection_code' => 'TXN-' . Str::upper(Str::random(10)),
                'shipping_firstname'       => $customer->firstname,
                'shipping_lastname'        => $customer->lastname,
                'shipping_address_1'       => $faker->streetAddress(),
                'shipping_address_2'       => $faker->secondaryAddress(),
                'shipping_city'            => $faker->city(),
                'shipping_postcode'        => $faker->postcode(),
                'shipping_country'         => 'Bangladesh',
                'shipping_country_id'      => 18,
                'shipping_phone'           => $customer->phone,
                'shipping_method'          => 'Flat Rate Shipping',
                'shipping_charge'          => 5.00,
                'comment'                  => 'Initial test order',
                'total'                    => 245.00,
                'total_point'              => 120,
                'vat'                      => 0,
                'discount'                 => 0,
                'final_amount'             => 250.00,
                'status'                   => 5, // Complete
                'payment_status'           => 'Paid',
                'PM_transaction_id'        => 'PM-' . Str::upper(Str::random(10)),
                'ip'                       => $faker->ipv4(),
            ]);

            // Seed Ledger for this customer
            $balance = 0.00;
            $ledgerEntries = [
                ['particulars' => 'Sign up bonus credit', 'type' => 'Cr.', 'amount' => 100.00, 'order_id' => 0],
                ['particulars' => 'Added funds via Payment Gateway', 'type' => 'Cr.', 'amount' => 500.00, 'order_id' => 0],
                ['particulars' => 'Ordered Item #' . $order->id . ' Debit', 'type' => 'Dr.', 'amount' => 250.00, 'order_id' => $order->id],
                ['particulars' => 'Refunded amount for Order #' . $order->id, 'type' => 'Cr.', 'amount' => 50.00, 'order_id' => $order->id],
            ];

            foreach ($ledgerEntries as $entry) {
                if ($entry['type'] === 'Cr.') {
                    $balance += $entry['amount'];
                } else {
                    $balance -= $entry['amount'];
                }

                CustomerLedger::create([
                    'customer_id'      => $customer->id,
                    'order_id'         => $entry['order_id'],
                    'particulars'      => $entry['particulars'],
                    'transaction_type' => $entry['type'],
                    'amount'           => $entry['amount'],
                    'rest_balance'     => $balance,
                ]);
            }

            // Seed Point History for this customer
            $points = 0;
            $pointEntries = [
                ['particulars' => 'Welcome points earned', 'type' => 'Cr.', 'points' => 50, 'order_id' => 0],
                ['particulars' => 'Points earned on order #' . $order->id, 'type' => 'Cr.', 'points' => 120, 'order_id' => $order->id],
                ['particulars' => 'Redeemed points on checkout', 'type' => 'Dr.', 'points' => 40, 'order_id' => $order->id],
            ];

            foreach ($pointEntries as $entry) {
                if ($entry['type'] === 'Cr.') {
                    $points += $entry['points'];
                } else {
                    $points -= $entry['points'];
                }

                CustomerPointHistory::create([
                    'customer_id'      => $customer->id,
                    'order_id'         => $entry['order_id'],
                    'particulars'      => $entry['particulars'],
                    'transaction_type' => $entry['type'],
                    'point'            => $entry['points'],
                    'rest_point'       => $points,
                ]);
            }

            // Update customer with final balance and points
            $customer->update([
                'balance' => $balance,
                'point'   => $points,
            ]);
        }
    }
}
