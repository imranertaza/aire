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
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Option::truncate();
        OptionValue::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

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

        $adminId = \App\Models\User::value('id') ?: 1;

        $sortOrder = 1;
        foreach ($optionsData as $optName => $optData) {
            $option = Option::create([
                'name'       => $optName,
                'type'       => $optData['type'],
                'sort_order' => $sortOrder++,
                'status'     => 1,
                'createdBy'  => $adminId,
                'updatedBy'  => $adminId,
            ]);

            foreach ($optData['values'] as $vIdx => $valName) {
                OptionValue::create([
                    'option_id'  => $option->id,
                    'name'       => $valName,
                    'image'      => null,
                    'sort_order' => $vIdx + 1,
                    'status'     => 1,
                    'createdBy'  => $adminId,
                    'updatedBy'  => $adminId,
                ]);
            }
        }
    }
}
