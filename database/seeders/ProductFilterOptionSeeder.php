<?php

namespace Database\Seeders;

use App\Models\FilterOption;
use App\Models\Product;
use App\Models\ProductFilterOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductFilterOptionSeeder extends Seeder
{
    /**
     * Run the database seeds to populate product_filter_options.
     */
    public function run(): void
    {
        if ($this->command) {
            $this->command->info('Starting ProductFilterOptionSeeder...');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductFilterOption::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = Product::all();
        $filterOptions = FilterOption::with('optionValues')->get();

        if ($filterOptions->isEmpty()) {
            $this->call(FilterOptionSeeder::class);
            $filterOptions = FilterOption::with('optionValues')->get();
        }

        if ($products->isEmpty()) {
            if ($this->command) {
                $this->command->error('No products found to assign filter options to!');
            }
            return;
        }

        // Ensure Industries categories exist
        $industryParent = \App\Models\ProductCategory::whereNull('parent_id')
            ->where(function ($q) {
                $q->where('slug', 'industries')->orWhere('category_name', 'Industries');
            })
            ->first();

        $industryCategoryIds = [];
        if ($industryParent) {
            $industryCategoryIds = \App\Models\ProductCategory::where('parent_id', $industryParent->id)->pluck('id')->toArray();
        }

        $inserts = [];
        $categoryLinks = [];

        foreach ($products as $idx => $product) {
            $i = $idx + 1;

            // Link to an Industry category
            if (!empty($industryCategoryIds)) {
                $assignedIndCatId = $industryCategoryIds[$i % count($industryCategoryIds)];
                $categoryLinks[] = [
                    'product_id'  => $product->id,
                    'category_id' => $assignedIndCatId
                ];
            }

            foreach ($filterOptions as $fOpt) {
                $values = $fOpt->optionValues;
                if ($values->isEmpty()) continue;

                $valCount = $values->count();

                if ($fOpt->type === 'checkbox') {
                    // Assign 1 or 2 values for checkboxes
                    $v1 = $values[$i % $valCount];
                    $v2 = $values[($i + 2) % $valCount];

                    $inserts[] = [
                        'product_id'             => $product->id,
                        'filter_option_id'       => $fOpt->id,
                        'filter_option_value_id' => $v1->id,
                        'created_at'             => now(),
                        'updated_at'             => now(),
                    ];

                    if ($v1->id !== $v2->id) {
                        $inserts[] = [
                            'product_id'             => $product->id,
                            'filter_option_id'       => $fOpt->id,
                            'filter_option_value_id' => $v2->id,
                            'created_at'             => now(),
                            'updated_at'             => now(),
                        ];
                    }
                } else {
                    // Assign 1 value for radios
                    $v = $values[$i % $valCount];
                    $inserts[] = [
                        'product_id'             => $product->id,
                        'filter_option_id'       => $fOpt->id,
                        'filter_option_value_id' => $v->id,
                        'created_at'             => now(),
                        'updated_at'             => now(),
                    ];
                }
            }
        }

        foreach (array_chunk($inserts, 500) as $chunk) {
            DB::table('product_filter_options')->insert($chunk);
        }

        foreach ($categoryLinks as $link) {
            DB::table('product_to_categories')->updateOrInsert(
                ['product_id' => $link['product_id'], 'category_id' => $link['category_id']],
                []
            );
        }

        if ($this->command) {
            $this->command->info('Successfully seeded ' . count($inserts) . ' product filter options and linked ' . count($categoryLinks) . ' industry categories across ' . $products->count() . ' products!');
        }
    }
}
