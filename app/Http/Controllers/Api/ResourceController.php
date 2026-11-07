<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Services\Common\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ResourceController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploader
    ) {}

    /**
     * Display a listing of resources.
     */
    public function index(Request $request): JsonResponse
    {
        $categoryId = $request->query('resource_category_id');
        $search = $request->query('search');
        $all = $request->boolean('all', false);

        $query = Resource::query()
            ->with(['category', 'product', 'productCategory'])
            ->orderBy('sort_order', 'asc');

        if (!empty($categoryId)) {
            $query->where('resource_category_id', $categoryId);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('file_path', 'like', "%{$search}%");
            });
        }

        if ($request->has('file_type') && $request->filled('file_type')) {
            $query->where('file_type', $request->query('file_type'));
        }

        if ($request->has('status') && $request->input('status') !== null && $request->input('status') !== '') {
            $query->where('status', (int) $request->input('status'));
        }

        if ($request->has('is_featured') && $request->input('is_featured') !== null && $request->input('is_featured') !== '') {
            $query->where('is_featured', (int) $request->input('is_featured'));
        }

        if ($all) {
            $resources = $query->get();
        } else {
            $resources = $query->paginate($request->integer('per_page', 15));
        }

        return ApiResponse::success($resources, 'Resources retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->input('product_id') === '' || $request->input('product_id') === 'null') {
            $request->merge(['product_id' => null]);
        }
        if ($request->input('product_category_id') === '' || $request->input('product_category_id') === 'null') {
            $request->merge(['product_category_id' => null]);
        }

        if (empty($request->input('slug')) && !empty($request->input('title'))) {
            $request->merge(['slug' => Str::slug($request->input('title'))]);
        }

        if ($request->has('metadata')) {
            $rawMeta = $request->input('metadata');
            if (is_string($rawMeta)) {
                $decoded = json_decode($rawMeta, true);
                $request->merge(['metadata' => is_array($decoded) ? $decoded : []]);
            }
        }

        $validated = $request->validate([
            'resource_category_id' => ['required', 'integer', 'exists:resource_categories,id'],
            'product_id'          => ['nullable', 'integer', 'exists:products,id'],
            'product_category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
            'title'               => ['required', 'string', 'min:2', 'max:255'],
            'slug'                => ['required', 'string', 'max:255', 'unique:resources,slug'],
            'description'         => ['nullable', 'string', 'max:5000'],
            'file_type'           => ['required', 'string', 'in:pdf,video,zip,doc,docx,faq,link,apk,mp4,webm,mov,ogg'],
            'file_path'           => ['nullable', 'string', 'max:500'],
            'file'                => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,zip,rar,7z,tar,gz,mp4,mov,avi,webm,ogg,mkv,apk,xls,xlsx,ppt,pptx,csv',
                'max:512000', // up to 500MB
            ],
            'file_size'           => ['nullable', 'string', 'max:50'],
            'thumbnail'           => ['nullable', 'string', 'max:500'],
            'thumbnail_file'      => ['required_without:thumbnail', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:10240'], // up to 10MB
            'badge_icon'          => ['nullable', 'string', 'max:100'],
            'badge_text'          => ['nullable', 'string', 'max:50'],
            'external_url'        => ['nullable', 'string', 'max:500'],
            'metadata'            => ['nullable', 'array'],
            'sort_order'          => ['nullable', 'integer', 'min:0', 'max:999999'],
            'is_featured'         => ['required', 'integer', 'in:0,1'],
            'status'              => ['required', 'integer', 'in:0,1'],
        ], [
            'resource_category_id.required' => 'Please select a resource category.',
            'resource_category_id.exists'   => 'The selected resource category does not exist.',
            'title.required'                => 'The resource title is required.',
            'title.min'                     => 'The title must be at least 2 characters.',
            'slug.required'                 => 'The slug is required.',
            'slug.unique'                   => 'This slug is already in use by another resource.',
            'file_type.required'            => 'The resource file type is required.',
            'file_type.in'                  => 'Invalid file type selected.',
            'file.mimes'                    => 'The file must be a valid document (PDF, DOC), archive (ZIP), or media file.',
            'file.max'                      => 'The uploaded file must not exceed 500MB.',
            'thumbnail_file.required_without' => 'Thumbnail / Poster image is required.',
            'thumbnail_file.required'         => 'Thumbnail / Poster image is required.',
            'thumbnail_file.image'            => 'The thumbnail must be an image file (JPG, PNG, WEBP, etc.).',
            'thumbnail_file.max'              => 'The thumbnail image must not exceed 10MB.',
            'status.required'               => 'The resource status is required.',
        ]);

        if ($request->has('metadata')) {
            $meta = $request->input('metadata');
            if (is_string($meta)) {
                $meta = json_decode($meta, true);
            }
            $validated['metadata'] = is_array($meta) ? $meta : null;
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $storedPath = $this->fileUploader->upload($file, 'resources/files');
            $validated['file_path'] = 'storage/' . $storedPath;
            $validated['file_size'] = round($file->getSize() / 1024 / 1024, 2) . ' MB';
            if (empty($validated['file_type'])) {
                $validated['file_type'] = strtolower($file->getClientOriginalExtension());
            }
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail_file')) {
            $thumb = $request->file('thumbnail_file');
            $storedThumb = $this->fileUploader->upload($thumb, 'resources/thumbnails');
            $validated['thumbnail'] = 'storage/' . $storedThumb;
        }

        $resource = Resource::create($validated);

        return ApiResponse::success($resource, 'Resource created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $resource = Resource::with(['category', 'product', 'productCategory'])->find($id);

        if (!$resource) {
            return ApiResponse::error('Resource not found.', 404);
        }

        if (empty($resource->slug) && !empty($resource->title)) {
            $resource->slug = Str::slug($resource->title);
            $resource->saveQuietly();
        }

        return ApiResponse::success($resource, 'Resource details retrieved.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return ApiResponse::error('Resource not found.', 404);
        }

        if ($request->input('product_id') === '' || $request->input('product_id') === 'null') {
            $request->merge(['product_id' => null]);
        }
        if ($request->input('product_category_id') === '' || $request->input('product_category_id') === 'null') {
            $request->merge(['product_category_id' => null]);
        }
        if (empty($request->input('slug')) && !empty($request->input('title'))) {
            $request->merge(['slug' => Str::slug($request->input('title'))]);
        }

        if ($request->has('metadata')) {
            $rawMeta = $request->input('metadata');
            if (is_string($rawMeta)) {
                $decoded = json_decode($rawMeta, true);
                $request->merge(['metadata' => is_array($decoded) ? $decoded : []]);
            }
        }

        $validated = $request->validate([
            'resource_category_id' => ['sometimes', 'required', 'integer', 'exists:resource_categories,id'],
            'product_id'          => ['nullable', 'integer', 'exists:products,id'],
            'product_category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
            'title'               => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'slug'                => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('resources', 'slug')->ignore($resource->id),
            ],
            'description'         => ['nullable', 'string', 'max:5000'],
            'file_type'           => ['sometimes', 'required', 'string', 'in:pdf,video,zip,doc,docx,faq,link,apk,mp4,webm,mov,ogg'],
            'file_path'           => ['nullable', 'string', 'max:500'],
            'file'                => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,zip,rar,7z,tar,gz,mp4,mov,avi,webm,ogg,mkv,apk,xls,xlsx,ppt,pptx,csv',
                'max:512000', // up to 500MB
            ],
            'file_size'           => ['nullable', 'string', 'max:50'],
            'thumbnail'           => ['nullable', 'string', 'max:500'],
            'thumbnail_file'      => [
                Rule::requiredIf(fn () => (empty($resource->thumbnail) || $request->input('remove_thumbnail') == 1) && empty($request->input('thumbnail'))),
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp,svg,gif',
                'max:10240',
            ],
            'badge_icon'          => ['nullable', 'string', 'max:100'],
            'badge_text'          => ['nullable', 'string', 'max:50'],
            'external_url'        => ['nullable', 'string', 'max:500'],
            'metadata'            => ['nullable', 'array'],
            'sort_order'          => ['nullable', 'integer', 'min:0', 'max:999999'],
            'remove_thumbnail'    => ['nullable', 'numeric', 'in:0,1'],
            'remove_file'         => ['nullable', 'numeric', 'in:0,1'],
            'is_featured'         => ['sometimes', 'required', 'integer', 'in:0,1'],
            'status'              => ['sometimes', 'required', 'integer', 'in:0,1'],
        ], [
            'resource_category_id.required' => 'Please select a resource category.',
            'resource_category_id.exists'   => 'The selected resource category does not exist.',
            'title.required'                => 'The resource title is required.',
            'title.min'                     => 'The title must be at least 2 characters.',
            'slug.required'                 => 'The slug is required.',
            'slug.unique'                   => 'This slug is already taken. Please specify a unique title or slug.',
            'file_type.required'            => 'The resource file type is required.',
            'file_type.in'                  => 'Invalid file type selected.',
            'file.mimes'                    => 'The file must be a valid document (PDF, DOC), archive (ZIP), or media file.',
            'file.max'                      => 'The uploaded file must not exceed 500MB.',
            'thumbnail_file.required'       => 'Thumbnail / Poster image is required.',
            'thumbnail_file.image'          => 'The thumbnail must be an image file (JPG, PNG, WEBP, etc.).',
            'thumbnail_file.max'            => 'The thumbnail image must not exceed 10MB.',
            'status.required'               => 'The resource status is required.',
        ]);

        if ($request->has('metadata')) {
            $meta = $request->input('metadata');
            if (is_string($meta)) {
                $meta = json_decode($meta, true);
            }
            $validated['metadata'] = is_array($meta) ? $meta : null;
        }

        if (empty($validated['slug']) && !empty($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle file replacement / removal
        if ($request->input('remove_file') == 1 && !$request->hasFile('file')) {
            if ($resource->file_path) {
                $this->fileUploader->delete($resource->file_path);
            }
            $validated['file_path'] = null;
            $validated['file_size'] = null;
        }

        if ($request->hasFile('file')) {
            if ($resource->file_path) {
                $this->fileUploader->delete($resource->file_path);
            }
            $file = $request->file('file');
            $storedPath = $this->fileUploader->upload($file, 'resources/files');
            $validated['file_path'] = 'storage/' . $storedPath;
            $validated['file_size'] = round($file->getSize() / 1024 / 1024, 2) . ' MB';
            if (empty($validated['file_type'])) {
                $validated['file_type'] = strtolower($file->getClientOriginalExtension());
            }
        }

        // Handle thumbnail replacement / removal
        if ($request->input('remove_thumbnail') == 1 && !$request->hasFile('thumbnail_file')) {
            if ($resource->thumbnail) {
                $this->fileUploader->delete($resource->thumbnail);
            }
            $validated['thumbnail'] = null;
        }

        if ($request->hasFile('thumbnail_file')) {
            if ($resource->thumbnail) {
                $this->fileUploader->delete($resource->thumbnail);
            }
            $thumb = $request->file('thumbnail_file');
            $storedThumb = $this->fileUploader->upload($thumb, 'resources/thumbnails');
            $validated['thumbnail'] = 'storage/' . $storedThumb;
        }

        $resource->update($validated);

        return ApiResponse::success($resource, 'Resource updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return ApiResponse::error('Resource not found.', 404);
        }

        if ($resource->file_path) {
            $this->fileUploader->delete($resource->file_path);
        }
        if ($resource->thumbnail) {
            $this->fileUploader->delete($resource->thumbnail);
        }

        $resource->delete();

        return ApiResponse::success(null, 'Resource deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(int $id): JsonResponse
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return ApiResponse::error('Resource not found.', 404);
        }

        $resource->status = (int) $resource->status === 1 ? 0 : 1;
        $resource->save();

        return ApiResponse::success($resource, 'Resource status updated successfully.');
    }
}
