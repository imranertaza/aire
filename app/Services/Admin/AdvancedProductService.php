<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductDescription;
use App\Models\ProductFilterOption;
use App\Models\ProductOption;
use App\Services\Common\FileUploadService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdvancedProductService
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {}

    /**
     * Get products with pagination and filters for bulk edit view.
     */
    public function listProducts(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Product::withBulkEditRelations()
            ->search($filters['search'] ?? null)
            ->latest('id')
            ->paginate($perPage);
    }

    /**
     * Update a single field (status, featured) for one product.
     */
    public function updateField(int $id, string $field, mixed $value): Product
    {
        $product = Product::findOrFail($id);
        $product->$field = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $product->updatedBy = Auth::id();
        $product->save();

        return $product->load(['brand', 'categories']);
    }

    /**
     * Update basic details (name, model, price, quantity) for a single product inline.
     */
    public function updateRow(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name'      => $data['name'],
            'model'     => $data['model'],
            'price'     => $data['price'],
            'quantity'  => $data['quantity'],
            'alt_name'  => $data['name'],
            'updatedBy' => Auth::id(),
        ]);

        return $product->load(['brand', 'categories', 'description']);
    }

    /**
     * Update product description SEO details inline.
     */
    public function updateDescription(int $productId, array $data): Product
    {
        ProductDescription::updateOrCreate(
            ['product_id' => $productId],
            [
                'meta_title'       => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keyword'     => $data['meta_keyword'] ?? null,
            ]
        );

        return Product::with(['brand', 'categories', 'description'])->findOrFail($productId);
    }

    /**
     * Apply categories to multiple selected products in bulk.
     *
     * @param array<int> $productIds
     * @param array<int> $categoryIds
     */
    public function bulkUpdateCategories(array $productIds, array $categoryIds): void
    {
        DB::transaction(function () use ($productIds, $categoryIds) {
            $products = Product::whereIn('id', $productIds)->get();
            foreach ($products as $product) {
                $product->categories()->sync($categoryIds);
            }
        });
    }

    /**
     * Apply options to multiple selected products in bulk.
     *
     * @param array<int> $productIds
     * @param array $options
     */
    public function bulkUpdateOptions(array $productIds, array $options): void
    {
        DB::transaction(function () use ($productIds, $options) {
            foreach ($productIds as $pid) {
                ProductOption::where('product_id', $pid)->delete();

                $optionData = [];
                foreach ($options as $opt) {
                    if (empty($opt['option_id']) || empty($opt['option_value_id'])) {
                        continue;
                    }

                    $optionData[] = [
                        'product_id'      => $pid,
                        'option_id'       => $opt['option_id'],
                        'option_value_id' => $opt['option_value_id'],
                        'quantity'        => $opt['quantity'] ?? 0,
                        'subtract'        => filter_var($opt['subtract'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                        'price'           => $opt['price'] ?? null,
                        'price_prefix'    => $opt['price_prefix'] ?? '+',
                    ];
                }

                if (!empty($optionData)) {
                    ProductOption::insert($optionData);
                }
            }
        });
    }

    /**
     * Apply filter options to multiple selected products in bulk.
     *
     * @param array<int> $productIds
     * @param array $filterOptions
     */
    public function bulkUpdateFilterOptions(array $productIds, array $filterOptions): void
    {
        DB::transaction(function () use ($productIds, $filterOptions) {
            foreach ($productIds as $pid) {
                ProductFilterOption::where('product_id', $pid)->delete();

                $filterOptionData = [];
                foreach ($filterOptions as $opt) {
                    if (empty($opt['filter_option_id']) || empty($opt['filter_option_value_id'])) {
                        continue;
                    }

                    $filterOptionData[] = [
                        'product_id'             => $pid,
                        'filter_option_id'       => $opt['filter_option_id'],
                        'filter_option_value_id' => $opt['filter_option_value_id'],
                    ];
                }

                if (!empty($filterOptionData)) {
                    ProductFilterOption::insert($filterOptionData);
                }
            }
        });
    }

    /**
     * Apply attributes to multiple selected products in bulk.
     *
     * @param array<int> $productIds
     * @param array $attributes
     */
    public function bulkUpdateAttributes(array $productIds, array $attributes): void
    {
        DB::transaction(function () use ($productIds, $attributes) {
            $now = Carbon::now();
            $authId = Auth::id();

            foreach ($productIds as $pid) {
                ProductAttribute::where('product_id', $pid)->delete();

                $attrData = [];
                foreach ($attributes as $attr) {
                    if (!is_array($attr) || empty($attr['name']) || empty($attr['attribute_group_id'])) {
                        continue;
                    }

                    $attrData[] = [
                        'product_id'         => $pid,
                        'attribute_group_id' => (int) $attr['attribute_group_id'],
                        'name'               => trim($attr['name']),
                        'details'            => $attr['details'] ?? null,
                        'sort_order'         => isset($attr['sort_order']) ? (int) $attr['sort_order'] : 0,
                        'status'             => 1,
                        'createdBy'          => $authId,
                        'updatedBy'          => $authId,
                        'created_at'         => $now,
                        'updated_at'         => $now,
                    ];
                }

                if (!empty($attrData)) {
                    ProductAttribute::insert($attrData);
                }
            }
        });
    }

    /**
     * Toggle status or featured flags for selected products in bulk.
     *
     * @param array<int> $productIds
     * @param string $field
     * @param mixed $value
     */
    public function bulkUpdateStatus(array $productIds, string $field, mixed $value): void
    {
        DB::transaction(function () use ($productIds, $field, $value) {
            $val = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

            Product::whereIn('id', $productIds)->update([
                $field      => $val,
                'updatedBy' => Auth::id(),
            ]);
        });
    }
}
