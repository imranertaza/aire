<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * API Controller for managing news categories.
 *
 * Provides CRUD operations, status updates, and hierarchical listing of news categories
 * (supports parent-child relationships).
 */
class NewsCategoryController extends Controller
{
    /**
     * Retrieve a list of news categories.
     *
     * Supports optional search, pagination, and different modes:
     * - ?all=1 : Return all categories with children (hierarchical)
     * - ?per_page=0 : Return only top-level categories (id + category_name)
     * - Default: Paginated list with children
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $all = $request->query('all', false);
        $search = $request->query('search');

        $query = NewsCategory::with(['children'])->orderBy('sort_order');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('category_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($all) {
            $categories = $query->get();
        } else {
            $perPage = $request->query('per_page', 10);
            if ($perPage > 0) {
                $categories = $query->paginate($perPage)->onEachSide(1);
            } else {
                $categories = $query->select(['id', 'category_name'])->where('parent_id', null)->get();
            }
        }

        return ApiResponse::success($categories, 'Categories fetched successfully');
    }

    /**
     * Retrieve a single news category with its parent and children relationships.
     *
     * @param NewsCategory $category The category model instance (resolved via route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(NewsCategory $category)
    {
        $category->load(['children.parent', 'parent']);
        return ApiResponse::success($category, 'Category fetched successfully');
    }

    /**
     * Create a new news category.
     *
     * Automatically generates a slug from the category name.
     * Handles optional image upload and assigns the authenticated user as creator.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id'        => 'nullable|exists:news_categories,id',
            'category_name'    => 'required|string|max:255',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'alt_name'         => 'nullable|string|max:255',
            'sort_order'       => 'integer',
            'status'           => 'in:0,1',
        ]);

        $validated['slug'] = Str::slug($validated['category_name']);
        $validated['createdBy'] = Auth::id();

        // Create category first (without image)
        $category = NewsCategory::create($validated);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $filename = uniqid('cat_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            // Store in: storage/app/public/news/category/{id}/file.ext
            $path = $request->file('image')
                ->storeAs("news/category/{$category->id}", $filename, 'public');

            $category->update(['image' => $path]);
        }

        return ApiResponse::success($category, 'Category created successfully');
    }

    /**
     * Update an existing news category.
     *
     * Replaces image if a new one is uploaded (deletes old image).
     * Preserves existing image if none is provided.
     *
     * @param Request $request
     * @param NewsCategory $category The category model instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, NewsCategory $category)
    {
        $validated = $request->validate([
            'parent_id'        => 'nullable|exists:news_categories,id',
            'category_name'    => 'required|string|max:255',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'alt_name'         => 'nullable|string|max:255',
            'sort_order'       => 'integer',
            'status'           => 'in:0,1',
        ]);
        if ($request->remove_f_image == 1) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = null;
        } else {
            // Keep existing image if no new file uploaded
            $validated['image'] = $category->image;
        }
        // dd($request->all());
        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            // Build a unique filename
            $filename = uniqid('cat_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')
                ->storeAs("news/category/{$category->id}", $filename, 'public');

            $validated['image'] = $path;
        }

        $validated['updatedBy'] = Auth::id();

        $category->update($validated);

        return ApiResponse::success($category, 'Category updated successfully');
    }


    /**
     * Update only the status (active/inactive) of a news category.
     *
     * @param Request $request
     * @param NewsCategory $category The category model instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, NewsCategory $category)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $category->status = (string)$request->input('status');
        $category->save();

        return ApiResponse::success($category, 'Category status updated successfully');
    }

    /**
     * Permanently delete a news category and its associated image (if any).
     *
     * @param NewsCategory $category The category model instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(NewsCategory $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return ApiResponse::success(null, 'Category deleted successfully');
    }
}
