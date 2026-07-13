<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

/**
 * API Controller for managing website sliders (banners).
 *
 * Handles frontend retrieval of sliders by key and full CRUD operations
 * for admin management of banner slides.
 */
class SliderController extends Controller
{
    /**
     * Retrieve paginated sliders for the frontend by key.
     *
     * Example: /api/sliders/banner_section
     *
     * @param Request $request
     * @param string $key The slider group key (e.g., 'banner_section')
     * @return \Illuminate\Http\JsonResponse
     */
    public function bannerSliders(Request $request, $key)
    {
        $slides = Slider::where('key', $key)
            ->orderBy('order')
            ->paginate(10); // Adjust per_page if needed via query string

        return ApiResponse::success($slides, 'Slides retrieved successfully');
    }

    /**
     * Retrieve a single slider by ID (for admin panel).
     *
     * @param int $id The ID of the slider
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        $slide = Slider::findOrFail($id);
        return ApiResponse::success($slide, 'Slide retrieved successfully');
    }

    /**
     * Store a new banner slide.
     *
     * Automatically assigns the 'banner_section' key.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'link'        => 'nullable|url|max:255',
            'order'       => 'nullable|integer|min:0',
            'enabled'     => 'nullable|in:0,1',
            'image'       => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data['key'] = 'banner_section';
        $data['enabled'] = $data['enabled'] ?? 1; // Default to enabled
        $data['createdBy'] = Auth::id();
        $data['updatedBy'] = Auth::id();

        $slide = Slider::create($data);

        if ($request->hasFile('image')) {
            $filename = uniqid('banner_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')
                ->storeAs("sliders/{$slide->id}/images", $filename, 'public');

            $slide->update(['image' => $path]);
        }

        return ApiResponse::success($slide, 'Slide created successfully');
    }


    /**
     * Update an existing banner slide.
     *
     * Replaces the image only if a new one is uploaded.
     *
     * @param Request $request
     * @param int $id The ID of the slide to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'link'        => 'nullable|url|max:255',
            'order'       => 'nullable|integer|min:0',
            'enabled'     => 'required|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);
        if ($request->remove_image == 1) {
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            ]);
        }
        if ($request->hasFile('image')) {
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            $filename = uniqid('banner_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $data['image'] = $request->file('image')
                ->storeAs("sliders/{$slider->id}/images", $filename, 'public');
        }

        $data['updatedBy'] = Auth::id();

        $slider->update($data);

        return ApiResponse::success($slider, 'Slide updated successfully');
    }


    /**
     * Toggle the enabled/disabled status of a slide.
     *
     * @param int $id The ID of the slide
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function toggle($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->enabled = $slider->enabled ? 0 : 1;
        $slider->save();

        return ApiResponse::success([
            'id'      => $slider->id,
            'enabled' => $slider->enabled,
        ], $slider->enabled ? 'Slide enabled' : 'Slide disabled');
    }

    /**
     * Permanently delete a slide and its associated image.
     *
     * @param int $id The ID of the slide to delete
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return ApiResponse::success(null, 'Slide deleted successfully');
    }
}
