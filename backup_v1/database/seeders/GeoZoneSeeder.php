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
            ['id' => 1, 'geo_zone_name' => 'bd zone', 'geo_zone_description' => 'bd zone', 'sort_order' => 0, 'status' => '1'],
            ['id' => 2, 'geo_zone_name' => 'test', 'geo_zone_description' => 'test', 'sort_order' => 0, 'status' => '1'],
            ['id' => 3, 'geo_zone_name' => 'test 2', 'geo_zone_description' => 'test 2', 'sort_order' => 0, 'status' => '1'],
            ['id' => 4, 'geo_zone_name' => 'Singapore', 'geo_zone_description' => 'Singapore', 'sort_order' => 0, 'status' => '1'],
        ];

        foreach ($zones as $zone) {
            GeoZone::updateOrCreate(
                ['id' => $zone['id']],
                $zone
            );
        }
    }
}
