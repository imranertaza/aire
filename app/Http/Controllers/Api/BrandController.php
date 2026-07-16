<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    /**
     * Retrieve a paginated list of brands with optional search.
     */
    public function index(Request $request)
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
    public function allBrands()
    {
        $brands = Brand::select('id', 'name')->where('status', 1)->orderBy('sort_order', 'asc')->get();
        return ApiResponse::success($brands, 'All active brands retrieved successfully');
    }

    /**
     * Retrieve a single brand.
     */
    public function show(Brand $brand)
    {
        return ApiResponse::success($brand, 'Brand retrieved successfully');
    }

    /**
     * Store a new brand.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'alt_name'   => 'nullable|string|max:255',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'status'     => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['alt_name'] = $request->input('alt_name') ?: $request->input('name');
        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();

        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }

        // Create brand first (without image)
        $brand = Brand::create($validated);

        // Handle file upload if present
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('brand_') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs("brands/{$brand->id}", $filename, 'public');

            $fullPath = Storage::disk('public')->path($path);
            Image::make($fullPath)->fit(250, 150)->save();

            $brand->update(['image' => $path]);
        }

        return ApiResponse::success($brand, 'Brand created successfully');
    }

    /**
     * Update an existing brand.
     */
    public function update(Request $request, Brand $brand)
    {

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'alt_name'   => 'nullable|string|max:255',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'status'     => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->remove_image == 1) {
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }
            $validated['image'] = null;
        }

        $validated['alt_name'] = $request->input('alt_name') ?: $request->input('name');
        $validated['updatedBy'] = Auth::id();

        if ($request->hasFile('image')) {
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }

            $file = $request->file('image');
            $filename = uniqid('brand_') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs("brands/{$brand->id}", $filename, 'public');

            $fullPath = Storage::disk('public')->path($path);
            Image::make($fullPath)->fit(250, 150)->save();

            $validated['image'] = $path;
        }

        $brand->update($validated);

        return ApiResponse::success($brand, 'Brand updated successfully');
    }

    /**
     * Toggle the status (active/inactive) of a brand.
     */
    public function toggleStatus(Brand $brand)
    {
        $brand->status = $brand->status == 1 ? 0 : 1;
        $brand->updatedBy = Auth::id();
        $brand->save();

        return ApiResponse::success([
            'status' => $brand->status,
        ], $brand->status == 1 ? 'Brand active' : 'Brand inactive');
    }

    /**
     * Permanently delete a brand along with its associated image.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->image && Storage::disk('public')->exists($brand->image)) {
            Storage::disk('public')->delete($brand->image);
        }

        Product::where('brand_id', $brand->id)->update(['brand_id' => null]);

        $brand->delete();

        return ApiResponse::success(null, 'Brand deleted successfully');
    }
}
