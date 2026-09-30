<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Services\Common\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BrandController extends Controller
{
    /**
     * BrandController constructor.
     *
     * @param FileUploadService $fileUploader
     */
    public function __construct(
        protected FileUploadService $fileUploader
    ) {}

    /**
     * Retrieve a paginated list of brands with optional search.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Brand::orderBy('sort_order', 'asc')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('alt_name', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $brands = $query->paginate($perPage);

        return ApiResponse::success($brands, 'Brands retrieved successfully');
    }

    /**
     * Retrieve all active brands for dropdown.
     */
    public function allBrands(): JsonResponse
    {
        $brands = Cache::rememberForever('all_brands', function () {
            return Brand::select('id', 'name')->where('status', 1)->orderBy('sort_order', 'asc')->get();
        });

        return ApiResponse::success($brands, 'All active brands retrieved successfully');
    }

    /**
     * Retrieve a single brand.
     */
    public function show(Brand $brand): JsonResponse
    {
        return ApiResponse::success($brand, 'Brand retrieved successfully');
    }

    /**
     * Store a new brand.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'alt_name'   => 'nullable|string|max:255',
            'image'      => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'status'     => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['alt_name'] = $request->input('alt_name') ?: $request->input('name');
        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Create brand first (without image)
        $brand = Brand::create($validated);

        // Handle file upload with common FileUploadService
        if ($request->hasFile('image')) {
            $path = $this->fileUploader->uploadAndFit(
                file: $request->file('image'),
                directory: "brands/{$brand->id}",
                width: 250,
                height: 150
            );
            $brand->update(['image' => $path]);
        }

        Cache::forget('all_brands');

        return ApiResponse::success($brand, 'Brand created successfully');
    }

    /**
     * Update an existing brand.
     */
    public function update(Request $request, Brand $brand): JsonResponse
    {
        $isImageRequired = empty($brand->image) || $request->remove_image == 1;

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'alt_name'   => 'nullable|string|max:255',
            'image'      => $isImageRequired ? 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096' : 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'status'     => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['alt_name'] = $request->input('alt_name') ?: $request->input('name');
        $validated['updatedBy'] = Auth::id();

        if ($request->remove_image == 1 && !$request->hasFile('image')) {
            $this->fileUploader->delete($brand->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->fileUploader->replaceAndFit(
                newFile: $request->file('image'),
                directory: "brands/{$brand->id}",
                width: 250,
                height: 150,
                oldPath: $brand->image
            );
        }

        $brand->update($validated);
        Cache::forget('all_brands');

        return ApiResponse::success($brand, 'Brand updated successfully');
    }

    /**
     * Toggle the status (active/inactive) of a brand.
     */
    public function toggleStatus(Brand $brand): JsonResponse
    {
        $brand->status = (int) $brand->status === 1 ? 0 : 1;
        $brand->updatedBy = Auth::id();
        $brand->save();
        Cache::forget('all_brands');

        return ApiResponse::success([
            'status' => $brand->status,
        ], $brand->status == 1 ? 'Brand active' : 'Brand inactive');
    }

    /**
     * Permanently delete a brand along with its associated image.
     */
    public function destroy(Brand $brand): JsonResponse
    {
        $this->fileUploader->delete($brand->image);

        Product::where('brand_id', $brand->id)->update(['brand_id' => null]);

        $brand->delete();
        Cache::forget('all_brands');

        return ApiResponse::success(null, 'Brand deleted successfully');
    }
}

