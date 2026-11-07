<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\BulkProductActionRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Admin\ProductManagementService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductManagementService $productService
    ) {}

    /**
     * Retrieve list of products for dropdown search.
     */
    public function dropdownList(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $limit = $request->query('limit', ($categoryId || $request->has('all')) ? null : 500);

        $products = $this->productService->dropdownList($search, $categoryId ? (int) $categoryId : null, $limit ? (int) $limit : null);

        return ApiResponse::success($products, 'Products list retrieved successfully');
    }

    /**
     * Retrieve a paginated list of products.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 10);
        $filters = $request->only('search', 'level1_id', 'level2_id', 'level3_id', 'category_id');
        $products = $this->productService->listProducts($filters, $perPage);

        return ApiResponse::success($products, 'Products retrieved successfully');
    }

    /**
     * Store a new product.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productService->createProduct($request->validated(), $request);

            return ApiResponse::success($product, 'Product created successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to create product', 500, [$e->getMessage()]);
        }
    }

    /**
     * Retrieve a single product.
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->productService->getProductWithRelations($id);

        return ApiResponse::success($product, 'Product retrieved successfully');
    }

    /**
     * Update an existing product.
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);
            $updatedProduct = $this->productService->updateProduct($product, $request->validated(), $request);

            return ApiResponse::success($updatedProduct, 'Product updated successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to update product', 500, [$e->getMessage()]);
        }
    }

    /**
     * Bulk update product status.
     */
    public function bulkStatus(BulkProductActionRequest $request): JsonResponse
    {
        $this->productService->bulkUpdateStatus(
            $request->validated('product_ids'),
            (int) $request->validated('status')
        );

        return ApiResponse::success(null, 'Status updated successfully for selected products');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(BulkProductActionRequest $request): JsonResponse
    {
        $this->productService->bulkDelete($request->validated('product_ids'));

        return ApiResponse::success(null, 'Selected products deleted successfully');
    }

    /**
     * Copy / duplicate products.
     */
    public function copy(BulkProductActionRequest $request): JsonResponse
    {
        try {
            $this->productService->copyProducts($request->validated('product_ids'));

            return ApiResponse::success(null, 'Products copied successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to copy products', 500, [$e->getMessage()]);
        }
    }

    /**
     * Toggle the status (active/inactive).
     */
    public function toggleStatus(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $newStatus = $this->productService->toggleStatus($product);

        return ApiResponse::success([
            'status' => $newStatus,
        ], $newStatus === 1 ? 'Product active' : 'Product inactive');
    }

    /**
     * Delete a single product.
     */
    public function destroy(int $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $this->productService->deleteProduct($product);
        ProductCategory::clearCategoryCache();
        return ApiResponse::success(null, 'Product deleted successfully');
    }
}
