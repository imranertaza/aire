<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDescription;
use Illuminate\Database\Seeder;

class ProductTagSeeder extends Seeder
{
    public function run(): void
    {
        $tagPool = [
            'ENTERPRISE FILTRATION',
            'HEPA-14 MEDICAL GRADE',
            'INDUSTRIAL AIR CARE',
            'CLEANROOM GRADE SYSTEM',
            'COMMERCIAL AIR PURIFIER',
            'ULTRA-QUIET DESKTOP PURIFIER',
            'HVAC IN-DUCT PURIFICATION',
            'VOC & ODOR ELIMINATOR',
            'PRECISION AIR PURIFICATION',
            'SMART SENSOR AIR CARE',
            'HIGH-CAPACITY FILTRATION',
            'HOSPITAL INFECTION CONTROL',
            'LABORATORY CLEAN AIR',
            'PORTABLE AIR CARE',
            'ACTIVE AEROSOL DEFENSE',
            'SMART RESPIRATORY CARE',
        ];

        $products = Product::with(['categories', 'description'])->get();

        foreach ($products as $index => $product) {
            $category = $product->categories->first();
            $categoryName = strtoupper($category?->category_name ?? '');

            // Choose appropriate tag based on category or name
            if (str_contains($categoryName, 'MASK') || str_contains(strtoupper($product->name), 'MASK')) {
                $tag = 'ACTIVE RESPIRATORY DEFENSE';
            } elseif (str_contains($categoryName, 'INDUSTRIAL') || str_contains(strtoupper($product->name), 'INDUSTRIAL')) {
                $tag = 'INDUSTRIAL AIR CARE';
            } elseif (str_contains($categoryName, 'MEDICAL') || str_contains(strtoupper($product->name), 'HOSPITAL') || str_contains(strtoupper($product->name), 'HEPA')) {
                $tag = 'HEPA-14 MEDICAL GRADE';
            } elseif (str_contains($categoryName, 'CLEANROOM') || str_contains(strtoupper($product->name), 'CLEANROOM')) {
                $tag = 'CLEANROOM GRADE SYSTEM';
            } elseif (str_contains($categoryName, 'HVAC') || str_contains(strtoupper($product->name), 'DUCT')) {
                $tag = 'HVAC IN-DUCT PURIFICATION';
            } elseif (str_contains($categoryName, 'PORTABLE') || str_contains(strtoupper($product->name), 'MINI') || str_contains(strtoupper($product->name), 'DESKTOP')) {
                $tag = 'ULTRA-QUIET DESKTOP PURIFIER';
            } elseif (str_contains($categoryName, 'COMMERCIAL')) {
                $tag = 'COMMERCIAL AIR PURIFIER';
            } else {
                $tag = $tagPool[$index % count($tagPool)];
            }

            if ($product->description) {
                $product->description->update(['tag' => $tag]);
            } else {
                ProductDescription::create([
                    'product_id'        => $product->id,
                    'description'       => $product->name . ' - Professional clean air technology engineered for maximum air purification efficiency.',
                    'tag'               => $tag,
                    'meta_title'        => $product->name,
                    'meta_description'  => $product->name . ' - Advanced Air Purification System',
                ]);
            }
        }

        $this->command->info("Successfully seeded tags for {$products->count()} products.");
    }
}
