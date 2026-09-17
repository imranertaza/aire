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
        if (!Section::where('name', 'home_best_selling')->exists()) {
            $defaultProductIds = \App\Models\Product::where('status', 1)->take(4)->pluck('id')->toArray();
            Section::create([
                'name' => 'home_best_selling',
                'data' => [
                    'badge' => 'Product',
                    'title' => 'Best Selling Product',
                    'subtitle' => 'Discover the top‑selling models trusted by thousands of families for cleaner, healthier air.',
                    'product_ids' => $defaultProductIds,
                ],
            ]);
        }
        if (!Section::where('name', 'home_new_arrival')->exists()) {
            $defaultNewArrivalIds = \App\Models\Product::where('status', 1)->latest('id')->take(3)->pluck('id')->toArray();
            Section::create([
                'name' => 'home_new_arrival',
                'data' => [
                    'badge' => 'New arrival',
                    'title' => 'Freshly Launched Models',
                    'subtitle' => 'Explore the latest purifiers designed with advanced technology for modern living.',
                    'product_ids' => $defaultNewArrivalIds,
                ],
            ]);
        }
        if (!Section::where('name', 'home_customer_favorites')->exists()) {
            $defaultFavoriteIds = \App\Models\Product::where('status', 1)->skip(3)->take(3)->pluck('id')->toArray();
            if (empty($defaultFavoriteIds)) {
                $defaultFavoriteIds = \App\Models\Product::where('status', 1)->take(2)->pluck('id')->toArray();
            }
            Section::create([
                'name' => 'home_customer_favorites',
                'data' => [
                    'badge' => 'Customers Favorites',
                    'title' => 'Loved by Our Community',
                    'subtitle' => 'Discover the purifiers most chosen by families who value clean, healthy air.',
                    'product_ids' => $defaultFavoriteIds,
                ],
            ]);
        }

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
        /**
     * Retrieve all sections configured on the storefront homepage, sorted in display sequence.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeSections(Request $request)
    {
        $homeSectionKeys = [
            'home_benefits',
            'home_best_selling',
            'home_lifestyle',
            'home_new_arrival',
            'why_choose_aire',
            'home_customer_favorites',
            'home_video',
            'home_living_hero',
            'home_faq',
        ];

        // Ensure default records exist for essential sections if missing
        if (!Section::where('name', 'home_best_selling')->exists()) {
            $defaultProductIds = \App\Models\Product::where('status', 1)->take(4)->pluck('id')->toArray();
            Section::create([
                'name' => 'home_best_selling',
                'data' => [
                    'badge' => 'Product',
                    'title' => 'Best Selling Product',
                    'subtitle' => 'Discover the top‑selling models trusted by thousands of families for cleaner, healthier air.',
                    'product_ids' => $defaultProductIds,
                ],
            ]);
        }
        if (!Section::where('name', 'home_new_arrival')->exists()) {
            $defaultNewArrivalIds = \App\Models\Product::where('status', 1)->latest('id')->take(3)->pluck('id')->toArray();
            Section::create([
                'name' => 'home_new_arrival',
                'data' => [
                    'badge' => 'New arrival',
                    'title' => 'Freshly Launched Models',
                    'subtitle' => 'Explore the latest purifiers designed with advanced technology for modern living.',
                    'product_ids' => $defaultNewArrivalIds,
                ],
            ]);
        }
        if (!Section::where('name', 'home_customer_favorites')->exists()) {
            $defaultFavoriteIds = \App\Models\Product::where('status', 1)->skip(3)->take(3)->pluck('id')->toArray();
            if (empty($defaultFavoriteIds)) {
                $defaultFavoriteIds = \App\Models\Product::where('status', 1)->take(2)->pluck('id')->toArray();
            }
            Section::create([
                'name' => 'home_customer_favorites',
                'data' => [
                    'badge' => 'Customers Favorites',
                    'title' => 'Loved by Our Community',
                    'subtitle' => 'Discover the purifiers most chosen by families who value clean, healthy air.',
                    'product_ids' => $defaultFavoriteIds,
                ],
            ]);
        }
        if (!Section::where('name', 'home_living_hero')->exists()) {
            $defaultLivingHeroProduct = \App\Models\Product::where('status', 1)->latest('id')->first();
            Section::create([
                'name' => 'home_living_hero',
                'data' => [
                    'enabled' => 1,
                    'badge' => 'INNOVATION',
                    'title' => 'The Future of Pure Living',
                    'subtitle' => 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.',
                    'description' => 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.',
                    'image' => 'themes/default/assets/img/background-without-product.png',
                    'product_id' => $defaultLivingHeroProduct ? $defaultLivingHeroProduct->id : null,
                    'button_text' => 'Buy Now',
                ],
            ]);
        }

        $sections = Section::whereIn('name', $homeSectionKeys)->get();

        $ordered = collect($homeSectionKeys)
            ->map(function ($key) use ($sections) {
                return $sections->firstWhere('name', $key);
            })
            ->filter()
            ->values();

        return ApiResponse::success($ordered, 'Home sections retrieved successfully');
    }

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
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:10240',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:102400',
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
        if ($request->hasFile('video_file')) {
            $oldVideo = $data['video_file'] ?? $section->data['video_file'] ?? null;
            if ($oldVideo && Storage::disk('public')->exists($oldVideo)) {
                Storage::disk('public')->delete($oldVideo);
            }

            $filename = uniqid('video_') . '.' . $request->file('video_file')->getClientOriginalExtension();
            $data['video_file'] = $request->file('video_file')
                ->storeAs("sections/{$section->id}/video", $filename, 'public');
        }

        if ($request->remove_video == 1) {
            $oldVideo = $data['video_file'] ?? $section->data['video_file'] ?? null;
            if ($oldVideo && Storage::disk('public')->exists($oldVideo)) {
                Storage::disk('public')->delete($oldVideo);
            }
            $data['video_file'] = null;
        }


        // Handle item-level images & avatars (e.g. item_image_0, item_avatar_0, etc.)
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $index => &$item) {
                $imageKey = "item_image_{$index}";
                if ($request->hasFile($imageKey)) {
                    $file = $request->file($imageKey);
                    $filename = uniqid('lifestyle_') . '.' . $file->getClientOriginalExtension();
                    $storedPath = $file->storeAs("sections/{$section->id}/lifestyle", $filename, 'public');
                    $item['image'] = $storedPath;
                }

                $avatarKey = "item_avatar_{$index}";
                if ($request->hasFile($avatarKey)) {
                    $file = $request->file($avatarKey);
                    $filename = uniqid('avatar_') . '.' . $file->getClientOriginalExtension();
                    $storedPath = $file->storeAs("sections/{$section->id}/testimonials", $filename, 'public');
                    $item['avatar'] = $storedPath;
                }
            }
            unset($item);
        }

        $section->data = $data;
        $section->updatedBy = Auth::id();
        $section->save();

        return ApiResponse::success($section, 'Section updated successfully');
    }


    /**
     * Retrieve or create a single section by unique name.
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByName($name)
    {
        $section = Section::firstOrCreate(['name' => $name]);

        if (empty($section->data) && $name === 'client_testimonials') {
            $section->data = [
                'title' => 'Purity in Practice',
                'subtitle' => 'CLIENT TESTIMONIALS',
                'items' => [
                    [
                        'name' => 'Sarah Jenkins',
                        'role' => 'INTERIOR ARCHITECT',
                        'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80',
                        'rating' => 5,
                        'quote' => "The AIRE Pro S1 is not just an air purifier; it's a piece of architectural art that has transformed our living environment.",
                    ],
                    [
                        'name' => 'Marcus Chen',
                        'role' => 'SENIOR FACILITY MANAGER',
                        'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=120&q=80',
                        'rating' => 5,
                        'quote' => 'Unmatched technical precision. The IAQ data reporting is exactly what our facility management team needed for ESG compliance.',
                    ],
                    [
                        'name' => 'Dr. Elena Rostova',
                        'role' => 'CLINICAL ALLERGIST',
                        'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=120&q=80',
                        'rating' => 5,
                        'quote' => 'The multi-stage filtration system drastically reduced particulate matter in our high-traffic clinic rooms. Absolutely vital for our patients.',
                    ],
                    [
                        'name' => 'David Sterling',
                        'role' => 'SUSTAINABILITY DIRECTOR',
                        'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
                        'rating' => 5,
                        'quote' => 'Combining whisper-quiet acoustics with verifiable CADR performance has made AIRE our go-to partner for premium commercial builds.',
                    ],
                ]
            ];
            $section->save();
        }

        if (empty($section->data) && ($name === 'home_best_selling' || $name === 'best_selling')) {
            $defaultProductIds = \App\Models\Product::where('status', 1)->take(4)->pluck('id')->toArray();
            $section->data = [
                'badge' => 'Product',
                'title' => 'Best Selling Product',
                'subtitle' => 'Discover the top‑selling models trusted by thousands of families for cleaner, healthier air.',
                'product_ids' => $defaultProductIds,
            ];
            $section->save();
        }

        if (empty($section->data) && ($name === 'home_living_hero' || $name === 'living_hero')) {
            $defaultLivingHeroProduct = \App\Models\Product::where('status', 1)->latest('id')->first();
            $section->data = [
                'enabled' => 1,
                'badge' => 'INNOVATION',
                'title' => 'The Future of Pure Living',
                'subtitle' => 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.',
                'description' => 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.',
                'image' => 'themes/default/assets/img/background-without-product.png',
                'product_id' => $defaultLivingHeroProduct ? $defaultLivingHeroProduct->id : null,
                'button_text' => 'Buy Now',
            ];
            $section->save();
        }

        return ApiResponse::success($section, 'Section data retrieved successfully');
    }

    /**
     * Update a section by its unique name.
     *
     * @param Request $request
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateByName(Request $request, $name)
    {
        $section = Section::firstOrCreate(['name' => $name]);
        return $this->update($request, $section->id);
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
