<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * Display a listing of pages with optional search and pagination.
     *
     * Applies search filters if provided in the request. If 'all' is set,
     * returns a lightweight list of pages (id + title). Otherwise, paginates results.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Page::latest();

        // Apply search if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('page_title', 'like', "%{$search}%")
                    ->orWhere('short_des', 'like', "%{$search}%")
                    ->orWhere('meta_title', 'like', "%{$search}%")
                    ->orWhere('meta_description', 'like', "%{$search}%")
                    ->orWhere('meta_keyword', 'like', "%{$search}%");
            });
        }

        if ($request->filled('all')) {
            $pages = $query->select(['id', 'page_title'])->get();
        } else {
            $pages = $query->paginate(10);
        }

        return ApiResponse::success($pages, 'Pages retrieved successfully');
    }

    /**
     * Display a single page by slug.
     *
     * Retrieves a page record using its unique slug. Throws a 404 if not found.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return ApiResponse::success($page, 'Page retrieved successfully');
    }

    /**
     * Store a newly created page in storage.
     *
     * Validates request data, handles image upload, and creates a new page record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_title'       => 'required|string|max:255',
            'breadcrumb'       => 'required|string|max:255',
            'slug'             => 'required|string|unique:pages,slug|max:300',
            'short_des'        => 'nullable|string|max:255',
            'page_description' => 'nullable|string',
            'temp'             => 'nullable|string|max:255',
            'f_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'status'           => ['required', Rule::in(['Active', 'Inactive'])],
            'createdBy'        => 'nullable|integer',
            'updatedBy'        => 'nullable|integer',
        ], [
            'f_image.image' => 'Please upload a valid image file.',
            'f_image.mimes' => 'We only support JPG, JPEG, PNG, WEBP, and GIF formats.',
            'f_image.max'   => 'That file is too big! Keep it under 2MB.',
        ]);

        $validated['createdBy'] = Auth::user()->id;
        $validated['updatedBy'] = Auth::user()->id;

        $page = Page::create($validated);

        // Handle image upload after page is created (so we have ID)
        if ($request->hasFile('f_image')) {
            $filename = uniqid('image_') . '.' . $request->file('f_image')->getClientOriginalExtension();
            $path = $request->file('f_image')->storeAs("pages/{$page->id}", $filename, 'public');
            $page->update(['f_image' => $path]);
        }

        return response()->json(['message' => 'Page created successfully', 'data' => $page], 201);
    }

    /**
     * Update the specified page in storage.
     *
     * Validates request data, updates the page record, and replaces the image if provided.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $validated = $request->validate([
            'page_title'       => 'required|string|max:255',
            'breadcrumb'       => 'required|string|max:255',
            'slug'             => ['required', 'string', 'max:300', Rule::unique('pages', 'slug')->ignore($page->id)],
            'short_des'        => 'nullable|string|max:255',
            'page_description' => 'nullable|string',
            'temp'             => 'nullable|string|max:255',
            'f_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'remove_f_image'   => 'nullable|numeric',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'status'           => ['required', Rule::in(['Active', 'Inactive'])],
        ], [
            'f_image.image' => 'Please upload a valid image file.',
            'f_image.mimes' => 'We only support JPG, JPEG, PNG, and GIF formats.',
            'f_image.max'   => 'That file is too big! Keep it under 2MB.',
        ]);

        if ($request->hasFile('f_image')) {
            if ($page->f_image && Storage::disk('public')->exists($page->f_image)) {
                Storage::disk('public')->delete($page->f_image);
            }

            $filename = uniqid('image_') . '.' . $request->file('f_image')->getClientOriginalExtension();
            $validated['f_image'] = $request->file('f_image')->storeAs("pages/{$page->id}", $filename, 'public');
        } elseif ($request->input('remove_f_image') == 1) {
            if ($page->f_image && Storage::disk('public')->exists($page->f_image)) {
                Storage::disk('public')->delete($page->f_image);
            }
            $validated['f_image'] = null;
        }

        $page->update($validated);
        return response()->json(['message' => 'Page updated successfully', 'data' => $page], 200);
    }

    /**
     * Toggle the active/inactive status of a page.
     *
     * Finds a page by slug and switches its status between 'Active' and 'Inactive'.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $page = Page::findOrFail($id);
        $page->status = $page->status === 'Active' ? 'Inactive' : 'Active';
        $page->save();

        return response()->json([
            'message' => $page->status === 'Active' ? 'Page activated' : 'Page deactivated',
            'status'  => $page->status,
        ]);
    }

    /**
     * Remove the specified page from storage.
     *
     * Deletes the page record and its associated image file if present.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);

        if ($page->f_image && Storage::disk('public')->exists($page->f_image)) {
            Storage::disk('public')->delete($page->f_image);
        }

        $page->delete();
        return ApiResponse::success($page, 'Page deleted successfully');
    }
}
