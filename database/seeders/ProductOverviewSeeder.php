<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductOverview;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOverviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_overviews')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = Product::with(['categories', 'productAttributes'])->get();
        echo "Seeding overview data for " . $products->count() . " products...\n";

        foreach ($products as $p) {
            $cat = $p->categories->first();
            $catName = $cat ? $cat->category_name : 'Advanced Air Solutions';

            // Distinct themes based on product naming / categories
            $isMask = str_contains(strtolower($p->name), 'mask') || str_contains(strtolower($p->name), 'wearable');
            $isCommercial = str_contains(strtolower($catName), 'commercial') || str_contains(strtolower($p->name), 'pro') || str_contains(strtolower($p->name), 'industrial');

            if ($isMask) {
                $title = "Versatility Without Compromise";
                $description = "The {$p->name} represents a paradigm shift in wearable protection. Designed for the most demanding technical environments while remaining sophisticated enough for professional urban use, it provides a seamless transition between critical laboratory work and high-density metropolitan mobility.";
                $feat1Title = "CRITICAL ENVIRONMENTS";
                $feat1Desc = "Engineered for cleanrooms, laboratories, and precision fabrication facilities.";
                $feat1Icon = "bi bi-flask";

                $feat2Title = "URBAN RESILIENCE";
                $feat2Desc = "Protection against high-density metropolitan particulate, wildfire smoke, and allergens.";
                $feat2Icon = "bi bi-buildings";
            } elseif ($isCommercial) {
                $title = "High-Volume Air Purification & Climate Control";
                $description = "Engineered for industrial spaces, cleanrooms, and enterprise facilities. The {$p->name} combines high-capacity multi-stage filtration with precision laminar airflow dynamics to maintain pristine air hygiene across large floor plates.";
                $feat1Title = "INDUSTRIAL EFFICIENCY";
                $feat1Desc = "Continuous duty-cycle rated with high-efficiency motor technology delivering whisper-quiet performance.";
                $feat1Icon = "bi bi-cpu";

                $feat2Title = "HEPA & CARBON MATRIX";
                $feat2Desc = "Captures 99.97% of ultra-fine particulates, VOCs, chemical vapors, and biological aerosols.";
                $feat2Icon = "bi bi-shield-check";
            } else {
                $title = "Intelligent Air Purification Designed for Modern Living";
                $description = "The {$p->name} delivers clinical-grade indoor air purification with ultra-low acoustic signature and smart environmental sensor integration, ensuring uninterrupted clean air for your entire environment.";
                $feat1Title = "ACTIVE SENSING & ADAPTATION";
                $feat1Desc = "Hyper-responsive laser particulate monitoring adjusts purification levels in real time.";
                $feat1Icon = "bi bi-broadcast";

                $feat2Title = "ZERO-OZONE CERTIFIED";
                $feat2Desc = "Pure mechanical filtration without harmful emissions, ensuring safe continuous operation in residential spaces.";
                $feat2Icon = "bi bi-tree";
            }

            ProductOverview::create([
                'product_id'     => $p->id,
                'title'          => $title,
                'description'    => $description,
                'image'          => $p->main_image,
                'feature1_icon'  => $feat1Icon,
                'feature1_title' => $feat1Title,
                'feature1_desc'  => $feat1Desc,
                'feature2_icon'  => $feat2Icon,
                'feature2_title' => $feat2Title,
                'feature2_desc'  => $feat2Desc,
                'hud_label1'     => $p->model ?: 'ACTIVE PRESSURE BALANCE',
                'hud_label2'     => strtoupper($catName),
                'hud_label3'     => 'CERTIFIED HIGH EFFICIENCY',
            ]);
        }

        echo "Product overview seeded successfully!\n";
    }
}
