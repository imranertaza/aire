<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cache;

/**
 * API Controller for managing dynamic content sections (e.g., About Us, Mission, Vision, etc.).
 *
 * Sections store flexible data as JSON in the `data` column.
 * Supports full JSON replacement with optional image upload and per-key updates.
 */
class SectionController extends Controller
{
    /**
     * Retrieve a paginated list of all sections with search and filtering.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->ensureDefaultSectionsExist();

        $query = Section::query();

        // 1. Search filter (by identifier name or JSON content like title)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('data', 'like', "%{$search}%");
            });
        }

        // 2. Type filter: 'block', 'standard'
        $type = $request->input('type');
        if ($type === 'block') {
            $query->where(function ($q) {
                $q->where('data', 'like', '%"blocks":%')
                  ->orWhere('name', 'like', 'builder_%')
                  ->orWhere('name', 'like', 'custom_%');
            });
        } elseif ($type === 'standard') {
            $query->where(function ($q) {
                $q->where('data', 'not like', '%"blocks":%')
                  ->where('name', 'not like', 'builder_%')
                  ->where('name', 'not like', 'custom_%');
            });
        }

        // 3. Page / Category Group filter: 'home', 'about', 'custom'
        $group = $request->input('group');
        if ($group === 'home') {
            $query->where(function ($q) {
                $q->where('name', 'like', 'home_%')
                  ->orWhereIn('name', ['why_choose_aire', 'trust_badges', 'client_testimonials', 'banner_section', 'benefits', 'lifestyle', 'video']);
            });
        } elseif ($group === 'about') {
            $query->where(function ($q) {
                $q->where('name', 'like', 'about_%')
                  ->orWhere('name', 'like', 'history_%');
            });
        } elseif ($group === 'custom') {
            $query->where(function ($q) {
                $q->where('name', 'like', 'custom_%')
                  ->orWhere('name', 'like', 'builder_%');
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 15;
        }

        $sort = $request->input('sort', 'desc');
        $query->orderBy('id', $sort === 'asc' ? 'asc' : 'desc');

        $sections = $query->paginate($perPage);

        return ApiResponse::success($sections, 'Sections retrieved successfully');
    }

    /**
     * Create a new custom or builder section.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:191|unique:sections,name',
            'data' => 'nullable',
        ]);

        $name = $validated['name'] ?? null;
        if (empty($name)) {
            $name = 'custom_section_' . uniqid();
        }

        $data = $request->input('data');
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data = $decoded;
            }
        }

        $section = Section::create([
            'name' => $name,
            'data' => $data ?? ['blocks' => []],
            'createdBy' => Auth::id(),
            'updatedBy' => Auth::id(),
        ]);

        return ApiResponse::success($section, 'Section created successfully', 201);
    }

    /**
     * Upload an image asset for block builder.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:10240',
        ]);

        $file = $request->file('image');
        $filename = 'block_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('sections/builder', $filename, 'public');

        return ApiResponse::success([
            'url' => 'storage/' . $path,
            'filename' => $filename,
        ], 'Image uploaded successfully');
    }

    /**
     * Ensure standard homepage sections exist in database without querying on every request.
     */
    protected function ensureDefaultSectionsExist(): void
    {
        Cache::remember('default_home_sections_ensured_v1', 86400, function () {
            if (!Section::where('name', 'home_best_selling')->exists()) {
                $defaultProductIds = \App\Models\Product::where('status', 1)->take(4)->pluck('id')->toArray();
                Section::create([
                    'name' => 'home_best_selling',
                    'data' => [
                        'badge'       => 'Product',
                        'title'       => 'Best Selling Product',
                        'subtitle'    => 'Discover the top‑selling models trusted by thousands of families for cleaner, healthier air.',
                        'product_ids' => $defaultProductIds,
                    ],
                ]);
            }
            if (!Section::where('name', 'home_new_arrival')->exists()) {
                $defaultNewArrivalIds = \App\Models\Product::where('status', 1)->latest('id')->take(3)->pluck('id')->toArray();
                Section::create([
                    'name' => 'home_new_arrival',
                    'data' => [
                        'badge'       => 'New arrival',
                        'title'       => 'Freshly Launched Models',
                        'subtitle'    => 'Explore the latest purifiers designed with advanced technology for modern living.',
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
                        'badge'       => 'Customers Favorites',
                        'title'       => 'Loved by Our Community',
                        'subtitle'    => 'Discover the purifiers most chosen by families who value clean, healthy air.',
                        'product_ids' => $defaultFavoriteIds,
                    ],
                ]);
            }
            if (!Section::where('name', 'home_living_hero')->exists()) {
                $defaultLivingHeroProduct = \App\Models\Product::where('status', 1)->latest('id')->first();
                Section::create([
                    'name' => 'home_living_hero',
                    'data' => [
                        'enabled'     => 1,
                        'badge'       => 'INNOVATION',
                        'title'       => 'The Future of Pure Living',
                        'subtitle'    => 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.',
                        'description' => 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.',
                        'image'       => 'themes/default/assets/img/background-without-product.png',
                        'product_id'  => $defaultLivingHeroProduct ? $defaultLivingHeroProduct->id : null,
                        'button_text' => 'Buy Now',
                    ],
                ]);
            }
            if (!Section::where('name', 'home_category_grid')->exists()) {
                Section::create([
                    'name' => 'home_category_grid',
                    'data' => [
                        'action_text' => 'Find Your Solutions',
                        'action_url'  => '/category/products',

                        'fresh_air_category_id' => null,
                        'fresh_air_title'       => 'Fresh Air Unit',
                        'fresh_air_url'         => '/category/fresh-air-systems',
                        'fresh_air_image'       => 'themes/default/assets/img/home/fresh-air-unit.webp',

                        'mask_category_id'      => null,
                        'mask_title'            => 'Air Pro Mask',
                        'mask_url'              => '/category/smart-wearable-masks',
                        'mask_image'            => 'themes/default/assets/img/home/air-pro-mask.webp',

                        'accessories_category_id' => null,
                        'accessories_title'       => 'Accessories',
                        'accessories_url'         => '/category/accessories-parts',
                        'accessories_image'       => 'themes/default/assets/img/home/accessories.webp',

                        'purifier_category_id'  => null,
                        'purifier_title'        => 'Air Purifiers',
                        'purifier_url'          => '/category/air-purifiers',
                        'purifier_image'        => 'themes/default/assets/img/home/air-purifiers.webp',

                        'home_solutions_category_id' => null,
                        'home_solutions_title'       => 'Solutions for Home',
                        'home_solutions_sub'         => 'Ventilation and Filtration Solution',
                        'home_solutions_url'         => '/category/home-fresh-air-systems',
                        'home_solutions_image'       => 'themes/default/assets/img/home/solutions-home.webp',

                        'biz_solutions_category_id' => null,
                        'biz_solutions_title'       => 'Solutions for Business',
                        'biz_solutions_sub'         => 'Air Disinfection & Air Monitoring',
                        'biz_solutions_url'         => '/category/commercial-fresh-air-systems',
                        'biz_solutions_image'       => 'themes/default/assets/img/home/solutions-business.webp',
                    ],
                ]);
            }
            return true;
        });
    }

    /**
     * Retrieve all sections configured on the storefront homepage, sorted in display sequence.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeSections(Request $request)
    {
        $homeSectionKeys = [
            'home_category_grid',
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

        $this->ensureDefaultSectionsExist();

        $sections = Section::whereIn('name', $homeSectionKeys)->get();

        $ordered = collect($homeSectionKeys)
            ->map(function ($key) use ($sections) {
                return $sections->firstWhere('name', $key);
            })
            ->filter()
            ->values();

        return ApiResponse::success($ordered, 'Home sections retrieved successfully');
    }

    /**
     * Retrieve all sections configured on the About Us page, sorted in display sequence.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function aboutSections(Request $request)
    {
        $aboutSectionKeys = [
            'about_hero',
            'about_story',
            'about_mission_vision',
            'about_leadership',
            'about_innovation',
            'about_quality',
            'about_careers',
            'about_news',
            'about_global',
        ];

        $sections = Section::whereIn('name', $aboutSectionKeys)->get();

        $ordered = collect($aboutSectionKeys)
            ->map(function ($key) use ($sections) {
                return $sections->firstWhere('name', $key);
            })
            ->filter()
            ->values();

        return ApiResponse::success($ordered, 'About sections retrieved successfully');
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
            'data'  => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:10240',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:102400',
        ]);

        if ($request->remove_image == 1) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            ]);
        }

        if (is_array($request->input('data'))) {
            $data = $request->input('data');
        } else {
            $request->validate([
                'data' => 'required|json',
            ]);
            $data = json_decode($request->input('data'), true);
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

        // Handle Category Grid individual slot images
        $gridImageKeys = [
            'fresh_air_image',
            'mask_image',
            'accessories_image',
            'purifier_image',
            'home_solutions_image',
            'biz_solutions_image',
        ];
        foreach ($gridImageKeys as $imgKey) {
            $fileKey = "{$imgKey}_file";
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $filename = uniqid("grid_{$imgKey}_") . '.' . $file->getClientOriginalExtension();
                $storedPath = $file->storeAs("sections/{$section->id}/category_grid", $filename, 'public');
                $data[$imgKey] = 'storage/' . $storedPath;
            }
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

    /**
     * Get available visual block builder sections for selection in page layouts.
     */
    public function availableBlocks(Request $request)
    {
        $sections = Section::query()
            ->where(function ($q) {
                $q->where('data', 'like', '%"blocks":%')
                  ->orWhere('name', 'like', 'builder_%')
                  ->orWhere('name', 'like', 'custom_%');
            })
            ->where('name', 'not like', '%_layout')
            ->latest('id')
            ->get();

        $formatted = $sections->map(function ($s) {
            $blocks = $s->data['blocks'] ?? [];
            return [
                'id' => $s->id,
                'name' => $s->name,
                'title' => $s->data['title'] ?? $s->name,
                'category' => $s->data['category'] ?? 'Custom',
                'block_count' => is_array($blocks) ? count($blocks) : 0,
                'updated_at' => $s->updated_at ? $s->updated_at->diffForHumans() : null,
            ];
        });

        return ApiResponse::success($formatted, 'Available block sections retrieved successfully');
    }

    /**
     * Get the dynamic layout sequence and slot injections for a given page.
     *
     * @param string $page ('home', 'about', 'resources')
     */
    public function getPageLayout(string $page)
    {
        $validPages = ['home', 'about', 'resources', 'product', 'contact', 'category', 'news', 'news_detail', 'order_confirm', 'cart', 'not_found', 'favorite', 'compare'];
        if (!in_array($page, $validPages)) {
            return ApiResponse::error('Invalid page identifier', 400);
        }

        $layoutSection = Section::where('name', "{$page}_layout")->first();
        $slots = $layoutSection?->data['slots'] ?? null;

        // Default initial fallback for home if not yet saved
        if ($slots === null && $page === 'home') {
            $customExists = Section::where('name', 'custom_section_131027')->exists();
            $slots = [
                'before:slider_section' => [],
                'after:slider_section' => $customExists ? [
                    ['key' => 'custom_section_131027', 'name' => 'Visual Hero Extension (131027)', 'enabled' => true]
                ] : [],
                'after:home_category_grid' => [],
                'after:home_benefits' => [],
                'after:home_best_selling' => [],
                'after:home_lifestyle' => [],
                'after:home_new_arrival' => [],
                'after:why_choose_aire' => [],
                'after:home_customer_favorites' => [],
                'after:home_video' => [],
                'after:home_living_hero' => [],
                'after:home_faq' => [],
            ];
        } elseif ($slots === null) {
            $slots = [];
        }

        return ApiResponse::success([
            'page' => $page,
            'slots' => $slots,
            'updated_at' => $layoutSection?->updated_at ? $layoutSection->updated_at->toIso8601String() : null,
        ], 'Page layout retrieved successfully');
    }

    /**
     * Save the dynamic layout slots for a given page and bust cache immediately.
     *
     * @param Request $request
     * @param string $page ('home', 'about', 'resources')
     */
    public function savePageLayout(Request $request, string $page)
    {
        $validPages = ['home', 'about', 'resources', 'product', 'contact', 'category', 'news', 'news_detail', 'order_confirm', 'cart', 'not_found', 'favorite', 'compare'];
        if (!in_array($page, $validPages)) {
            return ApiResponse::error('Invalid page identifier', 400);
        }

        $validated = $request->validate([
            'slots' => 'required|array',
        ]);

        $section = Section::updateOrCreate(
            ['name' => "{$page}_layout"],
            [
                'page_name' => $page,
                'data' => [
                    'page' => $page,
                    'slots' => $validated['slots'],
                    'updated_at' => now()->toIso8601String(),
                ],
                'updatedBy' => Auth::id() ?? 1,
            ]
        );

        Cache::forget("page_layout_{$page}_v1");
        Section::clearSectionCache($section);

        return ApiResponse::success([
            'page' => $page,
            'slots' => $section->data['slots'] ?? [],
        ], 'Page layout updated and cached successfully');
    }
}
