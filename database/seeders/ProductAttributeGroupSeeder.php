<?php

namespace Database\Seeders;

use App\Models\ProductAttributeGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name'       => 'General',
                'sort_order' => 1,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
            [
                'name'       => 'Technical Specifications',
                'sort_order' => 2,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
            [
                'name'       => 'Features',
                'sort_order' => 3,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
            [
                'name'       => 'Dimensions & Weight',
                'sort_order' => 4,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
            [
                'name'       => 'Display',
                'sort_order' => 5,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
            [
                'name'       => 'Battery & Power',
                'sort_order' => 6,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
            [
                'name'       => 'Connectivity',
                'sort_order' => 7,
                'status'     => 1,
                'createdBy'  => 1,
                'updatedBy'  => 1,
            ],
        ];

        foreach ($groups as $group) {
            ProductAttributeGroup::updateOrCreate(
                ['name' => $group['name']],
                $group
            );
        }

        $this->command->info('ProductAttributeGroupSeeder completed successfully!');
    }
}
