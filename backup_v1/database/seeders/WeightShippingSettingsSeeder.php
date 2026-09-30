<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use App\Models\WeightShippingSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeightShippingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingMethod = ShippingMethod::where('code', 'weight')->first();

        if (!$shippingMethod) {
            $this->command->warn('Weight based shipping method not found. Skipping.');
            return;
        }

        $settings = [
            ['label' => 5, 'title' => '', 'value' => 50],
        ];

        foreach ($settings as $setting) {
            WeightShippingSetting::updateOrCreate(
                [
                    'shipping_method_id' => $shippingMethod->id,
                    'label' => $setting['label']
                ],
                [
                    'title' => $setting['title'],
                    'value' => $setting['value'],
                ]
            );
        }

        $this->command->info('Weight shipping settings seeded successfully!');
    }
}
