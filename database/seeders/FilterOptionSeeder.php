<?php

namespace Database\Seeders;

use App\Models\FilterOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FilterOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FilterOption::truncate();
        DB::table('filter_option_values')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $options = [
            [
                'name' => 'Building Type',
                'type' => 'radio',
                'values' => [
                    'Apartment',
                    'House',
                    'Office',
                    'Clinic',
                    'School',
                    'Warehouse',
                ]
            ],
            [
                'name' => 'Room / Area Type',
                'type' => 'radio',
                'values' => [
                    'Living Room',
                    'Bedroom',
                    'Kitchen',
                    'Office Space',
                    'Patient Room',
                    'Waiting Area',
                ]
            ],
            [
                'name' => 'Area Range (m²)',
                'type' => 'radio',
                'values' => [
                    '0-20 m²',
                    '21-50 m²',
                    '51-100 m²',
                    '100+ m²',
                ]
            ],
            [
                'name' => 'Occupancy',
                'type' => 'radio',
                'values' => [
                    '1-2 Persons',
                    '3-5 Persons',
                    '5-10 Persons',
                    '10+ Persons',
                ]
            ],
            [
                'name' => 'Health Concern',
                'type' => 'checkbox',
                'values' => [
                    'Asthma',
                    'Allergies',
                    'Viruses / Bacteria',
                    'Mold',
                    'Chemicals (VOCs)',
                ]
            ],
            [
                'name' => 'Problem',
                'type' => 'checkbox',
                'values' => [
                    'Dust',
                    'Odors',
                    'Smoke',
                    'Pet Dander',
                    'High Humidity',
                ]
            ],
            [
                'name' => 'Solution Needed',
                'type' => 'checkbox',
                'values' => [
                    'Air Purification',
                    'Dehumidification',
                    'Humidification',
                    'Ventilation',
                    'Ozone Generation',
                ]
            ],
            [
                'name' => 'Budget Range',
                'type' => 'radio',
                'values' => [
                    'Under $500',
                    '$500 - $1,000',
                    '$1,000 - $2,500',
                    'Over $2,500',
                ]
            ],
        ];

        $masterIconMap = [
            'residential' => 'bi-house',
            'commercial' => 'bi-building',
            'healthcare' => 'bi-hospital',
            'education' => 'bi-mortarboard',
            'transportation' => 'bi-train-front',
            'industrial' => 'bi-cone-striped',
            'infrastructure' => 'bi-diagram-3',
            'hvac' => 'bi-fan',
            'monitoring' => 'bi-display',
            'apartment' => 'bi-building-fill',
            'house' => 'bi-house-door',
            'villa' => 'bi-house-heart',
            'office' => 'bi-laptop',
            'shopping_mall' => 'bi-shop',
            'hospital' => 'bi-hospital',
            'school' => 'bi-book',
            'car' => 'bi-car-front',
            'factory' => 'bi-gear-wide-connected',
            'warehouse' => 'bi-boxes',
            'airport' => 'bi-airplane',
            'public_building' => 'bi-bank',
            'bedroom' => 'bi-moon-stars',
            'whole_apartment' => 'bi-grid-1x2',
            'whole_house' => 'bi-houses',
            'meeting_room' => 'bi-people',
            'office_floor' => 'bi-grid-3x3',
            'public_area' => 'bi-geo-alt',
            'ward' => 'bi-heart-pulse',
            'classroom' => 'bi-easel',
            'vehicle' => 'bi-car-front-fill',
            'production_area' => 'bi-tools',
            'terminal' => 'bi-signpost-split',
            'lobby' => 'bi-door-open',
            'allergies' => 'bi-flower1',
            'asthma' => 'bi-lungs',
            'family_health' => 'bi-heart-pulse',
            'luxury_wellness' => 'bi-gem',
            'productivity' => 'bi-graph-up-arrow',
            'employee_wellness' => 'bi-briefcase',
            'public_health' => 'bi-shield-check',
            'virus_protection' => 'bi-virus',
            'respiratory_safety' => 'bi-shield-plus',
            'childrens_health' => 'bi-emoji-smile',
            'driver_health' => 'bi-car-front',
            'worker_safety' => 'bi-shield-shaded',
            'compliance' => 'bi-clipboard-check',
            'megafacility' => 'bi-building-gear',
            'general_iaq' => 'bi-wind',
            'iaq_awareness' => 'bi-eye',
            'pm25' => 'bi-cloud-fog',
            'high_co2' => 'bi-cloud-haze',
            'iaq' => 'bi-speedometer2',
            'mold' => 'bi-water',
            'mold_poor_ventilation' => 'bi-water',
            'pm25_co2' => 'bi-clouds',
            'poor_air' => 'bi-exclamation-triangle',
            'poor_air_quality' => 'bi-exclamation-triangle',
            'smoke_odor' => 'bi-fire',
            'virus_bacteria' => 'bi-virus2',
            'airborne' => 'bi-snow',
            'airborne_particles' => 'bi-snow',
            'dust_vocs' => 'bi-droplet-half',
            'large_building_vent' => 'bi-building-slash',
            'large_space_iaq' => 'bi-fullscreen-exit',
            'hvac_treatment' => 'bi-fan',
            'pm25_monitoring' => 'bi-bar-chart-line',
            'air_purification' => 'bi-box-seam',
            'fresh_air' => 'bi-arrow-left-right',
            'fresh_air_heat_recovery' => 'bi-arrow-left-right',
            'ventilation_monitoring' => 'bi-activity',
            'whole_house_ventilation' => 'bi-house-gear',
            'air_quality_mgmt' => 'bi-sliders',
            'air_quality_management' => 'bi-sliders',
            'personal_protection' => 'bi-person-check',
            'vehicle_air' => 'bi-truck',
            'vehicle_air_quality' => 'bi-truck',
            'co2_monitoring' => 'bi-thermometer-half',
            'central_ventilation' => 'bi-node-plus',
            'purification_hvac' => 'bi-arrow-repeat',
            'entry' => 'bi-cash',
            'medium' => 'bi-cash-stack',
            'premium' => 'bi-gem',
            'enterprise' => 'bi-bank',
        ];

        foreach ($options as $index => $optionData) {
            $optNameLower = strtolower($optionData['name']);
            $defaultIcon = 'bi-list';
            if (str_contains($optNameLower, 'building')) $defaultIcon = 'bi-building';
            elseif (str_contains($optNameLower, 'room') || str_contains($optNameLower, 'area type')) $defaultIcon = 'bi-door-closed';
            elseif (str_contains($optNameLower, 'area range')) $defaultIcon = 'bi-aspect-ratio';
            elseif (str_contains($optNameLower, 'occupancy')) $defaultIcon = 'bi-people';
            elseif (str_contains($optNameLower, 'health')) $defaultIcon = 'bi-shield-check';
            elseif (str_contains($optNameLower, 'problem')) $defaultIcon = 'bi-exclamation-triangle';
            elseif (str_contains($optNameLower, 'solution')) $defaultIcon = 'bi-box-seam';
            elseif (str_contains($optNameLower, 'budget')) $defaultIcon = 'bi-cash-stack';

            $filterOption = FilterOption::create([
                'name' => $optionData['name'],
                'icon' => $defaultIcon,
                'type' => $optionData['type'],
                'sort_order' => $index,
                'status' => 1,
            ]);

            foreach ($optionData['values'] as $valueIndex => $valueName) {
                $valSlug = Str::slug($valueName, '_');
                $icon = $masterIconMap[$valSlug] ?? 'bi-check-circle';

                $filterOption->optionValues()->create([
                    'name' => $valueName,
                    'icon' => $icon,
                    'sort_order' => $valueIndex,
                    'status' => 1,
                ]);
            }
        }
    }
}
