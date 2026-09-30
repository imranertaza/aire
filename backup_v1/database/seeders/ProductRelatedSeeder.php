<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductRelatedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::where('status', 1)->with('categories')->get();

        if ($products->isEmpty()) {
            $this->command->info('No products found to seed related products for.');
            return;
        }

        // Clean existing related products
        DB::table('product_related')->truncate();

        $allProductIds = $products->pluck('id')->toArray();
        $relatedRecords = [];

        foreach ($products as $product) {
            $categoryIds = $product->categories->pluck('id')->toArray();

            // Find products in the same category first (excluding self)
            $sameCategoryProductIds = [];
            if (!empty($categoryIds)) {
                $sameCategoryProductIds = DB::table('product_to_categories')
                    ->whereIn('category_id', $categoryIds)
                    ->where('product_id', '!=', $product->id)
                    ->pluck('product_id')
                    ->unique()
                    ->toArray();
            }

            // Pick 4 to 6 related product IDs
            $selectedRelatedIds = $sameCategoryProductIds;
            if (count($selectedRelatedIds) < 6) {
                $otherIds = array_diff($allProductIds, array_merge([$product->id], $selectedRelatedIds));
                shuffle($otherIds);
                $needed = 6 - count($selectedRelatedIds);
                $selectedRelatedIds = array_merge($selectedRelatedIds, array_slice($otherIds, 0, $needed));
            } else {
                shuffle($selectedRelatedIds);
                $selectedRelatedIds = array_slice($selectedRelatedIds, 0, 6);
            }

            foreach ($selectedRelatedIds as $relatedId) {
                $relatedRecords[] = [
                    'product_id' => $product->id,
                    'related_id' => $relatedId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Batch insert in chunks of 500
        foreach (array_chunk($relatedRecords, 500) as $chunk) {
            DB::table('product_related')->insert($chunk);
        }

        $totalInserted = count($relatedRecords);
        $this->command->info("Successfully seeded {$totalInserted} related product mappings for {$products->count()} products.");
    }
}