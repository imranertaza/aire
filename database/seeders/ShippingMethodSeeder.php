<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            ['name' => 'Standard Shipping', 'code' => 'std_01', 'status' => 1],
            ['name' => 'Express Delivery', 'code' => 'exp_01', 'status' => 1],
            ['name' => 'Local Pickup', 'code' => 'pickup_01', 'status' => 1],
        ];
        $methods = [
            ['name' => 'Flat Rate Shipping',    'code' => 'flat',      'status' => 1],
            ['name' => 'Zone Based Shipping',   'code' => 'zone',      'status' => 0],
            ['name' => 'Weight Based Shipping', 'code' => 'weight',    'status' => 0],
            ['name' => 'Zone Rate Shipping',    'code' => 'zone_rate', 'status' => 1],
        ];

        foreach ($methods as $method) {
            ShippingMethod::updateOrCreate(
                ['code' => $method['code']],
                ['name' => $method['name'], 'status' => $method['status']]
            );
        }
    }
}
