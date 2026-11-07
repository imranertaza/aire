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

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        ProductFilterOption::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

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

        // Align Product 1 as the reference BROAD FE6 AirPro Fresh matching mockups
        $fe6Product = Product::find(1);
        if ($fe6Product) {
            $fe6Product->update([
                'name'  => 'BROAD FE6 AirPro Fresh',
                'model' => 'FE6',
                'slug'  => 'broad-fe6-airpro-fresh',
                'price' => 1499.00,
            ]);
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
                // Steps 8, 9, 10 are interactive results/spec/summary review steps, not product filters
                if ($fOpt->guided_step_number && $fOpt->guided_step_number >= 8) {
                    continue;
                }

                $values = $fOpt->optionValues;
                if ($values->isEmpty()) continue;

                // Filter out non-attribute labels like "I don't know", "Not sure", "No preference"
                $realValues = $values->filter(function ($v) {
                    $nameLower = strtolower(trim($v->name));
                    return !in_array($nameLower, [
                        "i don't know",
                        "not sure",
                        "not sure — recommend",
                        "not sure - recommend",
                        "no preference",
                        "any"
                    ]);
                })->values();

                if ($realValues->isEmpty()) {
                    $realValues = $values;
                }

                $valCount = $realValues->count();

                // Special handling for Product 1 (FE6 reference product) to match mockups 1-10 exactly
                if ($product->id === 1) {
                    $matchedVal = match (strtolower(trim($fOpt->name))) {
                        'application / environment' => $realValues->firstWhere('name', 'Single Room'),
                        'product family'            => $realValues->firstWhere('name', 'Fresh Air & Ventilation'),
                        'space size'                => $realValues->firstWhere('name', '200-500 sq ft'),
                        'airflow'                   => $realValues->firstWhere('name', '100–300 m³/h'),
                        'requirements'              => $realValues->firstWhere('name', 'Wall-mounted'),
                        'budget'                    => $realValues->firstWhere('name', '$1,000–$2,500'),
                        'building type'             => $realValues->firstWhere('name', 'Apartment'),
                        'room / area type'          => $realValues->firstWhere('name', 'Living Room'),
                        'area range (m²)'           => $realValues->firstWhere('name', '21-50 m²'),
                        'occupancy'                 => $realValues->firstWhere('name', '1-2 Persons'),
                        'budget range'              => $realValues->firstWhere('name', '$1,000 - $2,500'),
                        default                     => null,
                    };

                    if ($matchedVal) {
                        $inserts[] = [
                            'product_id'             => $product->id,
                            'filter_option_id'       => $fOpt->id,
                            'filter_option_value_id' => $matchedVal->id,
                            'created_at'             => now(),
                            'updated_at'             => now(),
                        ];
                        continue;
                    }

                    if (strtolower(trim($fOpt->name)) === 'air quality needs') {
                        $freshAirVal = $realValues->firstWhere('name', 'Bring in fresh outdoor air');
                        $pm25Val = $realValues->firstWhere('name', 'Reduce PM2.5 / fine particles');
                        if ($freshAirVal) {
                            $inserts[] = [
                                'product_id'             => $product->id,
                                'filter_option_id'       => $fOpt->id,
                                'filter_option_value_id' => $freshAirVal->id,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                            ];
                        }
                        if ($pm25Val) {
                            $inserts[] = [
                                'product_id'             => $product->id,
                                'filter_option_id'       => $fOpt->id,
                                'filter_option_value_id' => $pm25Val->id,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                            ];
                        }
                        continue;
                    }

                    if (strtolower(trim($fOpt->name)) === 'health concern') {
                        $asthma = $realValues->firstWhere('name', 'Asthma');
                        $allergies = $realValues->firstWhere('name', 'Allergies');
                        if ($asthma) {
                            $inserts[] = [
                                'product_id'             => $product->id,
                                'filter_option_id'       => $fOpt->id,
                                'filter_option_value_id' => $asthma->id,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                            ];
                        }
                        if ($allergies) {
                            $inserts[] = [
                                'product_id'             => $product->id,
                                'filter_option_id'       => $fOpt->id,
                                'filter_option_value_id' => $allergies->id,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                            ];
                        }
                        continue;
                    }

                    if (strtolower(trim($fOpt->name)) === 'problem') {
                        $dust = $realValues->firstWhere('name', 'Dust');
                        $smoke = $realValues->firstWhere('name', 'Smoke');
                        if ($dust) {
                            $inserts[] = [
                                'product_id'             => $product->id,
                                'filter_option_id'       => $fOpt->id,
                                'filter_option_value_id' => $dust->id,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                            ];
                        }
                        if ($smoke) {
                            $inserts[] = [
                                'product_id'             => $product->id,
                                'filter_option_id'       => $fOpt->id,
                                'filter_option_value_id' => $smoke->id,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                            ];
                        }
                        continue;
                    }

                    if (strtolower(trim($fOpt->name)) === 'solution needed') {
                        $purif = $realValues->firstWhere('name', 'Air Purification');
                        $vent = $realValues->firstWhere('name', 'Ventilation');
                        if ($purif) {
                            $inserts[] = [
                                'product_id'             => $product->id,
                                'filter_option_id'       => $fOpt->id,
                                'filter_option_value_id' => $purif->id,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                            ];
                        }
                        if ($vent) {
                            $inserts[] = [
                                'product_id'             => $product->id,
                                'filter_option_id'       => $fOpt->id,
                                'filter_option_value_id' => $vent->id,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                            ];
                        }
                        continue;
                    }
                }

                if ($fOpt->type === 'checkbox') {
                    // Assign 1 or 2 values for checkboxes
                    $v1 = $realValues[$i % $valCount];
                    $v2 = $realValues[($i + 2) % $valCount];

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
                    $v = $realValues[$i % $valCount];
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
