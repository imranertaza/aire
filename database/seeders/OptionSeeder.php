<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            [
                'name'       => 'Color',
                'type'       => 'radio',
                'status'     => 1,
                'sort_order' => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
            [
                'name'       => 'Size',
                'type'       => 'radio',
                'status'     => 1,
                'sort_order' => 2,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
        ];

        foreach ($options as $option) {
            Option::create($option);
        }
    }
}
