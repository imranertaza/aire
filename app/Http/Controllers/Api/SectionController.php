<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

/**
 * API Controller for managing dynamic content sections (e.g., About Us, Mission, Vision, etc.).
 *
 * Sections store flexible data as JSON in the `data` column.
 * Supports full JSON replacement with optional image upload and per-key updates.
 */
class SectionController extends Controller
{
    /**
     * Retrieve a paginated list of all sections.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sections = Section::paginate(15);

        return ApiResponse::success($sections, 'Sections retrieved successfully');
    }

    /**
     * Retrieve a single section by ID.
     *
     * @param int $id The ID of the section
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        $section = Section::findOrFail($id);
        return ApiResponse::success($section, 'Section data retrieved successfully');
    }

    /**
     * Fully update a section's JSON data.
     *
     * Replaces the entire `data` field with new JSON.
     * Supports optional image upload (path will be stored in the JSON under `image` key).
     *
     * @param Request $request
     * @param int $id The ID of the section to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $request->validate([
            'data'  => 'required|json',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
        ]);

        if ($request->remove_image == 1) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            ]);
        }
        $data = json_decode($request->input('data'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return ApiResponse::error('Invalid JSON format provided.', 422);
        }

        if ($request->hasFile('image')) {
            $oldImage = $data['image'] ?? $section->data['image'] ?? null;
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $filename = uniqid('section_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $data['image'] = $request->file('image')
                ->storeAs("sections/{$section->id}/images", $filename, 'public');
        }

        $section->data = $data;
        $section->updatedBy = Auth::id();
        $section->save();

        return ApiResponse::success($section, 'Section updated successfully');
    }


    /**
     * Update a single key-value pair within a section's data.
     *
     * Creates the section if it doesn't exist (using the provided name).
     *
     * @param Request $request
     * @param string $name The unique name of the section (e.g., 'about_us', 'contact_info')
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateKey(Request $request, $name)
    {
        $section = Section::firstOrCreate(['name' => $name]);

        $validated = $request->validate([
            'key'   => 'required|string',
            'value' => 'nullable',
        ]);

        // Use a mutator or helper method on the model to update nested key
        $section->setValue($validated['key'], $validated['value']);

        return ApiResponse::success($section, 'Section key updated successfully');
    }
}
