<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeGroup;
use App\Models\ProductCategory;
use App\Models\ProductDescription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductFilterOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds to attach all 9 filter options, categories, attributes, and tags to products.
     */
    public function run(): void
    {
        $products = Product::with(['description', 'categories', 'productAttributes'])->get();
        if ($products->isEmpty()) {
            $this->command->error('No products found to seed options for!');
            return;
        }

        // 1. Ensure Attribute Group exists
        $attrGroup = ProductAttributeGroup::firstOrCreate(
            ['id' => 1],
            ['name' => 'Technical Specifications', 'sort_order' => 1, 'status' => 1]
        );

        // 2. Fetch Options & Option Values map
        $options = Option::with('optionValues')->get()->keyBy(fn($o) => Str::slug($o->name, '_'));

        $buildingTypes = [
            'Apartment', 'House', 'Villa', 'Office', 'Shopping Mall',
            'Hospital', 'School', 'Car', 'Factory', 'Warehouse', 'Airport', 'Public Building'
        ];

        $roomTypes = [
            'Bedroom', 'Whole Apartment', 'Whole House', 'Villa', 'Meeting Room',
            'Office Floor', 'Public Area', 'Ward', 'Classroom', 'Vehicle',
            'Production Area', 'Warehouse', 'Terminal', 'Lobby'
        ];

        $areaRanges = [
            '10-20', '20-50', '50-80', '80-120', '120-200', '200-300',
            '300-500', '500-1000', '1000-2000', '2000-4000', '4000-10000', '10000-20000', '20000+'
        ];

        $occupancies = [
            '1', '1-2', '3-5', '5-10', '10-50', '50-100', '100+', '1000+'
        ];

        $healthConcerns = [
            'Allergies', 'Asthma', 'Family Health', 'Luxury Wellness', 'Productivity',
            'Employee Wellness', 'Public Health', 'Virus Protection', 'Respiratory Safety',
            "Children's Health", 'Driver Health', 'Worker Safety', 'Compliance', 'MegaFacility'
        ];

        $problems = [
            'PM2.5', 'High CO2', 'IAQ', 'Mold, Poor Ventilation', 'PM2.5 + CO2',
            'Poor Air Quality', 'Smoke & Odor', 'Virus & Bacteria', 'Airborne Particles',
            'Dust & VOCs', 'Large Building Ventilation', 'Large Space Air Quality',
            'HVAC Treatment', 'PM2.5 Monitoring'
        ];

        $solutions = [
            'Air Purification', 'Fresh Air + Heat Recovery', 'Ventilation + Monitoring',
            'Whole House Ventilation', 'Air Quality Management', 'Personal Protection',
            'Vehicle Air Quality', 'CO2 Monitoring', 'Central Ventilation',
            'Purification + HVAC', 'HVAC Treatment', 'Monitoring'
        ];

        $filterGrades = [
            'HEPA H13 (99.95%)', 'HEPA H14 (99.995%)', 'Medical-Grade True HEPA',
            'ULPA U15 (99.9995%)', 'Activated Carbon + HEPA H13', 'Nano-Silver Antimicrobial HEPA'
        ];

        $cadrRatings = [
            '250 m³/h', '450 m³/h', '600 m³/h', '800 m³/h', '1200 m³/h', '2500 m³/h', '5000 m³/h'
        ];

        // 3. Industry child category IDs
        $industryParent = ProductCategory::whereNull('parent_id')
            ->where(function ($q) {
                $q->where('slug', 'industries')->orWhere('category_name', 'Industries');
            })
            ->first();

        $industryCategoryIds = [];
        if ($industryParent) {
            $industryCategoryIds = ProductCategory::where('parent_id', $industryParent->id)->pluck('id')->toArray();
        }

        // Solutions child category IDs
        $solutionParent = ProductCategory::whereNull('parent_id')
            ->where(function ($q) {
                $q->where('slug', 'solutions')->orWhere('category_name', 'Solutions');
            })
            ->first();

        $solutionCategoryIds = [];
        if ($solutionParent) {
            $solutionCategoryIds = ProductCategory::where('parent_id', $solutionParent->id)->pluck('id')->toArray();
        }

        // Clear existing product_options & product_attributes to re-seed cleanly
        DB::table('product_options')->truncate();
        DB::table('product_attributes')->truncate();

        $productOptionInserts = [];
        $productAttributeInserts = [];
        $productCategoryInserts = [];

        foreach ($products as $idx => $product) {
            $i = $idx + 1;

            // Varied choices based on product ID
            $selBuilding = $buildingTypes[$i % count($buildingTypes)];
            $selRoom = $roomTypes[$i % count($roomTypes)];
            $selArea = $areaRanges[$i % count($areaRanges)];
            $selOcc = $occupancies[$i % count($occupancies)];

            // Multiple health concerns & problems & solutions
            $selHealth1 = $healthConcerns[$i % count($healthConcerns)];
            $selHealth2 = $healthConcerns[($i + 3) % count($healthConcerns)];

            $selProblem1 = $problems[$i % count($problems)];
            $selProblem2 = $problems[($i + 4) % count($problems)];

            $selSolution1 = $solutions[$i % count($solutions)];
            $selSolution2 = $solutions[($i + 5) % count($solutions)];

            $selFilterGrade = $filterGrades[$i % count($filterGrades)];
            $selCadr = $cadrRatings[$i % count($cadrRatings)];

            // 1. Assign Attributes
            $attrs = [
                ['name' => 'Building Type',       'details' => $selBuilding],
                ['name' => 'Room Type',           'details' => $selRoom],
                ['name' => 'Coverage Area',       'details' => $selArea],
                ['name' => 'Occupancy Capacity',  'details' => $selOcc],
                ['name' => 'Filter Grade',        'details' => $selFilterGrade],
                ['name' => 'CADR Rating',         'details' => $selCadr],
                ['name' => 'Problem Solved',      'details' => "{$selProblem1}, {$selProblem2}"],
                ['name' => 'Health Benefits',     'details' => "{$selHealth1}, {$selHealth2}"],
                ['name' => 'Recommended Solution','details' => "{$selSolution1}, {$selSolution2}"],
                ['name' => 'Operating Noise',     'details' => (18 + ($i % 30)) . ' dB(A)'],
                ['name' => 'Power Consumption',   'details' => (25 + ($i % 120)) . ' W'],
                ['name' => 'Efficiency Rating',   'details' => 'A++ European Standard'],
            ];

            foreach ($attrs as $sortIdx => $a) {
                $productAttributeInserts[] = [
                    'attribute_group_id' => $attrGroup->id,
                    'product_id'         => $product->id,
                    'name'               => $a['name'],
                    'details'            => $a['details'],
                    'sort_order'         => $sortIdx + 1,
                    'status'             => 1,
                    'createdBy'          => 1,
                    'updatedBy'          => 1,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }

            // 2. Assign Option Values in product_options table
            $optionMappings = [
                'building_type'   => $selBuilding,
                'room_area_type'  => $selRoom,
                'area_range_m'    => $selArea,
                'occupancy'       => $selOcc,
                'health_concern'  => [$selHealth1, $selHealth2],
                'problem'         => [$selProblem1, $selProblem2],
                'solution_needed' => [$selSolution1, $selSolution2],
            ];

            foreach ($optionMappings as $optKey => $vals) {
                $opt = $options->get($optKey) ?? $options->first(fn($o) => Str::slug($o->name, '_') === $optKey);
                if ($opt) {
                    $valArray = is_array($vals) ? $vals : [$vals];
                    foreach ($valArray as $valName) {
                        $ov = $opt->optionValues->first(fn($v) => strcasecmp($v->name, $valName) === 0 || Str::slug($v->name, '_') === Str::slug($valName, '_'));
                        if ($ov) {
                            $productOptionInserts[] = [
                                'product_id'      => $product->id,
                                'option_id'       => $opt->id,
                                'option_value_id' => $ov->id,
                                'quantity'        => 50,
                                'subtract'        => 1,
                                'price'           => 0,
                                'price_prefix'    => '+',
                                'points'          => null,
                                'point_prefix'    => '+',
                                'weight'          => null,
                                'weight_prefix'   => '+',
                                'created_at'      => now(),
                                'updated_at'      => now(),
                            ];
                        }
                    }
                }
            }

            // 3. Connect to Industry and Solution Categories
            if (!empty($industryCategoryIds)) {
                $assignedIndCatId = $industryCategoryIds[$i % count($industryCategoryIds)];
                $productCategoryInserts[] = [
                    'product_id'  => $product->id,
                    'category_id' => $assignedIndCatId
                ];
            }

            if (!empty($solutionCategoryIds)) {
                $assignedSolCatId = $solutionCategoryIds[$i % count($solutionCategoryIds)];
                $productCategoryInserts[] = [
                    'product_id'  => $product->id,
                    'category_id' => $assignedSolCatId
                ];
            }

            // 4. Update Product Description with searchable tags and rich keywords
            $tagList = array_unique([
                $selBuilding, $selRoom, $selArea, $selOcc,
                $selHealth1, $selHealth2, $selProblem1, $selProblem2,
                $selSolution1, $selSolution2,
                Str::slug($selBuilding, '_'), Str::slug($selRoom, '_'),
                Str::slug($selHealth1, '_'), Str::slug($selProblem1, '_'),
                Str::slug($selSolution1, '_')
            ]);

            $tagsString = implode(', ', $tagList);

            if ($product->description) {
                $product->description->update([
                    'tag'              => $tagsString,
                    'meta_title'       => "{$product->name} - {$selBuilding} {$selRoom} Air Purification",
                    'meta_description' => "Advanced {$selFilterGrade} system with {$selCadr} CADR for {$selArea} m² coverage in {$selBuilding} environments.",
                ]);
            } else {
                ProductDescription::create([
                    'product_id'       => $product->id,
                    'description'      => "<p>High performance {$selFilterGrade} solution engineered for {$selBuilding} and {$selRoom} with {$selArea} m² coverage.</p>",
                    'tag'              => $tagsString,
                    'meta_title'       => "{$product->name} - {$selBuilding} Air Quality",
                    'meta_description' => "Designed for {$selBuilding} coverage of {$selArea} m².",
                ]);
            }
        }

        // Bulk insert attributes
        foreach (array_chunk($productAttributeInserts, 500) as $chunk) {
            DB::table('product_attributes')->insert($chunk);
        }

        // Bulk insert options
        foreach (array_chunk($productOptionInserts, 500) as $chunk) {
            DB::table('product_options')->insert($chunk);
        }

        // Bulk insert category relations (ignore duplicate product-category combinations)
        foreach ($productCategoryInserts as $pCat) {
            DB::table('product_to_categories')->updateOrInsert(
                ['product_id' => $pCat['product_id'], 'category_id' => $pCat['category_id']],
                []
            );
        }

        // Seed product filter options
        $this->call(ProductFilterOptionSeeder::class);

        echo "Successfully seeded " . count($productAttributeInserts) . " attributes, " .
             count($productOptionInserts) . " option associations, and updated category links & tags for " .
             $products->count() . " products.\n";
    }
}