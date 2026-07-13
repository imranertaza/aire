<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colorOption = Option::where('name', 'Color')->first();
        $sizeOption  = Option::where('name', 'Size')->first();
        $materialOption = Option::where('name', 'Material')->first();

        if (!$colorOption) {
            $colorOption = Option::create([
                'name'       => 'Color',
                'type'       => 'color',
                'sort_order' => 1,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ]);
        }

        if (!$sizeOption) {
            $sizeOption = Option::create([
                'name'       => 'Size',
                'type'       => 'size',
                'sort_order' => 2,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ]);
        }

        if (!$materialOption) {
            $materialOption = Option::create([
                'name'       => 'Material',
                'type'       => 'material',
                'sort_order' => 3,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ]);
        }

        // Option Values
        OptionValue::insert([
            // === Color Values ===
            [
                'option_id'  => $colorOption->id,
                'name'       => 'Red',
                'image'      => null,
                'sort_order' => 1,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'option_id'  => $colorOption->id,
                'name'       => 'Blue',
                'image'      => null,
                'sort_order' => 2,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'option_id'  => $colorOption->id,
                'name'       => 'Black',
                'image'      => null,
                'sort_order' => 3,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'option_id'  => $colorOption->id,
                'name'       => 'White',
                'image'      => null,
                'sort_order' => 4,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'option_id'  => $colorOption->id,
                'name'       => 'Green',
                'image'      => null,
                'sort_order' => 5,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // === Size Values ===
            [
                'option_id'  => $sizeOption->id,
                'name'       => 'Small',
                'image'      => null,
                'sort_order' => 1,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'option_id'  => $sizeOption->id,
                'name'       => 'Medium',
                'image'      => null,
                'sort_order' => 2,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'option_id'  => $sizeOption->id,
                'name'       => 'Large',
                'image'      => null,
                'sort_order' => 3,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'option_id'  => $sizeOption->id,
                'name'       => 'XL',
                'image'      => null,
                'sort_order' => 4,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // === Material Values ===
            [
                'option_id'  => $materialOption->id,
                'name'       => 'Cotton',
                'image'      => null,
                'sort_order' => 1,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'option_id'  => $materialOption->id,
                'name'       => 'Leather',
                'image'      => null,
                'sort_order' => 2,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
