<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('payment_methods')->truncate();
        Schema::enableForeignKeyConstraints();

        $methods = [
            [
                'id' => 1,
                'name' => 'Cash On Delivery',
                'code' => 'cash_on',
                'image' => 'payment/8PKBi3GEOyI5R92tKZYxm35U0iObzU0GLeGkmh8Z.png',
                'status' => 1,
                'settings' => []
            ],
            [
                'id' => 2,
                'name' => 'Bank Transfer',
                'code' => 'bank_transfer',
                'image' => 'payment/eigiwCWfA9GYqzg4a4ebarZJPUA057R0dWe1HyPk.png',
                'status' => 0,
                'settings' => [
                    'instruction' => 'A set of payment instructions will be sent to you shortly. Please check your spam or junk if you do not see it in your inbox. If no instruction is receive within 24 hours, please email us at amazingadgets@gmail.com'
                ]
            ],
            [
                'id' => 3,
                'name' => 'Paypal',
                'code' => 'paypal',
                'image' => 'payment/z0Az2U1Kg1ANhrmLeN3JMtMpxvXXjh95loNCLukh.png',
                'status' => 0,
                'settings' => [
                    'api_url' => 'sandbox',
                    'api_password' => 'Q6GHERFNRMSURNYD',
                    'api_username' => 'sb-u1koz27136347_api1.business.example.com',
                    'api_signature' => 'AwIggmgx-fAD0IWRrXWdFxsw.d--AlUB67UCRrfEheVSFrGOH9DRld-V'
                ]
            ],
            [
                'id' => 4,
                'name' => 'Western Union',
                'code' => 'western_union',
                'image' => 'payment/RL1alRaSnadrK5bW0Vc9JwdZAGbHwZolm2bFsh3Z.png',
                'status' => 0,
                'settings' => [
                    'instruction' => 'A set of payment instructions will be sent to you shortly. Please check your spam or junk if you do not see it in your inbox. If no instruction is receive within 24 hours, please email us at amazinggadgets@gmail.com'
                ]
            ],
            [
                'id' => 5,
                'name' => 'MoneyGram',
                'code' => 'moneyGram',
                'image' => 'payment/fmHggrVJrj7ePcEt0qHtToesnMKdlwdh4n9za4ym.png',
                'status' => 0,
                'settings' => [
                    'instruction' => 'A set of payment instructions will be sent to you shortly. Please check your spam or junk if you do not see it in your inbox. If no instruction is receive within 24 hours, please email us at amazinggadgets@gmail.com'
                ]
            ],
            [
                'id' => 6,
                'name' => 'Bitcoin',
                'code' => 'bitcoin',
                'image' => 'payment/VKVqyOmowDrvsT87axrcDfg4euWvu5G7qTK6klC6.png',
                'status' => 0,
                'settings' => [
                    'instruction' => 'A set of payment instructions will be sent to you shortly. Please check your spam or junk if you do not see it in your inbox. If no instruction is receive within 24 hours, please email us at amazinggadgets@gmail.com'
                ]
            ],
            [
                'id' => 7,
                'name' => 'Credit Card / Debit Card',
                'code' => 'credit_card',
                'image' => 'payment/HaBwgUUBnLCG7D20EBv4FMTJrxk0TaOgGIxyl9h3.png',
                'status' => 0,
                'settings' => []
            ],
            [
                'id' => 8,
                'name' => 'eWallet',
                'code' => 'u_wallet',
                'image' => 'payment/rDCqHIv6alkZ8J2qtBFkVZ4Rv1r5xs7A3BaWtTYU.png',
                'status' => 0,
                'settings' => []
            ],
            [
                'id' => 9,
                'name' => 'Stripe',
                'code' => 'stripe',
                'image' => 'payment/a6ZpCqeprR8YbFmNgWcQjxwJcVoMXB8ylLJrYjRe.png',
                'status' => 0,
                'settings' => [
                    'key' => 'pk_test_51HiuQiDVsvPo6h6ZrkChvkyVywgbs83tPg809JsvQLqyJ3JAlXbXhTOlwZEmlzXud1paIE87z7o5erGMEUbDrevD00jOYwmg2Y',
                    'secret_key' => 'sk_test_51HiuQiDVsvPo6h6ZmBoulU8B7qWOCl6qYC3feinEzPuj0lLICpwhE2vEHncoIA6fZaKSjXMDn09L8ueDBMzt3I6Z00SA7fC6xY'
                ]
            ],
            [
                'id' => 10,
                'name' => 'Ois Bizcraft',
                'code' => 'oisbizcraft',
                'image' => 'payment/pMsmdRdyQckepRtIfHpGUsBKGTMHHKSnFIqeOEmp.jpg',
                'status' => 0,
                'settings' => [
                    'api_key' => 'DNNDT2QAB583ZP188BHNFMCXRB4G7SJ3',
                    'cust_code' => '001095',
                    'terminal_id' => '001',
                    'exchange_rates_api' => '51f16f3fee1c4eec91235cbd887a5259',
                    'merchant_outlet_id' => '13',
                    'ois_bizcraft_api_url' => 'https://devapiportal.oisbizcraft.com/api/payments'
                ]
            ]
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
