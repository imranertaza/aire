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

        $weightMethod = ShippingMethod::where('code', 'weight')->first();
        $zoneMethod = ShippingMethod::where('code', 'zone')->first();

        $settings = [
            // Example for Weight
            ['shipping_method_id' => $weightMethod?->id, 'label' => 'tier_1', 'title' => 'Light Weight', 'value' => '0-5kg'],

            // Example for Zone
            ['shipping_method_id' => $zoneMethod?->id, 'label' => 'zone_a', 'title' => 'Dhaka City', 'value' => '60.00'],
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
