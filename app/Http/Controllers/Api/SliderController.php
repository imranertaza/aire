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
     * Retrieve paginated sliders by group key or all.
     *
     * Example: /api/sliders/category_sidebar or /api/sliders/all
     *
     * @param Request $request
     * @param string|null $key The slider group key (e.g., 'category_sidebar', 'banner_section', 'all')
     * @return \Illuminate\Http\JsonResponse
     */
    public function bannerSliders(Request $request, $key = null)
    {
        $term = $request->query('term');

        $query = Slider::query();

        if ($key && $key !== 'all') {
            $query->where(function ($q) use ($key) {
                $q->where('key', $key)
                  ->orWhere('key', 'like', "%{$key}%");
            });
        }

        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('subtitle', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $slides = $query->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate($request->query('per_page', 15));

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
        $slideData = $slide->toArray();

        // Convert key to keys array for multiselect
        if (!empty($slide->key)) {
            if (str_starts_with($slide->key, '[') && str_ends_with($slide->key, ']')) {
                $slideData['keys'] = json_decode($slide->key, true) ?? [];
            } else {
                $slideData['keys'] = array_map('trim', explode(',', $slide->key));
            }
        } else {
            $slideData['keys'] = ['category_sidebar'];
        }

        return ApiResponse::success($slideData, 'Slide retrieved successfully');
    }

    /**
     * Store a new banner / ad slide.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'key'         => 'nullable',
            'keys'        => 'nullable',
            'subtitle'    => 'nullable|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'link'        => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'order'       => 'nullable|integer|min:0',
            'enabled'     => 'nullable|in:0,1',
            'image'       => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);

        // Process multiselect keys
        if ($request->has('keys')) {
            $keysVal = $request->input('keys');
            if (is_array($keysVal)) {
                $data['key'] = implode(',', $keysVal);
            } elseif (is_string($keysVal)) {
                $data['key'] = $keysVal;
            }
        } elseif ($request->has('key')) {
            $keyVal = $request->input('key');
            if (is_array($keyVal)) {
                $data['key'] = implode(',', $keyVal);
            } else {
                $data['key'] = (string) $keyVal;
            }
        } else {
            $data['key'] = 'category_sidebar';
        }

        unset($data['keys']);
        $data['enabled'] = $data['enabled'] ?? 1;
        $data['createdBy'] = Auth::id();
        $data['updatedBy'] = Auth::id();

        $slide = Slider::create($data);

        if ($request->hasFile('image')) {
            $filename = uniqid('slider_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')
                ->storeAs("sliders/{$slide->id}/images", $filename, 'public');

            $slide->update(['image' => $path]);
        }

        return ApiResponse::success($slide, 'Slide created successfully');
    }


    /**
     * Update an existing banner / ad slide.
     *
     * @param Request $request
     * @param int $id The ID of the slide to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $data = $request->validate([
            'key'         => 'nullable',
            'keys'        => 'nullable',
            'subtitle'    => 'nullable|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'link'        => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'order'       => 'nullable|integer|min:0',
            'enabled'     => 'required|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);

        // Process multiselect keys
        if ($request->has('keys')) {
            $keysVal = $request->input('keys');
            if (is_array($keysVal)) {
                $data['key'] = implode(',', $keysVal);
            } elseif (is_string($keysVal)) {
                $data['key'] = $keysVal;
            }
        } elseif ($request->has('key')) {
            $keyVal = $request->input('key');
            if (is_array($keyVal)) {
                $data['key'] = implode(',', $keyVal);
            } else {
                $data['key'] = (string) $keyVal;
            }
        }

        unset($data['keys']);

        if ($request->remove_image == 1) {
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            ]);
        }

        if ($request->hasFile('image')) {
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            $filename = uniqid('slider_image_') . '.' . $request->file('image')->getClientOriginalExtension();

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
