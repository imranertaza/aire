<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * API Controller for managing blog categories.
 *
 * Provides CRUD operations, status updates, and hierarchical listing of blog categories
 * (supports parent-child relationships).
 */
class BlogCategoryController extends Controller
{
    /**
     * Retrieve a list of blog categories.
     *
     * Supports optional search, pagination, and different modes:
     * - ?all=1 : Return all categories with children (hierarchical tree)
     * - ?per_page=0 : Return only top-level categories (id + category_name only)
     * - Default: Paginated list with children
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $all = $request->query('all', false);
        $search = $request->query('search');

        $query = BlogCategory::with(['children'])->orderBy('sort_order');

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

        return ApiResponse::success($categories, 'Blog categories fetched successfully');
    }

    /**
     * Retrieve a single blog category with its parent and children relationships.
     *
     * @param BlogCategory $category The category model instance (resolved via route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BlogCategory $category)
    {
        $category->load(['children.parent', 'parent']);
        return ApiResponse::success($category, 'Blog category fetched successfully');
    }

    /**
     * Create a new blog category.
     *
     * Handles optional image upload and assigns the authenticated user as creator.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id'        => 'nullable|exists:blog_categories,id',
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

        $validated['createdBy'] = Auth::id();
        $baseSlug = Str::slug($validated['category_name']);
        $slug = $baseSlug;
        $counter = 1;

        while (DB::table('blog_categories')->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;
        // Create category first (without image)
        $category = BlogCategory::create($validated);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $filename = uniqid('cat_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')
                ->storeAs("blogs/category/{$category->id}", $filename, 'public');

            $category->update(['image' => $path]);
        }

        return ApiResponse::success($category, 'Blog category created successfully');
    }

    /**
     * Update an existing blog category.
     *
     * Replaces the image only if a new one is uploaded (deletes the old image).
     * Preserves the existing image if no new file is provided.
     *
     * @param Request $request
     * @param BlogCategory $category The category model instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BlogCategory $category)
    {
        $validated = $request->validate([
            'parent_id'        => 'nullable|exists:blog_categories,id',
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

        if ($request->remove_image == 1) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = null;
        } else {
            // Keep existing image if no new file uploaded
            $validated['image'] = $category->image;
        }

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $filename = uniqid('cat_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')
                ->storeAs("blogs/category/{$category->id}", $filename, 'public');

            $validated['image'] = $path;
        }

        $validated['updatedBy'] = Auth::id();

        $category->update($validated);

        return ApiResponse::success($category, 'Blog category updated successfully');
    }


    /**
     * Update only the status (active/inactive) of a blog category.
     *
     * @param Request $request
     * @param BlogCategory $category The category model instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, BlogCategory $category)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $category->status = (string)$request->input('status');
        $category->save();

        return ApiResponse::success($category, 'Blog category status updated successfully');
    }

    /**
     * Permanently delete a blog category and its associated image (if any).
     *
     * @param BlogCategory $category The category model instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BlogCategory $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return ApiResponse::success(null, 'Blog category deleted successfully');
    }
}
