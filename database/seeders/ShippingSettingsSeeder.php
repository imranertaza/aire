<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use App\Models\ShippingSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flatMethod = ShippingMethod::where('code', 'flat')->first();
        $zoneMethod = ShippingMethod::where('code', 'zone')->first();
        $zoneRateMethod = ShippingMethod::where('code', 'zone_rate')->first();

        $settings = [
            // Flat Rate Setting
            ['shipping_method_id' => $flatMethod?->id, 'label' => 'flat_rate_price', 'title' => 'Flat Rate', 'value' => '5'],

            // Zone Based Shipping
            ['shipping_method_id' => $zoneMethod?->id, 'label' => 'in_dhaka', 'title' => 'Inside of Dhaka', 'value' => '20'],
            ['shipping_method_id' => $zoneMethod?->id, 'label' => 'out_dhaka', 'title' => 'Outside of Dhaka', 'value' => '50'],

            // Zone Rate Shipping
            ['shipping_method_id' => $zoneRateMethod?->id, 'label' => 'zone_rate_method', 'title' => 'Zone Rate Method', 'value' => '1'],
        ];

        foreach ($settings as $setting) {
            if ($setting['shipping_method_id']) {
                ShippingSetting::updateOrCreate(
                    ['shipping_method_id' => $setting['shipping_method_id'], 'label' => $setting['label']],
                    $setting
                );
            }
        }
    }
}
