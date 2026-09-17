<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Option::truncate();
        OptionValue::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $optionsData = [
            'Color' => [
                'type' => 'radio',
                'values' => ['Red', 'Blue', 'Black', 'White', 'Green']
            ],
            'Size' => [
                'type' => 'radio',
                'values' => ['Small', 'Medium', 'Large', 'XL']
            ],
            'Material' => [
                'type' => 'radio',
                'values' => ['Cotton', 'Leather']
            ],
        ];

        $sortOrder = 1;
        foreach ($optionsData as $optName => $optData) {
            $option = Option::create([
                'name'       => $optName,
                'type'       => $optData['type'],
                'sort_order' => $sortOrder++,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ]);

            foreach ($optData['values'] as $vIdx => $valName) {
                OptionValue::create([
                    'option_id'  => $option->id,
                    'name'       => $valName,
                    'image'      => null,
                    'sort_order' => $vIdx + 1,
                    'status'     => 1,
                    'createdBy'  => 1,
                    'updatedBy'  => 1,
                ]);
            }
        }
    }
}
