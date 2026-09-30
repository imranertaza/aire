<?php

namespace Database\Seeders;

use App\Models\GeoZone;
use App\Models\GeoZoneShippingRate;
use Illuminate\Database\Seeder;

class GeoZoneShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch your GeoZones to link the rates
        $zones = GeoZone::all();

        if ($zones->isEmpty()) {
            $this->command->warn('No GeoZones found. Please seed the GeoZone table first.');
            return;
        }

        // Example rates to seed
        $rates = [
            ['up_to_value' => 1.0, 'cost' => 50],
            ['up_to_value' => 5.0, 'cost' => 150],
            ['up_to_value' => 10.0, 'cost' => 300],
        ];

        foreach ($zones as $zone) {
            foreach ($rates as $rate) {
                GeoZoneShippingRate::updateOrCreate(
                    [
                        'geo_zone_id' => $zone->id,
                        'up_to_value' => $rate['up_to_value']
                    ],
                    [
                        'cost' => $rate['cost']
                        // 'createdBy' => 1, // Optional: add if you have an auth user
                    ]
                );
            }
        }

        $this->command->info('Geo Zone Shipping Rates seeded successfully!');
    }
}
