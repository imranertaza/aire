<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductOption;
use App\Models\ProductDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdvancedProductController extends Controller
{
    /**
     * Get products with pagination and filters for bulk edit view.
     */
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'categories', 'productOptions', 'productAttributes', 'description'])->latest('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $products = $query->paginate($perPage);

        return ApiResponse::success($products, 'Products retrieved successfully');
    }

    /**
     * Update a single field (like status, featured) for one product.
     */
    public function updateField(Request $request)
    {
        $request->validate([
            'id'    => 'required|integer|exists:products,id',
            'field' => 'required|string|in:status,featured',
            'value' => 'required'
        ]);

        $product = Product::findOrFail($request->id);
        $field = $request->field;
        $product->$field = filter_var($request->value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $product->updatedBy = Auth::id();
        $product->save();

        return ApiResponse::success($product->load(['category', 'brand', 'categories']), 'Product field updated successfully');
    }

    /**
     * Update basic details (name, model, price, quantity) for a single product inline.
     */
    public function updateRow(Request $request)
    {
        $request->validate([
            'id'       => 'required|integer|exists:products,id',
            'name'     => 'required|string|max:255',
            'model'    => 'required|string|max:255',
            'price'    => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($request->id);
        $product->update([
            'name'      => $request->name,
            'model'     => $request->model,
            'price'     => $request->price,
            'quantity'  => $request->quantity,
            'alt_name'  => $request->name,
            'updatedBy' => Auth::id(),
        ]);

        return ApiResponse::success($product->load(['category', 'brand', 'categories', 'description']), 'Product updated successfully');
    }

    /**
     * Update product description SEO details inline.
     */
    public function updateDescription(Request $request)
    {
        $request->validate([
            'product_id'       => 'required|integer|exists:products,id',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
        ]);

        $description = ProductDescription::updateOrCreate(
            ['product_id' => $request->product_id],
            [
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keyword'     => $request->meta_keyword,
            ]
        );

        $product = Product::with(['category', 'brand', 'categories', 'description'])->findOrFail($request->product_id);
        return ApiResponse::success($product, 'Product SEO details updated successfully');
    }

    /**
     * Apply a category to multiple selected products.
     */
    public function bulkUpdateCategories(Request $request)
    {
        $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'integer|exists:products,id',
            'category_ids'  => 'required|array',
            'category_ids.*' => 'integer|exists:product_categories,id',
        ]);

        try {
            DB::beginTransaction();

            $categoryIds = $request->category_ids;
            foreach ($request->product_ids as $pid) {
                $product = Product::findOrFail($pid);
                $product->categories()->sync($categoryIds);
            }

            DB::commit();
            return ApiResponse::success(null, 'Bulk categories updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update bulk categories', 500, [$e->getMessage()]);
        }
    }

    /**
     * Apply options to multiple selected products.
     */
    public function bulkUpdateOptions(Request $request)
    {
        $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'integer|exists:products,id',
            'options'       => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->product_ids as $pid) {
                // Delete old options
                ProductOption::where('product_id', $pid)->delete();

                // Insert new options
                $optionData = [];
                foreach ($request->options as $opt) {
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
                ProductOption::insert($optionData);
            }

            DB::commit();
            return ApiResponse::success(null, 'Bulk options updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update bulk options', 500, [$e->getMessage()]);
        }
    }

    /**
     * Apply attributes to multiple selected products.
     */
    public function bulkUpdateAttributes(Request $request)
    {
        // 1. Validate the structure
        $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'integer|exists:products,id',
            'attributes'    => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->product_ids as $pid) {
                // Delete old attributes
                $gg = ProductAttribute::where('product_id', $pid)->delete();

                // Prepare new attributes
                $attrData = [];
                $attributes = $request->input('attributes');
                // dd($request->attributes, $attributes);

                foreach ($attributes as $attr) {

                    // dd($attr);
                    if (!is_array($attr)) {
                        continue;
                    }
                    $attrData[] = [
                        'product_id'         => $pid,
                        'attribute_group_id' => $attr['attribute_group_id'] ?? null,
                        'name'               => $attr['name'] ?? 'General',
                        'details'            => $attr['details'] ?? null,
                        'sort_order'         => $attr['sort_order'] ?? 0,
                        'createdBy'          => Auth::id(),
                        'updatedBy'          => Auth::id(),
                        // Added manual timestamps for bulk insert
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];
                }

                // Only insert if there is data
                if (!empty($attrData)) {
                    ProductAttribute::insert($attrData);
                }
            }

            DB::commit();
            return ApiResponse::success(null, 'Bulk attributes updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the actual error for debugging
            Log::error('Bulk Update Failed: ' . $e->getMessage());
            return ApiResponse::error('Failed to update bulk attributes', 500, [$e->getMessage()]);
        }
    }

    /**
     * Toggle status or featured flags for selected products in bulk.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'integer|exists:products,id',
            'field'         => 'required|string|in:status,featured',
            'value'         => 'required'
        ]);

        try {
            DB::beginTransaction();

            $field = $request->field;
            $val = filter_var($request->value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

            Product::whereIn('id', $request->product_ids)->update([
                $field      => $val,
                'updatedBy' => Auth::id(),
            ]);

            DB::commit();
            return ApiResponse::success(null, 'Bulk status updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update bulk status', 500, [$e->getMessage()]);
        }
    }
}
