<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\Common\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * PageController constructor.
     *
     * @param FileUploadService $fileUploader
     */
    public function __construct(
        protected FileUploadService $fileUploader
    ) {}
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
        $query = Page::latest('id');

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
            'status'           => ['required', 'in:0,1'],
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

        // Handle image upload with common FileUploadService
        if ($request->hasFile('f_image')) {
            $path = $this->fileUploader->upload(
                file: $request->file('f_image'),
                directory: "pages/{$page->id}"
            );
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
            'status'           => ['required', 'in:0,1'],
        ], [
            'f_image.image' => 'Please upload a valid image file.',
            'f_image.mimes' => 'We only support JPG, JPEG, PNG, and GIF formats.',
            'f_image.max'   => 'That file is too big! Keep it under 2MB.',
        ]);

        if ($request->input('remove_f_image') == 1 && !$request->hasFile('f_image')) {
            $this->fileUploader->delete($page->f_image);
            $validated['f_image'] = null;
        }

        if ($request->hasFile('f_image')) {
            $validated['f_image'] = $this->fileUploader->replace(
                newFile: $request->file('f_image'),
                directory: "pages/{$page->id}",
                oldPath: $page->f_image
            );
        }

        $page->update($validated);
        return response()->json(['message' => 'Page updated successfully', 'data' => $page], 200);
    }

    /**
     * Toggle the active/inactive status of a page.
     *
     * Finds a page by slug and switches its status between 1 (Active) and 0 (Inactive).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function toggleStatus(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        if ($request->has('status')) {
            $page->status = (int) $request->input('status') === 1 ? 1 : 0;
        } else {
            $page->status = (int) $page->status === 1 ? 0 : 1;
        }
        $page->save();

        return response()->json([
            'message' => $page->status === 1 ? 'Page activated' : 'Page deactivated',
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

        $this->fileUploader->delete($page->f_image);

        $page->delete();
        return ApiResponse::success($page, 'Page deleted successfully');
    }
}
