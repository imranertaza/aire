<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductCategoryController extends Controller
{
    /**
     * Retrieve a paginated list of product categories with optional search.
     */
    public function index(Request $request)
    {
        $query = ProductCategory::with('parent')->orderBy('sort_order', 'asc')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('category_name', 'like', "%{$search}%")
                    ->orWhere('alt_name', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $categories = $query->paginate($perPage);

        return ApiResponse::success($categories, 'Categories retrieved successfully');
    }

    /**
     * Retrieve all categories for dropdown (id and name only).
     */
    public function allCategories()
    {
        $categories = Cache::rememberForever('all_categories', function () {
            return ProductCategory::select('id', 'category_name', 'parent_id', 'bg_color')->get();
        });
        return ApiResponse::success($categories, 'All categories retrieved successfully');
    }

    /**
     * Retrieve a single category.
     */
    public function show($id)
    {
        $category = ProductCategory::with(['parent', 'categoryFeaturedProducts.product'])->findOrFail($id);
        $data = $category->toArray();
        $data['featured_top_product_ids'] = $category->categoryFeaturedProducts
            ->where('position', 'top')
            ->pluck('product_id')
            ->values()
            ->toArray();
        $data['featured_middle_product_ids'] = $category->categoryFeaturedProducts
            ->where('position', 'middle')
            ->pluck('product_id')
            ->values()
            ->toArray();
        $data['featured_bottom_product_ids'] = $category->categoryFeaturedProducts
            ->where('position', 'bottom')
            ->pluck('product_id')
            ->values()
            ->toArray();

        $data['featured_top_product_id'] = $data['featured_top_product_ids'][0] ?? null;
        $data['featured_middle_product_id'] = $data['featured_middle_product_ids'][0] ?? null;
        $data['featured_bottom_product_id'] = $data['featured_bottom_product_ids'][0] ?? null;

        return ApiResponse::success($data, 'Category retrieved successfully');
    }

    /**
     * Sync category featured top, middle & bottom products.
     */
    protected function syncFeaturedProducts(ProductCategory $category, Request $request)
    {
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE category_featured_products MODIFY COLUMN position VARCHAR(20) NOT NULL DEFAULT 'top'");
        } catch (\Throwable $e) {
            // Ignore if already modified or locked
        }

        \App\Models\CategoryFeaturedProduct::where('category_id', $category->id)->delete();

        // Top product
        $topId = $request->input('featured_top_product_id');
        $topIds = [];
        if (!is_null($topId) && $topId !== '' && $topId !== 'null') {
            $topIds = [$topId];
        } else {
            $rawTop = $request->input('featured_top_product_ids');
            if (is_string($rawTop)) $rawTop = json_decode($rawTop, true);
            if (is_array($rawTop)) $topIds = $rawTop;
        }

        foreach ($topIds as $index => $pid) {
            if (!empty($pid)) {
                \App\Models\CategoryFeaturedProduct::create([
                    'category_id' => $category->id,
                    'product_id'  => (int) $pid,
                    'position'    => 'top',
                    'sort_order'  => $index,
                ]);
            }
        }

        // Middle product
        $midId = $request->input('featured_middle_product_id');
        $midIds = [];
        if (!is_null($midId) && $midId !== '' && $midId !== 'null') {
            $midIds = [$midId];
        } else {
            $rawMid = $request->input('featured_middle_product_ids');
            if (is_string($rawMid)) $rawMid = json_decode($rawMid, true);
            if (is_array($rawMid)) $midIds = $rawMid;
        }

        foreach ($midIds as $index => $pid) {
            if (!empty($pid)) {
                \App\Models\CategoryFeaturedProduct::create([
                    'category_id' => $category->id,
                    'product_id'  => (int) $pid,
                    'position'    => 'middle',
                    'sort_order'  => $index,
                ]);
            }
        }

        // Bottom product
        $botId = $request->input('featured_bottom_product_id');
        $bottomIds = [];
        if (!is_null($botId) && $botId !== '' && $botId !== 'null') {
            $bottomIds = [$botId];
        } else {
            $rawBot = $request->input('featured_bottom_product_ids');
            if (is_string($rawBot)) $rawBot = json_decode($rawBot, true);
            if (is_array($rawBot)) $bottomIds = $rawBot;
        }

        foreach ($bottomIds as $index => $pid) {
            if (!empty($pid)) {
                \App\Models\CategoryFeaturedProduct::create([
                    'category_id' => $category->id,
                    'product_id'  => (int) $pid,
                    'position'    => 'bottom',
                    'sort_order'  => $index,
                ]);
            }
        }
    }



    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name'    => 'required|string|max:155',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'icon_class'       => 'nullable|string',
            'icon_id'          => 'nullable|integer|exists:icons,id',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'alt_name'         => 'nullable|string|max:255',
            'bg_color'         => 'nullable|string|max:50',
            'header_menu'      => 'nullable|in:0,1,true,false',
            'side_menu'        => 'nullable|in:0,1,true,false',
            'sort_order'       => 'nullable|integer|min:0',
            'status'           => 'required|in:0,1,true,false',
            'parent_id'        => 'nullable|exists:product_categories,id',
            'features'         => 'nullable',
        ]);

        if ($request->has('features')) {
            $features = $request->input('features');
            if (is_string($features)) {
                $features = json_decode($features, true);
            }
            $validated['features'] = is_array($features) ? array_values($features) : null;
        }

        $validated['alt_name'] = $request->input('alt_name') ?: $request->input('category_name');
        $validated['bg_color'] = $request->input('bg_color') ?: '#00c853';
        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();

        // Convert booleans to tinyInt
        $validated['status'] = filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $validated['header_menu'] = filter_var($validated['header_menu'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $validated['side_menu'] = filter_var($validated['side_menu'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }

        // Create category first
        $category = ProductCategory::create($validated);

        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('prodcat_') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs("product-categories/{$category->id}", $filename, 'public');

            $fullPath = Storage::disk('public')->path($path);
            Image::make($fullPath)->fit(250, 150)->save();

            $category->update(['image' => $path]);
        }

        $this->syncFeaturedProducts($category, $request);

        return ApiResponse::success($category, 'Category created successfully');
    }

    /**
     * Update an existing category.
     */
    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $validated = $request->validate([
            'category_name'    => 'required|string|max:155',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'icon_class'       => 'nullable|string',
            'icon_id'          => 'nullable|integer|exists:icons,id',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'alt_name'         => 'nullable|string|max:255',
            'bg_color'         => 'nullable|string|max:50',
            'header_menu'      => 'nullable|in:0,1,true,false',
            'side_menu'        => 'nullable|in:0,1,true,false',
            'sort_order'       => 'nullable|integer|min:0',
            'status'           => 'required|in:0,1,true,false',
            'parent_id'        => 'nullable|exists:product_categories,id',
            'features'         => 'nullable',
        ]);

        if ($request->has('features')) {
            $features = $request->input('features');
            if (is_string($features)) {
                $features = json_decode($features, true);
            }
            $validated['features'] = is_array($features) ? array_values($features) : null;
        }

        if ($request->remove_image == 1) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = null;
        }

        $validated['alt_name'] = $request->input('alt_name') ?: $request->input('category_name');
        if ($request->has('bg_color')) {
            $validated['bg_color'] = $request->input('bg_color') ?: '#00c853';
        }
        $validated['updatedBy'] = Auth::id();

        // Convert booleans
        $validated['status'] = filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $validated['header_menu'] = filter_var($validated['header_menu'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $validated['side_menu'] = filter_var($validated['side_menu'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        // Prevent setting itself as parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $category->id) {
            $validated['parent_id'] = null;
        }

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $file = $request->file('image');
            $filename = uniqid('prodcat_') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs("product-categories/{$category->id}", $filename, 'public');

            $fullPath = Storage::disk('public')->path($path);
            Image::make($fullPath)->fit(250, 150)->save();

            $validated['image'] = $path;
        }

        $category->update($validated);

        $this->syncFeaturedProducts($category, $request);

        return ApiResponse::success($category, 'Category updated successfully');
    }

    /**
     * Toggle the status (active/inactive).
     */
    public function toggleStatus($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->status = $category->status == 1 ? 0 : 1;
        $category->updatedBy = Auth::id();
        $category->save();

        return ApiResponse::success([
            'status' => $category->status,
        ], $category->status == 1 ? 'Category active' : 'Category inactive');
    }

    /**
     * Delete a category.
     */
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        // Parent_id cascade is handled by DB foreign key constraint 'onDelete(cascade)'.

        $category->delete();

        return ApiResponse::success(null, 'Category deleted successfully');
    }
}
