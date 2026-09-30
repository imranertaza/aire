<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductCompareService
{
    protected const MAX_COMPARE_LIMIT = 3;

    /**
     * Get comparison product IDs from session.
     */
    public function getCompareIds(): array
    {
        $compare = session()->get('compare', []);
        return is_array($compare) ? array_map('intval', $compare) : [];
    }

    /**
     * Retrieve Product models in user's comparison list.
     */
    public function getComparedProducts(): Collection
    {
        $ids = $this->getCompareIds();

        if (empty($ids)) {
            return new Collection();
        }

        return Product::with(['categories', 'brand', 'images', 'productAttributes'])
            ->whereIn('id', $ids)
            ->get();
    }

    /**
     * Add product to compare session with limit validation.
     */
    public function add(int $productId): array
    {
        $product = Product::where('id', $productId)->where('status', 1)->first();
        $compare = $this->getCompareIds();

        if (!$product) {
            return [
                'success'       => false,
                'message'       => 'Product is currently unavailable or inactive.',
                'count'         => count($compare),
                'compare_count' => count($compare),
            ];
        }

        if (in_array($productId, $compare, true)) {
            return [
                'success'       => false,
                'already_added' => true,
                'message'       => 'Product is already in your comparison list!',
                'count'         => count($compare),
                'compare_count' => count($compare),
            ];
        }

        if (count($compare) >= self::MAX_COMPARE_LIMIT) {
            return [
                'success'       => false,
                'limit_reached' => true,
                'message'       => 'You can compare up to ' . self::MAX_COMPARE_LIMIT . ' products at a time. Please remove one first.',
                'count'         => count($compare),
                'compare_count' => count($compare),
            ];
        }

        $compare[] = $productId;
        $this->saveCompareSession($compare);

        return [
            'success'       => true,
            'message'       => 'Product added to comparison list!',
            'count'         => count($compare),
            'compare_count' => count($compare),
            'product'       => [
                'id'   => $product->id,
                'name' => $product->name,
            ],
        ];
    }

    /**
     * Remove product from compare session.
     */
    public function remove(int $productId): array
    {
        $compare = $this->getCompareIds();
        $compare = array_values(array_filter($compare, fn($id) => (int) $id !== $productId));

        $this->saveCompareSession($compare);

        return [
            'success'       => true,
            'message'       => 'Product removed from comparison list!',
            'count'         => count($compare),
            'compare_count' => count($compare),
        ];
    }

    /**
     * Clear all compared products from session.
     */
    public function clear(): array
    {
        session()->forget(['compare', 'compare_products']);

        return [
            'success'       => true,
            'message'       => 'Comparison list cleared!',
            'count'         => 0,
            'compare_count' => 0,
        ];
    }

    /**
     * Helper to persist compare lists into session.
     */
    protected function saveCompareSession(array $ids): void
    {
        session()->put('compare', $ids);
        session()->put('compare_products', $ids);
    }
}
