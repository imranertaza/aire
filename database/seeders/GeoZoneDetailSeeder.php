<?php

namespace Database\Seeders;

use App\Models\GeoZone;
use App\Models\GeoZoneDetail;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class GeoZoneDetailSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Map United States (country_id = 223) -> GeoZone 1 or USA Zone
        $usaZone = GeoZone::where('geo_zone_name', 'like', '%bd%')->orWhere('id', 1)->first();
        $geoZoneId = $usaZone ? $usaZone->id : 1;

        GeoZoneDetail::updateOrCreate([
            'geo_zone_id' => $geoZoneId,
            'country_id'  => 223,
            'zone_id'     => 0, // All zones in USA
        ]);

        // 2. Map Bangladesh (country_id = 18) -> GeoZone 2 or Bangladesh Zone
        $bdZone = GeoZone::where('id', 2)->first() ?? $usaZone;
        $bdGeoZoneId = $bdZone ? $bdZone->id : $geoZoneId;

        GeoZoneDetail::updateOrCreate([
            'geo_zone_id' => $bdGeoZoneId,
            'country_id'  => 18,
            'zone_id'     => 0, // All zones in BD
        ]);

        // 3. Map specific zones if available
        $zones = Zone::all();
        foreach ($zones as $zone) {
            GeoZoneDetail::updateOrCreate([
                'geo_zone_id' => $geoZoneId,
                'country_id'  => $zone->country_id,
                'zone_id'     => $zone->id,
            ]);
        }
    }
}
