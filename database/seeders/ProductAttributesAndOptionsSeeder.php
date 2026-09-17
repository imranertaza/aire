<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductAttributesAndOptionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_attributes')->truncate();
        DB::table('product_options')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ensure Options & Option Values exist
        $colorOpt = DB::table('options')->where('name', 'Color')->first();
        if (!$colorOpt) {
            $colorOptId = DB::table('options')->insertGetId([
                'name' => 'Color',
                'type' => 'radio',
                'sort_order' => 1,
                'status' => 1,
                'createdBy' => 1,
                'updatedBy' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            $colorOptId = $colorOpt->id;
        }

        $sizeOpt = DB::table('options')->where('name', 'Size')->first();
        if (!$sizeOpt) {
            $sizeOptId = DB::table('options')->insertGetId([
                'name' => 'Size',
                'type' => 'radio',
                'sort_order' => 2,
                'status' => 1,
                'createdBy' => 1,
                'updatedBy' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            $sizeOptId = $sizeOpt->id;
        }

        $colorValues = DB::table('option_values')->where('option_id', $colorOptId)->pluck('id')->toArray();
        $sizeValues = DB::table('option_values')->where('option_id', $sizeOptId)->pluck('id')->toArray();

        $products = Product::all();
        echo "Seeding attributes and options for " . $products->count() . " products...\n";

        $buildingTypes = ['Apartment', 'House', 'Villa', 'Office', 'Shopping Mall', 'Hospital', 'School', 'Car', 'Factory', 'Warehouse', 'Airport', 'Public Building'];
        $roomTypes = ['Bedroom', 'Whole Apartment', 'Whole House', 'Villa', 'Meeting Room', 'Office Floor', 'Public Area', 'Ward', 'Classroom', 'Vehicle', 'Production Area', 'Warehouse', 'Terminal', 'Lobby'];
        $areaRanges = ['10-20', '20-50', '50-80', '80-120', '120-200', '200-300', '300-500', '500-1000', '1000-2000', '2000-4000', '4000-10000', '10000-20000', '20000+'];
        $occupancies = ['1', '1-2', '3-5', '5-10', '10-50', '50-100', '100+', '1000+'];
        $problemList = ['PM2.5', 'High CO2', 'IAQ', 'Mold, Poor Ventilation', 'Poor Air Quality', 'Smoke & Odor', 'Virus & Bacteria', 'Airborne Particles', 'Dust & VOCs'];

        $cadrList = ['320 m³/h', '480 m³/h', '650 m³/h', '920 m³/h', '1,450 m³/h'];
        $filterList = ['H13 Medical Grade HEPA', 'H14 Ultra-Precision HEPA', 'True HEPA Dual Matrix', 'Activated Carbon + H13 Composite'];
        $noiseList = ['18.5 dB (Ultra-Quiet Sleep Mode)', '21.0 dB (Whisper Silent)', '24.5 dB (Low Velocity)', '28.0 dB (Balanced Acoustic)'];
        $powerList = ['28W Energy Star Certified', '35W High Efficiency', '48W Dynamic Load', '65W Industrial Continuous'];

        $attrGroup = DB::table('product_attribute_groups')->where('name', 'General Specifications')->first();
        if (!$attrGroup) {
            $attrGroupId = DB::table('product_attribute_groups')->insertGetId([
                'name' => 'General Specifications',
                'sort_order' => 1,
                'status' => 1,
                'createdBy' => 1,
                'updatedBy' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $attrGroupId = $attrGroup->id;
        }

        $attributeRows = [];

        foreach ($products as $p) {
            $attrs = [
                ['name' => 'Building Type', 'details' => $buildingTypes[$p->id % count($buildingTypes)]],
                ['name' => 'Room Type', 'details' => $roomTypes[$p->id % count($roomTypes)]],
                ['name' => 'Coverage Area', 'details' => $areaRanges[$p->id % count($areaRanges)]],
                ['name' => 'Occupancy Capacity', 'details' => $occupancies[$p->id % count($occupancies)]],
                ['name' => 'Problem Solved', 'details' => $problemList[$p->id % count($problemList)]],
                ['name' => 'CADR Rating', 'details' => $cadrList[$p->id % count($cadrList)]],
                ['name' => 'Filter Grade', 'details' => $filterList[$p->id % count($filterList)]],
                ['name' => 'Operating Noise', 'details' => $noiseList[$p->id % count($noiseList)]],
                ['name' => 'Power Consumption', 'details' => $powerList[$p->id % count($powerList)]],
            ];

            foreach ($attrs as $sortIdx => $a) {
                $attributeRows[] = [
                    'attribute_group_id' => $attrGroupId,
                    'product_id'         => $p->id,
                    'name'               => $a['name'],
                    'details'            => $a['details'],
                    'sort_order'         => $sortIdx + 1,
                    'status'             => 1,
                    'createdBy'          => 1,
                    'updatedBy'          => 1,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }

            // Seed Options
            if (!empty($colorValues)) {
                $selColors = array_slice($colorValues, $p->id % count($colorValues), 2);
                if (empty($selColors)) $selColors = array_slice($colorValues, 0, 2);
                foreach ($selColors as $cValId) {
                    DB::table('product_options')->insert([
                        'product_id'      => $p->id,
                        'option_id'       => $colorOptId,
                        'option_value_id' => $cValId,
                        'quantity'        => 50,
                        'subtract'        => 1,
                        'price'           => null,
                        'price_prefix'    => '+',
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                }
            }
        }

        foreach (array_chunk($attributeRows, 500) as $chunk) {
            DB::table('product_attributes')->insert($chunk);
        }

        echo "Successfully seeded " . count($attributeRows) . " attributes for {$products->count()} products.\n";
    }
}
