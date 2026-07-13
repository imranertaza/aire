<?php

namespace Database\Seeders;

use App\Models\GeoZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeoZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            ['geo_zone_name' => 'Dhaka Division', 'geo_zone_description' => 'Inside Dhaka', 'sort_order' => 1],
            ['geo_zone_name' => 'Chittagong Division', 'geo_zone_description' => 'Port Area', 'sort_order' => 2],
            ['geo_zone_name' => 'Khulna Division', 'geo_zone_description' => 'South Region', 'sort_order' => 3],
        ];

        foreach ($zones as $zone) {
            GeoZone::updateOrCreate(
                ['geo_zone_name' => $zone['geo_zone_name']],
                $zone
            );
        }
    }
}
