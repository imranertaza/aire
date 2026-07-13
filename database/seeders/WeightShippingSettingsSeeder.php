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
            ['label' => 1, 'title' => '0kg - 1kg', 'value' => 50.00],
            ['label' => 2, 'title' => '1kg - 5kg', 'value' => 150.00],
            ['label' => 3, 'title' => '5kg+', 'value' => 300.00],
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
