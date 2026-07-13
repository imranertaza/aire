<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * API Controller for managing results (e.g., competition results, exam results, etc.).
 *
 * Handles CRUD operations, status toggling, and file management (images or documents).
 */
class ResultController extends Controller
{
    /**
     * Retrieve a paginated list of results with optional search.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Result::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $results = $query->paginate($perPage);

        return ApiResponse::success($results, 'Results retrieved successfully');
    }

    /**
     * Retrieve a single result by its slug.
     *
     * @param string $slug The unique slug of the result
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        $result = Result::FindOrFail($id);
        return ApiResponse::success($result, 'Result retrieved successfully');
    }

    /**
     * Store a new result.
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
            'slug'        => 'required|string|unique:results,slug',
            'description' => 'nullable|string',
            'file'        => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx|max:4096',
            'status'      => 'required|in:0,1',
            'type'      => 'required|in:0,1',
        ]);

        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();

        // Create result first (without file)
        $result = Result::create($validated);

        // Handle file upload if present
        if ($request->hasFile('file')) {
            $filename = uniqid('result_file_') . '.' . $request->file('file')->getClientOriginalExtension();

            $path = $request->file('file')
                ->storeAs("results/{$result->id}", $filename, 'public');

            $result->update(['file' => $path]);
        }

        return ApiResponse::success($result, 'Result created successfully');
    }


    /**
     * Update an existing result.
     *
     * Replaces the attached file only if a new one is uploaded (deletes the old file).
     *
     * @param Request $request
     * @param int $id The ID of the result to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $result = Result::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => [
                'required',
                'string',
                Rule::unique('results', 'slug')->ignore($result->id),
            ],
            'description' => 'nullable|string',
            'file'        => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx|max:4096',
            'status'      => 'required|in:0,1',
            'type'      => 'required|in:0,1',
        ]);

        if ($request->remove_file == 1) {
            if ($result->file && Storage::disk('public')->exists($result->file)) {
                Storage::disk('public')->delete($result->file);
            }
            $validated['file'] = null;
        }

        $validated['updatedBy'] = Auth::id();

        if ($request->hasFile('file')) {
            if ($result->file && Storage::disk('public')->exists($result->file)) {
                Storage::disk('public')->delete($result->file);
            }

            $filename = uniqid('result_file_') . '.' . $request->file('file')->getClientOriginalExtension();

            $validated['file'] = $request->file('file')
                ->storeAs("results/{$result->id}", $filename, 'public');
        }

        $result->update($validated);

        return ApiResponse::success($result, 'Result updated successfully');
    }


    /**
     * Toggle the publication status (active/inactive) of a result.
     *
     * @param string $slug The slug of the result
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $result = Result::findOrFail($id);
        $result->status = $result->status === '1' ? '0' : '1';
        $result->updatedBy = Auth::id();
        $result->save();

        return ApiResponse::success([
            'status' => $result->status,
        ], $result->status === '1' ? 'Result active' : 'Result inactive');
    }

    /**
     * Permanently delete a result along with its associated file (if any).
     *
     * @param string $slug The slug of the result to delete
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy($id)
    {
        $result = Result::findOrFail($id);

        if ($result->file && Storage::disk('public')->exists($result->file)) {
            Storage::disk('public')->delete($result->file);
        }

        $result->delete();

        return ApiResponse::success(null, 'Result deleted successfully');
    }
}
