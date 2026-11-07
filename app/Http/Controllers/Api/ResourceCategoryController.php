<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ResourceCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ResourceCategoryController extends Controller
{
    /**
     * Display a listing of the resource categories.
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $all = $request->boolean('all', false);

        $query = ResourceCategory::query()
            ->withCount('resources')
            ->orderBy('sort_order', 'asc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('layout_type') && $request->filled('layout_type')) {
            $query->where('layout_type', $request->query('layout_type'));
        }

        if ($request->has('status') && $request->input('status') !== null && $request->input('status') !== '') {
            $query->where('status', (int) $request->input('status'));
        }

        if ($all) {
            $categories = $query->get();
        } else {
            $categories = $query->paginate($request->integer('per_page', 15));
        }

        return ApiResponse::success($categories, 'Resource categories retrieved successfully.');
    }

    /**
     * Store a newly created resource category in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if (empty($request->input('slug')) && !empty($request->input('name'))) {
            $request->merge(['slug' => Str::slug($request->input('name'))]);
        }

        $validated = $request->validate([
            'name'               => ['required', 'string', 'min:2', 'max:255'],
            'slug'               => ['required', 'string', 'max:255', 'unique:resource_categories,slug'],
            'icon'               => ['nullable', 'string', 'max:100'],
            'short_desc'         => ['nullable', 'string', 'max:255'],
            'description'        => ['nullable', 'string', 'max:5000'],
            'search_placeholder'=> ['nullable', 'string', 'max:255'],
            'meta_title'         => ['nullable', 'string', 'max:255'],
            'meta_description'   => ['nullable', 'string', 'max:2000'],
            'meta_keywords'      => ['nullable', 'string', 'max:255'],
            'layout_type'        => ['required', 'string', 'in:brochure_card,video_card,thumb_card,faq_card'],
            'sort_order'         => ['nullable', 'integer', 'min:0', 'max:999999'],
            'status'             => ['required', 'integer', 'in:0,1'],
        ], [
            'name.required'        => 'Category name is required.',
            'name.min'             => 'Category name must be at least 2 characters.',
            'slug.required'        => 'Slug is required.',
            'slug.unique'          => 'This category slug is already in use.',
            'layout_type.required' => 'Layout type is required.',
            'layout_type.in'       => 'Invalid layout type selected.',
            'status.required'      => 'Category status is required.',
        ]);

        $category = ResourceCategory::create($validated);

        return ApiResponse::success($category, 'Resource category created successfully.', 201);
    }

    /**
     * Display the specified resource category.
     */
    public function show(int $id): JsonResponse
    {
        $category = ResourceCategory::with(['resources'])->find($id);

        if (!$category) {
            return ApiResponse::error('Resource category not found.', 404);
        }

        return ApiResponse::success($category, 'Resource category details retrieved.');
    }

    /**
     * Update the specified resource category in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $category = ResourceCategory::find($id);

        if (!$category) {
            return ApiResponse::error('Resource category not found.', 404);
        }

        if (empty($request->input('slug')) && !empty($request->input('name'))) {
            $request->merge(['slug' => Str::slug($request->input('name'))]);
        }

        $validated = $request->validate([
            'name'               => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'slug'               => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('resource_categories', 'slug')->ignore($category->id),
            ],
            'icon'               => ['nullable', 'string', 'max:100'],
            'short_desc'         => ['nullable', 'string', 'max:255'],
            'description'        => ['nullable', 'string', 'max:5000'],
            'search_placeholder'=> ['nullable', 'string', 'max:255'],
            'meta_title'         => ['nullable', 'string', 'max:255'],
            'meta_description'   => ['nullable', 'string', 'max:2000'],
            'meta_keywords'      => ['nullable', 'string', 'max:255'],
            'layout_type'        => ['sometimes', 'required', 'string', 'in:brochure_card,video_card,thumb_card,faq_card'],
            'sort_order'         => ['nullable', 'integer', 'min:0', 'max:999999'],
            'status'             => ['sometimes', 'required', 'integer', 'in:0,1'],
        ], [
            'name.required'        => 'Category name is required.',
            'name.min'             => 'Category name must be at least 2 characters.',
            'slug.required'        => 'Slug is required.',
            'slug.unique'          => 'This category slug is already in use.',
            'layout_type.required' => 'Layout type is required.',
            'layout_type.in'       => 'Invalid layout type selected.',
            'status.required'      => 'Category status is required.',
        ]);

        $category->update($validated);

        return ApiResponse::success($category, 'Resource category updated successfully.');
    }

    /**
     * Remove the specified resource category from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $category = ResourceCategory::find($id);

        if (!$category) {
            return ApiResponse::error('Resource category not found.', 404);
        }

        $category->delete();

        return ApiResponse::success(null, 'Resource category deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(int $id): JsonResponse
    {
        $category = ResourceCategory::find($id);

        if (!$category) {
            return ApiResponse::error('Resource category not found.', 404);
        }

        $category->status = (int) $category->status === 1 ? 0 : 1;
        $category->save();

        return ApiResponse::success($category, 'Status updated successfully.');
    }
}
