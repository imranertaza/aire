<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Product Attributes...');

        // Get existing records
        $products = Product::pluck('id')->toArray();
        $groups = ProductAttributeGroup::pluck('id')->toArray();

        if (empty($products) || empty($groups)) {
            $this->command->warn('No products or attribute groups found. Please seed them first.');
            return;
        }

        $data = [
            // Product 1 (Example)
            [
                'product_id'          => $products[0] ?? 1,
                'attribute_group_id'  => $groups[0] ?? 1,
                'name'                => 'Color',
                'details'             => 'Midnight Black',
                'sort_order'          => 1,
                'status'              => 1,
                'createdBy'           => 1,
                'updatedBy'           => 1,
            ],
            [
                'product_id'          => $products[0] ?? 1,
                'attribute_group_id'  => $groups[0] ?? 1,
                'name'                => 'Storage',
                'details'             => '256 GB',
                'sort_order'          => 2,
                'status'              => 1,
                'createdBy'           => 1,
                'updatedBy'           => 1,
            ],
            [
                'product_id'          => $products[0] ?? 1,
                'attribute_group_id'  => $groups[1] ?? 2,
                'name'                => 'Processor',
                'details'             => 'Snapdragon 8 Gen 2',
                'sort_order'          => 1,
                'status'              => 1,
                'createdBy'           => 1,
                'updatedBy'           => 1,
            ],

            // Product 2
            [
                'product_id'          => $products[1] ?? 2,
                'attribute_group_id'  => $groups[0] ?? 1,
                'name'                => 'Size',
                'details'             => 'US 10',
                'sort_order'          => 1,
                'status'              => 1,
                'createdBy'           => 1,
                'updatedBy'           => 1,
            ],
        ];

        foreach ($data as $item) {
            ProductAttribute::updateOrCreate(
                [
                    'product_id'         => $item['product_id'],
                    'attribute_group_id' => $item['attribute_group_id'],
                    'name'               => $item['name'],
                ],
                $item
            );
        }

        $this->command->info('ProductAttributeSeeder completed successfully!');
    }
}
