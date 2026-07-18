<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payment_methods')->truncate();

        $methods = [
            [
                'id' => 1,
                'name' => 'Cash On Delivery',
                'code' => 'cash_on',
                'image' => 'cash_1759055968_1465e094942ee20fb670.png',
                'status' => 0,
                'settings' => []
            ],
            [
                'id' => 2,
                'name' => 'Bank Transfer',
                'code' => 'bank_transfer',
                'image' => 'bank_1692269261_e30f1169975c89545ff2.png',
                'status' => 1,
                'settings' => [
                    'instruction' => 'A set of payment instructions will be sent to you shortly. Please check your spam or junk if you do not see it in your inbox. If no instruction is receive within 24 hours, please email us at amazingadgets@gmail.com'
                ]
            ],
            [
                'id' => 3,
                'name' => 'Paypal',
                'code' => 'paypal',
                'image' => 'paypal_1692681576_8816a976c4c15e75aeb4.png',
                'status' => 1,
                'settings' => [
                    'api_url' => 'sandbox',
                    'api_username' => 'sb-u1koz27136347_api1.business.example.com',
                    'api_password' => 'Q6GHERFNRMSURNYD',
                    'api_signature' => 'AwIggmgx-fAD0IWRrXWdFxsw.d--AlUB67UCRrfEheVSFrGOH9DRld-V'
                ]
            ],
            [
                'id' => 4,
                'name' => 'Western Union',
                'code' => 'western_union',
                'image' => 'western_union_1693227784_6fff290ee998d1951995.png',
                'status' => 1,
                'settings' => [
                    'instruction' => 'A set of payment instructions will be sent to you shortly. Please check your spam or junk if you do not see it in your inbox. If no instruction is receive within 24 hours, please email us at amazinggadgets@gmail.com'
                ]
            ],
            [
                'id' => 5,
                'name' => 'MoneyGram',
                'code' => 'moneyGram',
                'image' => 'moneyGram_1693228242_b037b4cb9fcab1d64b21.png',
                'status' => 1,
                'settings' => [
                    'instruction' => 'A set of payment instructions will be sent to you shortly. Please check your spam or junk if you do not see it in your inbox. If no instruction is receive within 24 hours, please email us at amazinggadgets@gmail.com'
                ]
            ],
            [
                'id' => 6,
                'name' => 'Bitcoin',
                'code' => 'bitcoin',
                'image' => 'bitcoin_1693229111_ab1db8a222a0b4082eb1.png',
                'status' => 0,
                'settings' => [
                    'instruction' => 'A set of payment instructions will be sent to you shortly. Please check your spam or junk if you do not see it in your inbox. If no instruction is receive within 24 hours, please email us at amazinggadgets@gmail.com'
                ]
            ],
            [
                'id' => 7,
                'name' => 'Credit Card / Debit Card',
                'code' => 'credit_card',
                'image' => 'cash_1759055918_f57b29fe04b4f69c505b.png',
                'status' => 1,
                'settings' => []
            ],
            [
                'id' => 8,
                'name' => 'eWallet',
                'code' => 'u_wallet',
                'image' => 'cash_1759055992_1743dfad6cce7df3aa71.png',
                'status' => 0,
                'settings' => []
            ],
            [
                'id' => 9,
                'name' => 'Stripe',
                'code' => 'stripe',
                'image' => 'stripe_1711190105_76334e85265e1bfe92f5.png',
                'status' => 1,
                'settings' => [
                    'key' => '',
                    'secret_key' => ''
                ]
            ],
            [
                'id' => 10,
                'name' => 'Ois Bizcraft',
                'code' => 'oisbizcraft',
                'image' => 'oisbizcraft_1733202301_f7de86d0599a71d8ccf9.jpg',
                'status' => 1,
                'settings' => [
                    'api_key' => '',
                    'ois_bizcraft_api_url' => 'https://devapiportal.oisbizcraft.com/api/payments',
                    'merchant_outlet_id' => '13',
                    'terminal_id' => '001',
                    'cust_code' => '001095',
                    'exchange_rates_api' => '51f16f3fee1c4eec91235cbd887a5259'
                ]
            ]
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
