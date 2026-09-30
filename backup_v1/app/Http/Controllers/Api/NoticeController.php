<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * API Controller for managing notices.
 *
 * Handles CRUD operations, status toggling, and file management (images/documents)
 * for notices.
 */
class NoticeController extends Controller
{
    /**
     * Retrieve a paginated list of notices with optional search.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Notice::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $notices = $query->paginate($perPage);

        return ApiResponse::success($notices, 'Notices retrieved successfully');
    }

    /**
     * Retrieve a single notice by its slug.
     *
     * @param string $slug The unique slug of the notice
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        $notice = Notice::findOrFail($id);
        return ApiResponse::success($notice, 'Notice retrieved successfully');
    }

    /**
     * Store a new notice.
     *
     * Handles optional file upload (image or document) and assigns creator/updater.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:notices,slug',
            'description' => 'nullable|string',
            'file'        => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx|max:4096',
            'status'      => 'required|in:0,1',
            'type'        => 'required|in:0,1',
        ]);

        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();

        // Create notice first (without file)
        $notice = Notice::create($validated);

        // Handle file upload if present
        if ($request->hasFile('file')) {
            $filename = uniqid('notice_file_') . '.' . $request->file('file')->getClientOriginalExtension();

            $path = $request->file('file')
                ->storeAs("notices/{$notice->id}", $filename, 'public');

            $notice->update(['file' => $path]);
        }

        return ApiResponse::success($notice, 'Notice created successfully');
    }


    /**
     * Update an existing notice.
     *
     * Replaces the attached file only if a new one is uploaded (deletes the old file).
     *
     * @param Request $request
     * @param int $id The ID of the notice to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => [
                'required',
                'string',
                Rule::unique('notices', 'slug')->ignore($notice->id),
            ],
            'description' => 'nullable|string',
            'file'        => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx|max:4096',
            'status'      => 'required|in:0,1',
            'type'        => 'required|in:0,1',
        ]);
        if ($request->remove_f_image) {
            $request->validate([
                'featured_image'    => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
            ]);
        }
        if ($request->remove_image == 1) {
            if ($notice->file && Storage::disk('public')->exists($notice->file)) {
                Storage::disk('public')->delete($notice->file);
            }
            $validated['file']   = null;
        }


        $validated['updatedBy'] = Auth::id();

        if ($request->hasFile('file')) {
            if ($notice->file && Storage::disk('public')->exists($notice->file)) {
                Storage::disk('public')->delete($notice->file);
            }

            $filename = uniqid('notice_file_') . '.' . $request->file('file')->getClientOriginalExtension();

            $validated['file'] = $request->file('file')
                ->storeAs("notices/{$notice->id}", $filename, 'public');
        }

        $notice->update($validated);

        return ApiResponse::success($notice, 'Notice updated successfully');
    }


    /**
     * Toggle the publication status (active/inactive) of a notice.
     *
     * @param string $slug The slug of the notice
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->status = $notice->status === '1' ? '0' : '1';
        $notice->updatedBy = Auth::id();
        $notice->save();

        return ApiResponse::success([
            'status' => $notice->status,
        ], $notice->status === '1' ? 'Notice active' : 'Notice inactive');
    }

    /**
     * Permanently delete a notice along with its associated file (if any).
     *
     * @param string $slug The slug of the notice to delete
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->file && Storage::disk('public')->exists($notice->file)) {
            Storage::disk('public')->delete($notice->file);
        }

        $notice->delete();

        return ApiResponse::success(null, 'Notice deleted successfully');
    }
}
