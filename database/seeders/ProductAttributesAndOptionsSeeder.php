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
                'name' => 'Color', 'type' => 'radio', 'sort_order' => 1, 'status' => 1, 'createdBy' => 1, 'updatedBy' => 1, 'created_at' => now(), 'updated_at' => now()
            ]);
        } else {
            $colorOptId = $colorOpt->id;
        }

        $sizeOpt = DB::table('options')->where('name', 'Size')->first();
        if (!$sizeOpt) {
            $sizeOptId = DB::table('options')->insertGetId([
                'name' => 'Size', 'type' => 'radio', 'sort_order' => 2, 'status' => 1, 'createdBy' => 1, 'updatedBy' => 1, 'created_at' => now(), 'updated_at' => now()
            ]);
        } else {
            $sizeOptId = $sizeOpt->id;
        }

        $matOpt = DB::table('options')->where('name', 'Material')->first();
        if (!$matOpt) {
            $matOptId = DB::table('options')->insertGetId([
                'name' => 'Material', 'type' => 'material', 'sort_order' => 3, 'status' => 1, 'createdBy' => 1, 'updatedBy' => 1, 'created_at' => now(), 'updated_at' => now()
            ]);
        } else {
            $matOptId = $matOpt->id;
        }

        // Get option values
        $colorValues = DB::table('option_values')->where('option_id', $colorOptId)->pluck('id')->toArray();
        $sizeValues = DB::table('option_values')->where('option_id', $sizeOptId)->pluck('id')->toArray();
        $matValues = DB::table('option_values')->where('option_id', $matOptId)->pluck('id')->toArray();

        $products = Product::all();
        echo "Seeding attributes and options for " . $products->count() . " products...\n";

        $cadrList = ['320 m³/h', '480 m³/h', '650 m³/h', '920 m³/h', '1,450 m³/h'];
        $filterList = ['H13 Medical Grade HEPA', 'H14 Ultra-Precision HEPA', 'True HEPA Dual Matrix', 'Activated Carbon + H13 Composite'];
        $coverageList = ['Up to 450 sq ft (42 m²)', 'Up to 850 sq ft (79 m²)', 'Up to 1,500 sq ft (140 m²)', 'Whole Floor (2,800 sq ft)', 'Industrial Complex (> 4,500 sq ft)'];
        $noiseList = ['18.5 dB (Ultra-Quiet Sleep Mode)', '21.0 dB (Whisper Silent)', '24.5 dB (Low Velocity)', '28.0 dB (Balanced Acoustic)'];
        $powerList = ['28W Energy Star Certified', '35W High Efficiency', '48W Dynamic Load', '65W Industrial Continuous'];
        $smartList = ['AIRE Cloud IoT (Wi-Fi 6 / Bluetooth 5.2)', 'AI Auto-Modulation + Apple HomeKit & Google Assistant', 'BACnet & Modbus Enterprise BMS Integration', 'Touchscreen OLED Panel & Mobile App'];

        $attrCount = 0;
        $optCount = 0;

        foreach ($products as $p) {
            // Seed Attributes
            $attrs = [
                ['name' => 'CADR Rating', 'details' => $cadrList[$p->id % count($cadrList)]],
                ['name' => 'Filter Grade', 'details' => $filterList[$p->id % count($filterList)]],
                ['name' => 'Coverage Area', 'details' => $coverageList[$p->id % count($coverageList)]],
                ['name' => 'Operating Noise', 'details' => $noiseList[$p->id % count($noiseList)]],
                ['name' => 'Power Consumption', 'details' => $powerList[$p->id % count($powerList)]],
                ['name' => 'Smart Connectivity', 'details' => $smartList[$p->id % count($smartList)]],
            ];

            foreach ($attrs as $sortIdx => $a) {
                DB::table('product_attributes')->insert([
                    'attribute_group_id' => 1,
                    'product_id'         => $p->id,
                    'name'               => $a['name'],
                    'details'            => $a['details'],
                    'sort_order'         => $sortIdx + 1,
                    'status'             => 1,
                    'createdBy'          => 1,
                    'updatedBy'          => 1,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
                $attrCount++;
            }

            // Seed Options (Color)
            if (!empty($colorValues)) {
                $selColors = array_slice($colorValues, $p->id % count($colorValues), 3);
                if (empty($selColors)) {
                    $selColors = array_slice($colorValues, 0, 2);
                }
                foreach ($selColors as $valId) {
                    DB::table('product_options')->insert([
                        'product_id'      => $p->id,
                        'option_id'       => $colorOptId,
                        'option_value_id' => $valId,
                        'quantity'        => rand(15, 60),
                        'subtract'        => 1,
                        'price'           => 0.00,
                        'price_prefix'    => '+',
                        'points'          => 0,
                        'point_prefix'    => '+',
                        'weight'          => 0.00,
                        'weight_prefix'   => '+',
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                    $optCount++;
                }
            }

            // Seed Options (Size)
            if (!empty($sizeValues)) {
                $selSizes = array_slice($sizeValues, 0, 3);
                $extraPrices = [0.00, 45.00, 95.00, 150.00];
                foreach ($selSizes as $sIdx => $valId) {
                    DB::table('product_options')->insert([
                        'product_id'      => $p->id,
                        'option_id'       => $sizeOptId,
                        'option_value_id' => $valId,
                        'quantity'        => rand(15, 60),
                        'subtract'        => 1,
                        'price'           => $extraPrices[$sIdx % count($extraPrices)],
                        'price_prefix'    => '+',
                        'points'          => 0,
                        'point_prefix'    => '+',
                        'weight'          => 0.00,
                        'weight_prefix'   => '+',
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                    $optCount++;
                }
            }

            // Seed Options (Material)
            if (!empty($matValues)) {
                foreach ($matValues as $mIdx => $valId) {
                    DB::table('product_options')->insert([
                        'product_id'      => $p->id,
                        'option_id'       => $matOptId,
                        'option_value_id' => $valId,
                        'quantity'        => rand(15, 60),
                        'subtract'        => 1,
                        'price'           => $mIdx == 0 ? 0.00 : 35.00,
                        'price_prefix'    => '+',
                        'points'          => 0,
                        'point_prefix'    => '+',
                        'weight'          => 0.00,
                        'weight_prefix'   => '+',
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                    $optCount++;
                }
            }
        }

        echo "Seeded {$attrCount} clean air product_attributes and {$optCount} product_options across all products!\n";
    }
}
