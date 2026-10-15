<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\Advanced\BulkUpdateAttributesRequest;
use App\Http\Requests\Product\Advanced\BulkUpdateCategoriesRequest;
use App\Http\Requests\Product\Advanced\BulkUpdateFilterOptionsRequest;
use App\Http\Requests\Product\Advanced\BulkUpdateOptionsRequest;
use App\Http\Requests\Product\Advanced\BulkUpdateStatusRequest;
use App\Http\Requests\Product\Advanced\UpdateProductDescriptionRequest;
use App\Http\Requests\Product\Advanced\UpdateProductFieldRequest;
use App\Http\Requests\Product\Advanced\UpdateProductRowRequest;
use App\Services\Admin\AdvancedProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdvancedProductController extends Controller
{
    public function __construct(
        protected AdvancedProductService $advancedProductService
    ) {}

    /**
     * Get products with pagination and filters for bulk edit view.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 10);
        $products = $this->advancedProductService->listProducts($request->all(), $perPage);

        return ApiResponse::success($products, 'Products retrieved successfully');
    }

    /**
     * Update a single field (like status, featured) for one product.
     */
    public function updateField(UpdateProductFieldRequest $request): JsonResponse
    {
        $product = $this->advancedProductService->updateField(
            (int) $request->input('id'),
            $request->input('field'),
            $request->input('value')
        );

        return ApiResponse::success($product, 'Product field updated successfully');
    }

    /**
     * Update basic details (name, model, price, quantity) for a single product inline.
     */
    public function updateRow(UpdateProductRowRequest $request): JsonResponse
    {
        $product = $this->advancedProductService->updateRow(
            (int) $request->input('id'),
            $request->validated()
        );

        return ApiResponse::success($product, 'Product updated successfully');
    }

    /**
     * Update product description SEO details inline.
     */
    public function updateDescription(UpdateProductDescriptionRequest $request): JsonResponse
    {
        $product = $this->advancedProductService->updateDescription(
            (int) $request->input('product_id'),
            $request->validated()
        );

        return ApiResponse::success($product, 'Product SEO details updated successfully');
    }

    /**
     * Apply categories to multiple selected products.
     */
    public function bulkUpdateCategories(BulkUpdateCategoriesRequest $request): JsonResponse
    {
        try {
            $this->advancedProductService->bulkUpdateCategories(
                $request->input('product_ids'),
                $request->input('category_ids')
            );

            return ApiResponse::success(null, 'Bulk categories updated successfully');
        } catch (Exception $e) {
            Log::error('Bulk Categories Update Failed: ' . $e->getMessage());
            return ApiResponse::error('Failed to update bulk categories', 500, [$e->getMessage()]);
        }
    }

    /**
     * Apply options to multiple selected products.
     */
    public function bulkUpdateOptions(BulkUpdateOptionsRequest $request): JsonResponse
    {
        try {
            $this->advancedProductService->bulkUpdateOptions(
                $request->input('product_ids'),
                $request->input('options')
            );

            return ApiResponse::success(null, 'Bulk options updated successfully');
        } catch (Exception $e) {
            Log::error('Bulk Options Update Failed: ' . $e->getMessage());
            return ApiResponse::error('Failed to update bulk options', 500, [$e->getMessage()]);
        }
    }

    /**
     * Apply filter options to multiple selected products.
     */
    public function bulkUpdateFilterOptions(BulkUpdateFilterOptionsRequest $request): JsonResponse
    {
        try {
            $this->advancedProductService->bulkUpdateFilterOptions(
                $request->input('product_ids'),
                $request->input('filter_options')
            );

            return ApiResponse::success(null, 'Bulk filter options updated successfully');
        } catch (Exception $e) {
            Log::error('Bulk Filter Options Update Failed: ' . $e->getMessage());
            return ApiResponse::error('Failed to update bulk filter options', 500, [$e->getMessage()]);
        }
    }

    /**
     * Apply attributes to multiple selected products.
     */
    public function bulkUpdateAttributes(BulkUpdateAttributesRequest $request): JsonResponse
    {
        try {
            $this->advancedProductService->bulkUpdateAttributes(
                $request->input('product_ids'),
                $request->input('attributes')
            );

            return ApiResponse::success(null, 'Bulk attributes updated successfully');
        } catch (Exception $e) {
            Log::error('Bulk Attributes Update Failed: ' . $e->getMessage());
            return ApiResponse::error('Failed to update bulk attributes', 500, [$e->getMessage()]);
        }
    }

    /**
     * Toggle status or featured flags for selected products in bulk.
     */
    public function bulkUpdateStatus(BulkUpdateStatusRequest $request): JsonResponse
    {
        try {
            $this->advancedProductService->bulkUpdateStatus(
                $request->input('product_ids'),
                $request->input('field'),
                $request->input('value')
            );

            return ApiResponse::success(null, 'Bulk status updated successfully');
        } catch (Exception $e) {
            Log::error('Bulk Status Update Failed: ' . $e->getMessage());
            return ApiResponse::error('Failed to update bulk status', 500, [$e->getMessage()]);
        }
    }
}
