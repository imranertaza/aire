<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with optional search and pagination.
     *
     * If 'all' is provided, returns all categories. Otherwise, paginates results.
     * Supports search by category_name and description.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $all = $request->query('all', false);
        $search = $request->query('search');

        $query = Category::with(['children', 'parent'])->orderBy('sort_order');

        // Apply search if provided
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
     * Display a single category.
     *
     * Loads the category along with its parent and children relationships.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        $category->load(['children.parent', 'parent']);
        return ApiResponse::success($category, 'Category fetched successfully');
    }

    /**
     * Store a newly created category in storage.
     *
     * Validates request data, handles image upload, and creates a new category record.
     * Generates a slug automatically from the category name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id'        => 'nullable|exists:categories,id',
            'category_name'    => 'required|string|max:255',
            'breadcrumb'       => 'required|string|max:255',
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

        // Handle image upload if present

        $validated['createdBy'] = Auth::id();

        $category = Category::create($validated);
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $filename = uniqid('cat_image_') . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs("posts/category/{$category->id}", $filename, 'public');
            $category->update(['image' => $path]);
        }

        return ApiResponse::success($category, 'Category created successfully');
    }

    /**
     * Update the specified category in storage.
     *
     * Validates request data, updates the category record, and replaces the image if provided.
     * Deletes the old image file before saving the new one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'parent_id'        => 'nullable|exists:categories,id',
            'category_name'    => 'required|string|max:255',
            'breadcrumb'    => 'required|string|max:255',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'alt_name'         => 'nullable|string|max:255',
            'remove_f_image'   => 'nullable|numeric|in:1,0',
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

            // Build a unique filename
            $filename = uniqid('cat_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')
                ->storeAs("posts/category/{$category->id}", $filename, 'public');

            $validated['image'] = $path;
        }


        $validated['updatedBy'] = Auth::id();
        $category->update($validated);

        return ApiResponse::success($category, 'Category updated successfully');
    }

    /**
     * Update the status of a category.
     *
     * Validates the status input and updates the category's status field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request, Category $category)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);
        $category->status = (string)$request->input('status');
        $category->save();

        return ApiResponse::success($category, 'Category status updated successfully');
    }

    /**
     * Remove the specified category from storage.
     *
     * Deletes the category record and its associated image file if present.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        // Delete image file if it exists
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return ApiResponse::success(null, 'Category deleted successfully');
    }
}
