<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'name'                  => 'New Year Sale',
            'code'                  => 'NEWYEAR2026',
            'discount_type'         => 1,           // 1 = Percentage
            'discount_on'           => 1,           // 1 = Product
            'discount'              => 15.00,       // 15%
            'for_subscribed_user'   => 0,
            'for_registered_user'   => 1,
            'total_useable'         => 100,
            'total_used'            => 0,
            'date_start'            => '2026-01-01',
            'date_end'              => '2026-01-31',
            'status'                => 1,
            'createdBy'             => 1,
            'updatedBy'             => 1,
        ]);

        Coupon::create([
            'name'                  => 'Free Shipping Offer',
            'code'                  => 'FREESHIP',
            'discount_type'         => 2,           // 2 = Flat
            'discount_on'           => 2,           // 2 = Shipping
            'discount'              => 5.00,        // $5 flat off on shipping
            'for_subscribed_user'   => 1,
            'for_registered_user'   => 1,
            'total_useable'         => null,        // Unlimited
            'total_used'            => 12,
            'date_start'            => now()->format('Y-m-d'),
            'date_end'              => now()->addMonths(3)->format('Y-m-d'),
            'status'                => 1,
            'createdBy'             => 1,
            'updatedBy'             => 1,
        ]);

        Coupon::create([
            'name'                  => 'Summer Discount',
            'code'                  => 'SUMMER25',
            'discount_type'         => 1,           // Percentage
            'discount_on'           => 1,           // Product
            'discount'              => 25.00,
            'for_subscribed_user'   => 1,
            'for_registered_user'   => 0,
            'total_useable'         => 50,
            'total_used'            => 0,
            'date_start'            => '2026-06-01',
            'date_end'              => '2026-06-30',
            'status'                => 1,
            'createdBy'             => 1,
            'updatedBy'             => 1,
        ]);

        $this->command->info('CouponSeeder completed successfully!');
    }
}
