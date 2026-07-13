<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * API Controller for managing galleries and their detail images.
 *
 * Handles CRUD operations for galleries (with thumbnail), gallery detail images,
 * and toggling status. Supports pagination, search, and file management.
 */
class GalleryController extends Controller
{
    /**
     * Retrieve a paginated list of galleries with optional search.
     *
     * Supports an 'all' query parameter to return all galleries (id + name only).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Gallery::withCount('details')->orderBy('sort_order');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('alt_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('all')) {
            $galleries = $query->select(['id', 'name'])->get();
        } else {
            $perPage   = $request->input('per_page', 10);
            $galleries = $query->paginate($perPage);
        }

        return ApiResponse::success($galleries, 'Galleries retrieved successfully');
    }

    /**
     * Store a new gallery.
     *
     * Handles optional thumbnail upload.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'thumb'      => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'sort_order' => 'nullable|integer',
            'alt_name'   => 'nullable|string|max:255',
            'scope'      => 'integer|in:0,1,2',
        ]);

        $gallery = Gallery::create($validated);

        if ($request->hasFile('thumb')) {
            $path = $request->file('thumb')->store('gallery/' . $gallery->id . '/thumbs', 'public');
            $gallery->update(['thumb' => $path]);
        }


        return ApiResponse::success($gallery, 'Gallery created successfully');
    }

    /**
     * Display a single gallery along with all its detail images.
     *
     * @param Gallery $gallery The gallery instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('details');
        return ApiResponse::success($gallery, 'Gallery retrieved successfully');
    }

    /**
     * Update an existing gallery.
     *
     * Replaces thumbnail only if a new file is uploaded.
     *
     * @param Request $request
     * @param Gallery $gallery The gallery instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Gallery $gallery)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'thumb'      => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'alt_name'   => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'scope'      => 'integer|in:0,1,2',
            'remove_f_image' => 'nullable'
        ], [
            'thumb.required' => 'Thumbnail is required when uploading.',
            'thumb.image' => 'Thumbnail must be an image file.',
            'thumb.mimes' => 'Thumbnail must be a file of type: jpg, jpeg, png, webp, gif.',
            'thumb.max' => 'Thumbnail size must not exceed 2MB.',
        ]);
        if ($request->remove_f_image == 1) {
            $request->validate(
                ['thumb' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048'],
                [
                    'thumb.required' => 'Thumbnail is required when uploading.',
                    'thumb.image' => 'Thumbnail must be an image file.',
                    'thumb.mimes' => 'Thumbnail must be a file of type: jpg, jpeg, png, webp,
                gif.',
                    'thumb.max' => 'Thumbnail size must not exceed 2MB.',
                ]
            );
        }
        if ($request->hasFile('thumb')) {
            if ($gallery->thumb && Storage::disk('public')->exists($gallery->thumb)) {
                Storage::disk('public')->delete($gallery->thumb);
            }
            $path = $request->file('thumb')->store('gallery/' . $gallery->id . '/thumbs', 'public');
            $validated['thumb'] = $path;
        }

        $gallery->update($validated);

        return ApiResponse::success($gallery, 'Gallery updated successfully');
    }

    /**
     * Toggle the active/inactive status of a gallery.
     *
     * @param int $id The ID of the gallery
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $gallery         = Gallery::findOrFail($id);
        $gallery->status = $gallery->status == 1 ? 0 : 1;
        $gallery->save();

        return ApiResponse::success([
            'status' => $gallery->status,
        ], $gallery->status == 1 ? 'Gallery active' : 'Gallery inactive');
    }

    /**
     * Permanently delete a gallery and all its associated detail images and files.
     *
     * @param Gallery $gallery The gallery instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->details as $detail) {
            if ($detail->image && Storage::disk('public')->exists($detail->image)) {
                Storage::disk('public')->delete($detail->image);
            }
            $detail->delete();
        }

        if ($gallery->thumb && Storage::disk('public')->exists($gallery->thumb)) {
            Storage::disk('public')->delete($gallery->thumb);
        }

        $gallery->delete();

        return ApiResponse::success(null, 'Gallery and its details deleted successfully');
    }

    /**
     * Store a new detail image for a gallery.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDetail(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required|exists:gallery,id',
            'image'      => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'alt_name'   => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $detail = GalleryDetail::create([
            'gallery_id' => $request->gallery_id,
            'image'      => '',
            'alt_name'   => $request->alt_name,
            'sort_order' => $request->sort_order ?? 0,
            'createdBy'  => Auth::id(),
        ]);
        $path = $request->file('image')->store('gallery/' . $request->gallery_id . "/details\/" . $detail->id, 'public');

        $detail->update(['image' => $path]);

        return ApiResponse::success($detail, 'Gallery image added successfully');
    }

    /**
     * Delete a single gallery detail image.
     *
     * @param GalleryDetail $detail The detail instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyGalleryDetail(GalleryDetail $detail)
    {
        if ($detail->image && Storage::disk('public')->exists($detail->image)) {
            Storage::disk('public')->delete($detail->image);
        }

        $detail->delete();

        return ApiResponse::success(null, 'Gallery detail deleted successfully');
    }

    /**
     * Update alt text and/or sort order of a gallery detail image.
     *
     * @param Request $request
     * @param GalleryDetail $detail The detail instance (route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDetail(Request $request, GalleryDetail $detail)
    {
        $detail->update([
            'alt_name'   => $request->input('alt_name'),
            'sort_order' => $request->input('sort_order', $detail->sort_order),
        ]);

        return ApiResponse::success($detail, 'Alt text updated successfully');
    }
}
