<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Database\Seeder;

class ProductOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting ProductOptionSeeder...');

        // Get first few existing records
        $productIds = Product::pluck('id')->take(10)->toArray();
        $optionIds  = Option::pluck('id')->take(10)->toArray();
        $valueIds   = OptionValue::pluck('id')->take(20)->toArray();

        if (empty($productIds) || empty($optionIds) || empty($valueIds)) {
            $this->command->error('No products, options, or option values found. Please seed them first!');
            return;
        }

        $this->command->info("Found " . count($productIds) . " products, " .
            count($optionIds) . " options, " . count($valueIds) . " option values.");

        // Sample data using existing IDs
        $data = [
            ['product_id' => $productIds[0] ?? 1, 'option_id' => $optionIds[0] ?? 8, 'option_value_id' => $valueIds[0] ?? 11, 'quantity' => 10, 'subtract' => 1, 'price' => 0],
            ['product_id' => $productIds[0] ?? 1, 'option_id' => $optionIds[0] ?? 8, 'option_value_id' => $valueIds[1] ?? 15, 'quantity' => 8,  'subtract' => 1, 'price' => 5.00],
            ['product_id' => $productIds[1] ?? 2, 'option_id' => $optionIds[0] ?? 8, 'option_value_id' => $valueIds[0] ?? 11, 'quantity' => 15, 'subtract' => 1, 'price' => 0],
        ];

        foreach ($data as $item) {
            ProductOption::updateOrCreate(
                [
                    'product_id'      => $item['product_id'],
                    'option_id'       => $item['option_id'],
                    'option_value_id' => $item['option_value_id'],
                ],
                [
                    'quantity'      => $item['quantity'],
                    'subtract'      => $item['subtract'] ?? 1,
                    'price'         => $item['price'] ?? 0,
                    'price_prefix'  => '+',
                    'points'        => null,
                    'point_prefix'  => '+',
                    'weight'        => null,
                    'weight_prefix' => '+',
                ]
            );
        }

        $this->command->info('ProductOptionSeeder completed successfully!');
    }
}
