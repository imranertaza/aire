<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Module;
use App\Models\ModuleSetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOption;
use App\Models\OrderHistory;
use App\Models\OrderCardDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\CustomerLedger;
use App\Models\CustomerPointHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Schema::disableForeignKeyConstraints();
        ModuleSetting::truncate();
        Module::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Seed Points Module
        $module = Module::create([
            'name'       => 'Points',
            'module_key' => 'point',
            'status'     => 1,
        ]);

        ModuleSetting::create([
            'module_id'   => $module->id,
            'setting_key' => 'point_par_doller',
            'title'       => 'Point Par Doller ($1)',
            'value'       => '1',
        ]);

        // 2. Seed Order Statuses
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

        // Fetch some existing customers and products
        $customers = Customer::all();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            return;
        }

        // 3. Seed Sample Orders
        for ($i = 0; $i < 5; $i++) {
            $customer = $customers->random();
            $statusId = array_rand($statuses);
            
            // Random total prices
            $total = $faker->randomFloat(4, 50, 1500);
            $vat = $faker->numberBetween(0, 15);
            $discount = $faker->randomFloat(4, 0, 50);
            $finalAmount = $total + ($total * $vat / 100) - $discount;
            $totalPoint = $faker->boolean(70) ? round($total * 1) : 0;

            $order = Order::create([
                'invoice_no'               => $faker->numberBetween(1000, 9999),
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
                'payment_method'           => $faker->randomElement(['Bkash', 'Rocket', 'Cash On Delivery', 'Card Payment']),
                'payment_transection_code' => $faker->boolean(50) ? 'TXN-' . Str::upper(Str::random(10)) : null,
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
                'comment'                  => $faker->sentence(),
                'total'                    => $total,
                'total_point'              => $totalPoint > 0 ? $totalPoint : null,
                'vat'                      => $vat,
                'discount'                 => $discount,
                'final_amount'             => $finalAmount,
                'status'                   => $statusId,
                'payment_status'           => $faker->randomElement(['Pending', 'Paid', 'Failed']),
                'PM_transaction_id'        => $faker->boolean(50) ? 'PM-' . Str::upper(Str::random(10)) : null,
                'ip'                       => $faker->ipv4(),
            ]);

            // Add Ledger and Point History records linked to this real order ID
            $customer->balance -= $finalAmount;
            $customer->save();

            CustomerLedger::create([
                'customer_id'      => $customer->id,
                'order_id'         => $order->id,
                'particulars'      => 'Ordered Item #' . $order->id . ' Debit',
                'transaction_type' => 'Dr.',
                'amount'           => $finalAmount,
                'rest_balance'     => $customer->balance,
            ]);

            if ($totalPoint > 0) {
                $customer->point += $totalPoint;
                $customer->save();

                CustomerPointHistory::create([
                    'customer_id'      => $customer->id,
                    'order_id'         => $order->id,
                    'particulars'      => 'Points earned on order #' . $order->id,
                    'transaction_type' => 'Cr.',
                    'point'            => $totalPoint,
                    'rest_point'       => $customer->point,
                ]);
            }

            // Add Order Items
            $numberOfItems = $faker->numberBetween(1, 3);
            for ($j = 0; $j < $numberOfItems; $j++) {
                $product = $products->random();
                $qty = $faker->numberBetween(1, 5);
                $price = $product->price ?? 100.00;
                $itemTotal = $price * $qty;

                $orderItem = OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $product->id,
                    'price'       => $price,
                    'quantity'    => $qty,
                    'total_price' => $itemTotal,
                    'discount'    => null,
                    'final_price' => $itemTotal,
                ]);

                // Seed Order Option (Size, Color variations)
                OrderOption::create([
                    'order_id'        => $order->id,
                    'order_item_id'   => $orderItem->id,
                    'product_id'      => $product->id,
                    'option_id'       => 1,
                    'option_value_id' => $faker->numberBetween(1, 10),
                    'name'            => 'size',
                    'value'           => $faker->randomElement(['M', 'L', 'XL', 'XXL']),
                ]);

                OrderOption::create([
                    'order_id'        => $order->id,
                    'order_item_id'   => $orderItem->id,
                    'product_id'      => $product->id,
                    'option_id'       => 2,
                    'option_value_id' => $faker->numberBetween(1, 10),
                    'name'            => 'color',
                    'value'           => $faker->safeColorName(),
                ]);
            }

            // Seed History
            OrderHistory::create([
                'order_id'        => $order->id,
                'order_status_id' => 1, // Pending
                'notify'          => 0,
                'comment'         => 'Order received successfully.',
            ]);

            if ($statusId !== 1) {
                OrderHistory::create([
                    'order_id'        => $order->id,
                    'order_status_id' => $statusId,
                    'notify'          => 0,
                    'comment'         => 'Order status updated to ' . $statuses[$statusId],
                ]);
            }

            // Card details if paying via card
            if ($order->payment_method === 'Card Payment') {
                OrderCardDetail::create([
                    'order_id'          => $order->id,
                    'payment_method_id' => 2,
                    'card_name'         => $customer->firstname . ' ' . $customer->lastname,
                    'card_number'       => 4242424242424242,
                    'card_expiration'   => '12/28',
                    'card_cvc'          => 123,
                ]);
            }
        }
    }
}
