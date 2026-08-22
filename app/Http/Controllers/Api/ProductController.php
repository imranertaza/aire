<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductOption;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ProductDescription;
use App\Models\ProductFreeDelivery;
use App\Models\ProductSpecial;

class ProductController extends Controller
{
    /**
     * Retrieve list of products for dropdown search.
     */
    public function dropdownList(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');

        $query = Product::select('id', 'name', 'model');

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('product_categories.id', $categoryId);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }

        $limit = $request->query('limit', $categoryId ? null : 100);
        if ($limit) {
            $query->limit($limit);
        }

        $products = $query->get();
        return ApiResponse::success($products, 'Products list retrieved successfully');
    }

    /**
     * Retrieve a paginated list of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['brand'])->latest('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%");
        }

        $perPage = (int) $request->input('per_page', 10);
        $products = $query->paginate($perPage);

        return ApiResponse::success($products, 'Products retrieved successfully');
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        foreach (['category_ids', 'related_ids', 'bought_together_ids', 'options', 'attributes', 'deleted_images'] as $field) {
            if ($request->has($field) && is_string($request->input($field))) {
                $request->merge([$field => json_decode($request->input($field), true)]);
            }
        }

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'model'               => 'required|string|max:255',
            'product_code'        => 'nullable|string|max:255',
            'brand_id'            => 'nullable|integer|exists:brands,id',
            'price'               => 'required|numeric|min:0',
            'quantity'            => 'required|integer|min:0',
            'featured'            => 'nullable|in:0,1,true,false',
            'status'              => 'nullable|in:0,1,true,false',
            'date_available'      => 'nullable|date',
            'weight'              => 'nullable|numeric|min:0',
            'length'              => 'nullable|numeric|min:0',
            'width'               => 'nullable|numeric|min:0',
            'height'              => 'nullable|numeric|min:0',
            'sort_order'          => 'nullable|integer|min:0',

            // Image
            'main_image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // Arrays for relations
            'options'             => 'nullable|array',
            'attributes'          => 'nullable|array',
            'gallery_images'      => 'nullable|array',
            'gallery_images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // New fields
            'slug'                => 'nullable|string|max:255',
            'description'         => 'nullable|string',
            'tag'                 => 'nullable|string|max:255',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:255',
            'meta_keyword'        => 'nullable|string|max:255',
            'video'               => 'nullable|string|max:255',
            'special_price'       => 'nullable|numeric|min:0',
            'special_start_date'  => 'nullable|date',
            'special_end_date'    => 'nullable|date',
            'product_free_delivery' => 'nullable|in:0,1,true,false',
            'documentation_pdf'   => 'nullable|file|mimes:pdf|max:5120',
            'safety_pdf'          => 'nullable|file|mimes:pdf|max:5120',
            'instructions_pdf'    => 'nullable|file|mimes:pdf|max:5120',
            'description_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category_ids'        => 'nullable|array',
            'related_ids'         => 'nullable|array',
            'bought_together_ids' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            // Default store handling (as per CI4 logic)
            $store = Store::where('is_default', 1)->first();
            if (!$store) {
                return ApiResponse::error('Default store not found. Please set a default store first.', 400);
            }

            // Create Product
            $product = Product::create([
                'store_id'            => $store->id,
                'name'                => $validated['name'],
                'slug'                => !empty($validated['slug']) ? Str::slug($validated['slug']) : null,
                'model'               => $validated['model'],
                'product_code'        => $validated['product_code'] ?? null,
                'brand_id'            => $validated['brand_id'] ?? null,
                'price'               => $validated['price'],
                'quantity'            => $validated['quantity'],
                'featured'            => filter_var($validated['featured'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'status'              => filter_var($validated['status'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'date_available'      => $validated['date_available'] ?? null,
                'weight'              => $validated['weight'] ?? 0.0000,
                'length'              => $validated['length'] ?? 0.0000,
                'width'               => $validated['width'] ?? 0.0000,
                'height'              => $validated['height'] ?? 0.0000,
                'sort_order'          => $validated['sort_order'] ?? 0,
                'main_image'          => null, // Set null first to get product ID
                'alt_name'            => $validated['name'], // as per CI4 logic
                'createdBy'           => Auth::id(),
                'updatedBy'           => Auth::id(),
            ]);

            // Upload Main Image
            if ($request->hasFile('main_image')) {
                $file = $request->file('main_image');
                $filename = Str::slug($product->name) . '.' . $file->getClientOriginalExtension();
                $mainImagePath = $file->storeAs("product/{$product->id}", $filename, 'public');
                $product->update(['main_image' => $mainImagePath]);
            }

            // Save Description Relation
            $descData = [
                'description'      => $request->input('description'),
                'tag'              => $request->input('tag'),
                'meta_title'       => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword'     => $request->input('meta_keyword'),
                'video'            => $request->input('video'),

                // Specifications Section Fields (Section 2)
                'specs_badge'          => $request->input('specs_badge'),
                'specs_title'          => $request->input('specs_title'),
                'specs_description'    => $request->input('specs_description'),
                'specs_image'          => $request->input('specs_image'),
                'spec1_icon'           => $request->input('spec1_icon'),
                'spec1_badge'          => $request->input('spec1_badge'),
                'spec1_value'          => $request->input('spec1_value'),
                'spec1_unit'           => $request->input('spec1_unit'),
                'spec1_desc'           => $request->input('spec1_desc'),
                'spec2_icon'           => $request->input('spec2_icon'),
                'spec2_badge'          => $request->input('spec2_badge'),
                'spec2_value'          => $request->input('spec2_value'),
                'spec2_unit'           => $request->input('spec2_unit'),
                'spec2_desc'           => $request->input('spec2_desc'),
                'spec3_icon'           => $request->input('spec3_icon'),
                'spec3_badge'          => $request->input('spec3_badge'),
                'spec3_value'          => $request->input('spec3_value'),
                'spec3_unit'           => $request->input('spec3_unit'),
                'spec3_desc'           => $request->input('spec3_desc'),
                'spec4_icon'           => $request->input('spec4_icon'),
                'spec4_badge'          => $request->input('spec4_badge'),
                'spec4_value'          => $request->input('spec4_value'),
                'spec4_unit'           => $request->input('spec4_unit'),
                'spec4_desc'           => $request->input('spec4_desc'),

                // Features Section Fields (Section 3)
                'features_badge'       => $request->input('features_badge'),
                'features_title'       => $request->input('features_title'),
                'features_description' => $request->input('features_description'),
                'features_image'       => $request->input('features_image'),
                'feature1_icon'        => $request->input('feature1_icon'),
                'feature1_title'       => $request->input('feature1_title'),
                'feature1_desc'        => $request->input('feature1_desc'),
                'feature2_icon'        => $request->input('feature2_icon'),
                'feature2_title'       => $request->input('feature2_title'),
                'feature2_desc'        => $request->input('feature2_desc'),
                'feature3_icon'        => $request->input('feature3_icon'),
                'feature3_title'       => $request->input('feature3_title'),
                'feature3_desc'        => $request->input('feature3_desc'),

                // Applications Section Header
                'applications_title'       => $request->input('applications_title'),
                'applications_description' => $request->input('applications_description'),

                // Technology Section Fields
                'technology_badge'            => $request->input('technology_badge'),
                'technology_title'            => $request->input('technology_title'),
                'technology_description'      => $request->input('technology_description'),
                'technology_image'            => $request->input('technology_image'),
                'technology_card_title'       => $request->input('technology_card_title'),
                'technology_card_description' => $request->input('technology_card_description'),
                'tech_feature1_title'         => $request->input('tech_feature1_title'),
                'tech_feature1_desc'          => $request->input('tech_feature1_desc'),
                'tech_feature2_title'         => $request->input('tech_feature2_title'),
                'tech_feature2_desc'          => $request->input('tech_feature2_desc'),
                'tech_feature3_title'         => $request->input('tech_feature3_title'),
                'tech_feature3_desc'          => $request->input('tech_feature3_desc'),
            ];

            if ($request->hasFile('documentation_pdf')) {
                $file = $request->file('documentation_pdf');
                $filename = 'doc_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['documentation_pdf'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('safety_pdf')) {
                $file = $request->file('safety_pdf');
                $filename = 'safety_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['safety_pdf'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('instructions_pdf')) {
                $file = $request->file('instructions_pdf');
                $filename = 'instruction_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['instructions_pdf'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('description_image')) {
                $file = $request->file('description_image');
                $filename = 'desc_img_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['description_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('specs_image')) {
                $file = $request->file('specs_image');
                $filename = 'specs_bg_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['specs_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('features_image')) {
                $file = $request->file('features_image');
                $filename = 'feat_bg_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['features_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('technology_image')) {
                $file = $request->file('technology_image');
                $filename = 'tech_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['technology_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }

            $product->description()->create($descData);

            // Save Overview
            $overviewData = [
                'title'          => $request->input('overview_title'),
                'description'    => $request->input('overview_description'),
                'image'          => $request->input('overview_image'),
                'feature1_icon'  => $request->input('overview_feature1_icon'),
                'feature1_title' => $request->input('overview_feature1_title'),
                'feature1_desc'  => $request->input('overview_feature1_desc'),
                'feature2_icon'  => $request->input('overview_feature2_icon'),
                'feature2_title' => $request->input('overview_feature2_title'),
                'feature2_desc'  => $request->input('overview_feature2_desc'),
                'hud_label1'     => $request->input('overview_hud_label1'),
                'hud_label2'     => $request->input('overview_hud_label2'),
                'hud_label3'     => $request->input('overview_hud_label3'),
            ];

            if ($request->hasFile('overview_image')) {
                $file = $request->file('overview_image');
                $filename = 'overview_' . time() . '.' . $file->getClientOriginalExtension();
                $overviewData['image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }

            $product->overview()->create($overviewData);

            // Free Delivery
            $isFreeDelivery = filter_var($request->input('product_free_delivery') ?? 0, FILTER_VALIDATE_BOOLEAN);
            if ($isFreeDelivery) {
                $product->freeDelivery()->create(['sort_order' => 0]);
            }

            // Specials
            $specialPrice = $request->input('special_price');
            if ($specialPrice !== null && $specialPrice !== '') {
                $product->specials()->create([
                    'special_price' => $specialPrice,
                    'start_date'    => $request->input('special_start_date'),
                    'end_date'      => $request->input('special_end_date'),
                ]);
            }

            // Sync categories (multiple)
            $categoryIds = $request->input('category_ids') ? (is_array($request->input('category_ids')) ? $request->input('category_ids') : json_decode($request->input('category_ids'), true)) : [];
            $product->categories()->sync($categoryIds);

            // Sync related products
            $relatedIds = $request->input('related_ids') ? (is_array($request->input('related_ids')) ? $request->input('related_ids') : json_decode($request->input('related_ids'), true)) : [];
            $product->relatedProducts()->sync($relatedIds);

            // Sync bought together products
            $boughtTogetherIds = $request->input('bought_together_ids') ? (is_array($request->input('bought_together_ids')) ? $request->input('bought_together_ids') : json_decode($request->input('bought_together_ids'), true)) : [];
            $product->boughtTogether()->sync($boughtTogetherIds);

            // Save Options
            if (!empty($validated['options'])) {
                $optionData = [];
                foreach ($validated['options'] as $opt) {
                    $optionData[] = [
                        'product_id'      => $product->id,
                        'option_id'       => $opt['option_id'],
                        'option_value_id' => $opt['option_value_id'],
                        'quantity'        => $opt['quantity'] ?? 0,
                        'subtract'        => filter_var($opt['subtract'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                        'price'           => $opt['price'] ?? null,
                        'price_prefix'    => $opt['price_prefix'] ?? '+',
                    ];
                }
                ProductOption::insert($optionData);
            }

            // Save Attributes
            $attributes = $validated['attributes'] ?? $request->input('attributes');
            if (is_string($attributes)) {
                $attributes = json_decode($attributes, true);
            }
            if (!empty($attributes) && is_array($attributes)) {
                $attributeData = [];
                $now = now();
                foreach ($attributes as $attr) {
                    if (!is_array($attr)) continue;
                    if (empty($attr['name']) || empty($attr['attribute_group_id'])) continue;
                    $attributeData[] = [
                        'product_id'         => $product->id,
                        'attribute_group_id' => (int) $attr['attribute_group_id'],
                        'name'               => trim($attr['name']),
                        'details'            => $attr['details'] ?? null,
                        'sort_order'         => isset($attr['sort_order']) ? (int) $attr['sort_order'] : 0,
                        'status'             => 1,
                        'createdBy'          => Auth::id(),
                        'updatedBy'          => Auth::id(),
                        'created_at'         => $now,
                        'updated_at'         => $now,
                    ];
                }
                if (!empty($attributeData)) {
                    ProductAttribute::insert($attributeData);
                }
            }

            // Save Gallery Images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $productImage = ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => '',
                        'alt_name'   => $product->name,
                        'createdBy'  => Auth::id(),
                        'updatedBy'  => Auth::id(),
                    ]);

                    $filename = Str::slug($product->name) . '-' . $productImage->id . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs("product/{$product->id}/gallery", $filename, 'public');
                    $productImage->update(['image' => $path]);
                }
            }


            // Save Product FAQs
            if ($request->has('faqs')) {
                $faqs = is_string($request->faqs) ? json_decode($request->faqs, true) : $request->faqs;
                if (is_array($faqs)) {
                    foreach ($faqs as $index => $faq) {
                        if (!empty($faq['question']) || !empty($faq['answer'])) {
                            $product->faqs()->create([
                                'question'   => $faq['question'] ?? '',
                                'answer'     => $faq['answer'] ?? '',
                                'sort_order' => isset($faq['sort_order']) ? (int)$faq['sort_order'] : $index,
                            ]);
                        }
                    }
                }
            }

            // Save Product Applications
            if ($request->has('applications')) {
                $apps = is_string($request->applications) ? json_decode($request->applications, true) : $request->applications;
                if (is_array($apps)) {
                    foreach ($apps as $index => $appItem) {
                        if (!empty($appItem['title'])) {
                            $imagePath = $appItem['bg_image'] ?? $appItem['image'] ?? null;
                            $uploadedFile = $request->file("applications.{$index}.bg_image_file") 
                                ?? ($request->file('applications')[$index]['bg_image_file'] ?? null);

                            if ($uploadedFile) {
                                $filename = 'app_' . $index . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
                                $imagePath = $uploadedFile->storeAs("product/{$product->id}/applications", $filename, 'public');
                            }

                            $product->applications()->create([
                                'title'       => $appItem['title'] ?? '',
                                'description' => $appItem['description'] ?? '',
                                'badge'       => $appItem['badge'] ?? null,
                                'image'       => $imagePath,
                                'bg_image'    => $imagePath,
                                'grid_width'  => $appItem['grid_width'] ?? ($index === 0 ? 'col-lg-8' : ($index === 1 ? 'col-lg-4' : 'col-12')),
                                'sort_order'  => isset($appItem['sort_order']) ? (int)$appItem['sort_order'] : $index,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return ApiResponse::success($product->load(['productOptions', 'productAttributes', 'images', 'description', 'freeDelivery', 'specials', 'categories', 'relatedProducts', 'boughtTogether']), 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to create product', 500, [$e->getMessage()]);
        }
    }

    /**
     * Retrieve a single product.
     */
    public function show($id)
    {
        $product = Product::with([
            'productOptions',
            'productAttributes',
            'images',
            'brand',
            'description',
            'overview',
            'freeDelivery',
            'specials',
            'relatedProducts',
            'boughtTogether',
            'categories',
            'faqs',
            'applications'

        ])->findOrFail($id);

        return ApiResponse::success($product, 'Product retrieved successfully');
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        foreach (['category_ids', 'related_ids', 'bought_together_ids', 'options', 'attributes', 'deleted_images', 'deleted_files'] as $field) {
            if ($request->has($field) && is_string($request->input($field))) {
                $request->merge([$field => json_decode($request->input($field), true)]);
            }
        }

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'model'               => 'required|string|max:255',
            'product_code'        => 'nullable|string|max:255',
            'brand_id'            => 'nullable|integer|exists:brands,id',
            'price'               => 'required|numeric|min:0',
            'quantity'            => 'required|integer|min:0',
            'featured'            => 'nullable|in:0,1,true,false',
            'status'              => 'nullable|in:0,1,true,false',
            'date_available'      => 'nullable|date',
            'weight'              => 'nullable|numeric|min:0',
            'length'              => 'nullable|numeric|min:0',
            'width'               => 'nullable|numeric|min:0',
            'height'              => 'nullable|numeric|min:0',
            'sort_order'          => 'nullable|integer|min:0',

            // Image
            'main_image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // Arrays for relations
            'options'             => 'nullable|array',
            'attributes'          => 'nullable|array',
            'gallery_images'      => 'nullable|array',
            'gallery_images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deleted_images'      => 'nullable|array', // array of IDs to delete

            // New fields
            'slug'                => 'nullable|string|max:255',
            'description'         => 'nullable|string',
            'tag'                 => 'nullable|string|max:255',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:255',
            'meta_keyword'        => 'nullable|string|max:255',
            'video'               => 'nullable|string|max:255',
            'special_price'       => 'nullable|numeric|min:0',
            'special_start_date'  => 'nullable|date',
            'special_end_date'    => 'nullable|date',
            'product_free_delivery' => 'nullable|in:0,1,true,false',
            'documentation_pdf'   => 'nullable|file|mimes:pdf|max:5120',
            'safety_pdf'          => 'nullable|file|mimes:pdf|max:5120',
            'instructions_pdf'    => 'nullable|file|mimes:pdf|max:5120',
            'description_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'category_ids'        => 'nullable|array',
            'related_ids'         => 'nullable|array',
            'bought_together_ids' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name'                => $validated['name'],
                'model'               => $validated['model'],
                'product_code'        => $validated['product_code'] ?? null,
                'brand_id'            => $validated['brand_id'] ?? null,
                'price'               => $validated['price'],
                'quantity'            => $validated['quantity'],
                'featured'            => filter_var($validated['featured'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'status'              => filter_var($validated['status'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'date_available'      => $validated['date_available'] ?? null,
                'weight'              => $validated['weight'] ?? 0.0000,
                'length'              => $validated['length'] ?? 0.0000,
                'width'               => $validated['width'] ?? 0.0000,
                'height'              => $validated['height'] ?? 0.0000,
                'sort_order'          => $validated['sort_order'] ?? 0,
                'alt_name'            => $validated['name'],
                'updatedBy'           => Auth::id(),
            ];

            if (!empty($validated['slug'])) {
                $baseSlug = Str::slug($validated['slug']);
                $slug = $baseSlug;
                $count = 1;
                while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }
                $updateData['slug'] = $slug;
            }

            // Handle Main Image Update
            if ($request->hasFile('main_image')) {
                // Delete old
                if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                    Storage::disk('public')->delete($product->main_image);
                }
                $file = $request->file('main_image');
                $filename = Str::slug($product->name) . '.' . $file->getClientOriginalExtension();
                $updateData['main_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }

            $product->update($updateData);

            // Handle description update
            $descData = [
                'description'      => $request->input('description'),
                'tag'              => $request->input('tag'),
                'meta_title'       => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword'     => $request->input('meta_keyword'),
                'video'            => $request->input('video'),

                // Specifications Section Fields (Section 2)
                'specs_badge'          => $request->input('specs_badge'),
                'specs_title'          => $request->input('specs_title'),
                'specs_description'    => $request->input('specs_description'),
                'specs_image'          => $request->input('specs_image'),
                'spec1_icon'           => $request->input('spec1_icon'),
                'spec1_badge'          => $request->input('spec1_badge'),
                'spec1_value'          => $request->input('spec1_value'),
                'spec1_unit'           => $request->input('spec1_unit'),
                'spec1_desc'           => $request->input('spec1_desc'),
                'spec2_icon'           => $request->input('spec2_icon'),
                'spec2_badge'          => $request->input('spec2_badge'),
                'spec2_value'          => $request->input('spec2_value'),
                'spec2_unit'           => $request->input('spec2_unit'),
                'spec2_desc'           => $request->input('spec2_desc'),
                'spec3_icon'           => $request->input('spec3_icon'),
                'spec3_badge'          => $request->input('spec3_badge'),
                'spec3_value'          => $request->input('spec3_value'),
                'spec3_unit'           => $request->input('spec3_unit'),
                'spec3_desc'           => $request->input('spec3_desc'),
                'spec4_icon'           => $request->input('spec4_icon'),
                'spec4_badge'          => $request->input('spec4_badge'),
                'spec4_value'          => $request->input('spec4_value'),
                'spec4_unit'           => $request->input('spec4_unit'),
                'spec4_desc'           => $request->input('spec4_desc'),

                // Features Section Fields (Section 3)
                'features_badge'       => $request->input('features_badge'),
                'features_title'       => $request->input('features_title'),
                'features_description' => $request->input('features_description'),
                'features_image'       => $request->input('features_image'),
                'feature1_icon'        => $request->input('feature1_icon'),
                'feature1_title'       => $request->input('feature1_title'),
                'feature1_desc'        => $request->input('feature1_desc'),
                'feature2_icon'        => $request->input('feature2_icon'),
                'feature2_title'       => $request->input('feature2_title'),
                'feature2_desc'        => $request->input('feature2_desc'),
                'feature3_icon'        => $request->input('feature3_icon'),
                'feature3_title'       => $request->input('feature3_title'),
                'feature3_desc'        => $request->input('feature3_desc'),

                // Applications Section Header
                'applications_title'       => $request->input('applications_title'),
                'applications_description' => $request->input('applications_description'),

                // Technology Section Fields
                'technology_badge'            => $request->input('technology_badge'),
                'technology_title'            => $request->input('technology_title'),
                'technology_description'      => $request->input('technology_description'),
                'technology_image'            => $request->input('technology_image'),
                'technology_card_title'       => $request->input('technology_card_title'),
                'technology_card_description' => $request->input('technology_card_description'),
                'tech_feature1_title'         => $request->input('tech_feature1_title'),
                'tech_feature1_desc'          => $request->input('tech_feature1_desc'),
                'tech_feature2_title'         => $request->input('tech_feature2_title'),
                'tech_feature2_desc'          => $request->input('tech_feature2_desc'),
                'tech_feature3_title'         => $request->input('tech_feature3_title'),
                'tech_feature3_desc'          => $request->input('tech_feature3_desc'),
            ];

            $productDesc = $product->description ?: new ProductDescription(['product_id' => $product->id]);

            // Handle deleted files
            $deletedFiles = $request->input('deleted_files') ? (is_array($request->input('deleted_files')) ? $request->input('deleted_files') : json_decode($request->input('deleted_files'), true)) : [];
            foreach ($deletedFiles as $fileField) {
                if (in_array($fileField, ['documentation_pdf', 'safety_pdf', 'instructions_pdf', 'description_image', 'specs_image', 'features_image', 'technology_image'])) {
                    if ($productDesc->$fileField && Storage::disk('public')->exists($productDesc->$fileField)) {
                        Storage::disk('public')->delete($productDesc->$fileField);
                    }
                    $descData[$fileField] = null;
                }
            }

            if ($request->hasFile('documentation_pdf')) {
                if ($productDesc->documentation_pdf && Storage::disk('public')->exists($productDesc->documentation_pdf)) {
                    Storage::disk('public')->delete($productDesc->documentation_pdf);
                }
                $file = $request->file('documentation_pdf');
                $filename = 'doc_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['documentation_pdf'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('safety_pdf')) {
                if ($productDesc->safety_pdf && Storage::disk('public')->exists($productDesc->safety_pdf)) {
                    Storage::disk('public')->delete($productDesc->safety_pdf);
                }
                $file = $request->file('safety_pdf');
                $filename = 'safety_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['safety_pdf'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('instructions_pdf')) {
                if ($productDesc->instructions_pdf && Storage::disk('public')->exists($productDesc->instructions_pdf)) {
                    Storage::disk('public')->delete($productDesc->instructions_pdf);
                }
                $file = $request->file('instructions_pdf');
                $filename = 'instruction_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['instructions_pdf'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('description_image')) {
                if ($productDesc->description_image && Storage::disk('public')->exists($productDesc->description_image)) {
                    Storage::disk('public')->delete($productDesc->description_image);
                }
                $file = $request->file('description_image');
                $filename = 'desc_img_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['description_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('specs_image')) {
                if ($productDesc->specs_image && Storage::disk('public')->exists($productDesc->specs_image)) {
                    Storage::disk('public')->delete($productDesc->specs_image);
                }
                $file = $request->file('specs_image');
                $filename = 'specs_bg_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['specs_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('features_image')) {
                if ($productDesc->features_image && Storage::disk('public')->exists($productDesc->features_image)) {
                    Storage::disk('public')->delete($productDesc->features_image);
                }
                $file = $request->file('features_image');
                $filename = 'feat_bg_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['features_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }
            if ($request->hasFile('technology_image')) {
                if ($productDesc->technology_image && Storage::disk('public')->exists($productDesc->technology_image)) {
                    Storage::disk('public')->delete($productDesc->technology_image);
                }
                $file = $request->file('technology_image');
                $filename = 'tech_' . time() . '.' . $file->getClientOriginalExtension();
                $descData['technology_image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }

            $product->description()->updateOrCreate([], $descData);

            // Save Overview
            $overviewData = [
                'title'          => $request->input('overview_title'),
                'description'    => $request->input('overview_description'),
                'feature1_icon'  => $request->input('overview_feature1_icon'),
                'feature1_title' => $request->input('overview_feature1_title'),
                'feature1_desc'  => $request->input('overview_feature1_desc'),
                'feature2_icon'  => $request->input('overview_feature2_icon'),
                'feature2_title' => $request->input('overview_feature2_title'),
                'feature2_desc'  => $request->input('overview_feature2_desc'),
                'hud_label1'     => $request->input('overview_hud_label1'),
                'hud_label2'     => $request->input('overview_hud_label2'),
                'hud_label3'     => $request->input('overview_hud_label3'),
            ];

            $productOverview = $product->overview ?: new \App\Models\ProductOverview(['product_id' => $product->id]);

            if (in_array('overview_image', $deletedFiles)) {
                if ($productOverview->image && Storage::disk('public')->exists($productOverview->image)) {
                    Storage::disk('public')->delete($productOverview->image);
                }
                $overviewData['image'] = null;
            }

            if ($request->hasFile('overview_image')) {
                if ($productOverview->image && Storage::disk('public')->exists($productOverview->image)) {
                    Storage::disk('public')->delete($productOverview->image);
                }
                $file = $request->file('overview_image');
                $filename = 'overview_' . time() . '.' . $file->getClientOriginalExtension();
                $overviewData['image'] = $file->storeAs("product/{$product->id}", $filename, 'public');
            }

            $product->overview()->updateOrCreate([], $overviewData);

            // Free Delivery
            $isFreeDelivery = filter_var($request->input('product_free_delivery') ?? 0, FILTER_VALIDATE_BOOLEAN);
            if ($isFreeDelivery) {
                $product->freeDelivery()->updateOrCreate([], ['sort_order' => 0]);
            } else {
                $product->freeDelivery()->delete();
            }

            // Specials
            $specialPrice = $request->input('special_price');
            if ($specialPrice !== null && $specialPrice !== '') {
                $product->specials()->updateOrCreate([], [
                    'special_price' => $specialPrice,
                    'start_date'    => $request->input('special_start_date'),
                    'end_date'      => $request->input('special_end_date'),
                ]);
            } else {
                $product->specials()->delete();
            }

            // Sync categories (multiple)
            $categoryIds = $request->input('category_ids') ? (is_array($request->input('category_ids')) ? $request->input('category_ids') : json_decode($request->input('category_ids'), true)) : [];
            $product->categories()->sync($categoryIds);

            // Sync related products
            $relatedIds = $request->input('related_ids') ? (is_array($request->input('related_ids')) ? $request->input('related_ids') : json_decode($request->input('related_ids'), true)) : [];
            $product->relatedProducts()->sync($relatedIds);

            // Sync bought together products
            $boughtTogetherIds = $request->input('bought_together_ids') ? (is_array($request->input('bought_together_ids')) ? $request->input('bought_together_ids') : json_decode($request->input('bought_together_ids'), true)) : [];
            $product->boughtTogether()->sync($boughtTogetherIds);

            // Sync Options (Delete old, insert new)
            $product->productOptions()->delete();
            if (!empty($validated['options'])) {
                $optionData = [];
                foreach ($validated['options'] as $opt) {
                    $optionData[] = [
                        'product_id'      => $product->id,
                        'option_id'       => $opt['option_id'],
                        'option_value_id' => $opt['option_value_id'],
                        'quantity'        => $opt['quantity'] ?? 0,
                        'subtract'        => filter_var($opt['subtract'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                        'price'           => $opt['price'] ?? null,
                        'price_prefix'    => $opt['price_prefix'] ?? '+',
                    ];
                }
                ProductOption::insert($optionData);
            }

            // Sync Attributes (Delete old, insert new)
            $product->productAttributes()->delete();
            $attributes = $validated['attributes'] ?? $request->input('attributes');
            if (is_string($attributes)) {
                $attributes = json_decode($attributes, true);
            }
            if (!empty($attributes) && is_array($attributes)) {
                $attributeData = [];
                $now = now();
                foreach ($attributes as $attr) {
                    if (!is_array($attr)) continue;
                    if (empty($attr['name']) || empty($attr['attribute_group_id'])) continue;
                    $attributeData[] = [
                        'product_id'         => $product->id,
                        'attribute_group_id' => (int) $attr['attribute_group_id'],
                        'name'               => trim($attr['name']),
                        'details'            => $attr['details'] ?? null,
                        'sort_order'         => isset($attr['sort_order']) ? (int) $attr['sort_order'] : 0,
                        'status'             => 1,
                        'createdBy'          => Auth::id(),
                        'updatedBy'          => Auth::id(),
                        'created_at'         => $now,
                        'updated_at'         => $now,
                    ];
                }
                if (!empty($attributeData)) {
                    ProductAttribute::insert($attributeData);
                }
            }

            // Handle deleted gallery images
            $deletedImageIds = $validated['deleted_images'] ?? $request->input('deleted_images');
            if (is_string($deletedImageIds)) {
                $decoded = json_decode($deletedImageIds, true);
                $deletedImageIds = is_array($decoded) ? $decoded : array_filter(explode(',', $deletedImageIds));
            }
            if (!empty($deletedImageIds) && is_array($deletedImageIds)) {
                $imagesToDelete = ProductImage::whereIn('id', $deletedImageIds)
                    ->where('product_id', $product->id)
                    ->get();
                foreach ($imagesToDelete as $img) {
                    if ($img->image && Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }
                    $img->delete();
                }
            }

            // Handle new gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $productImage = ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => '', // temp path
                        'alt_name'   => $product->name,
                        'createdBy'  => Auth::id(),
                        'updatedBy'  => Auth::id(),
                    ]);

                    $filename = Str::slug($product->name) . '-' . $productImage->id . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs("product/{$product->id}/gallery", $filename, 'public');
                    $productImage->update(['image' => $path]);
                }
            }


            // Save Product FAQs
            if ($request->has('faqs')) {
                $faqs = is_string($request->faqs) ? json_decode($request->faqs, true) : $request->faqs;
                $product->faqs()->delete();
                if (is_array($faqs)) {
                    foreach ($faqs as $index => $faq) {
                        if (!empty($faq['question']) || !empty($faq['answer'])) {
                            $product->faqs()->create([
                                'question'   => $faq['question'] ?? '',
                                'answer'     => $faq['answer'] ?? '',
                                'sort_order' => isset($faq['sort_order']) ? (int)$faq['sort_order'] : $index,
                            ]);
                        }
                    }
                }
            }

            // Save Product Applications
            if ($request->has('applications')) {
                $apps = is_string($request->applications) ? json_decode($request->applications, true) : $request->applications;
                $product->applications()->delete();
                if (is_array($apps)) {
                    foreach ($apps as $index => $appItem) {
                        if (!empty($appItem['title'])) {
                            $imagePath = $appItem['bg_image'] ?? $appItem['image'] ?? null;
                            $uploadedFile = $request->file("applications.{$index}.bg_image_file") 
                                ?? ($request->file('applications')[$index]['bg_image_file'] ?? null);

                            if ($uploadedFile) {
                                $filename = 'app_' . $index . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
                                $imagePath = $uploadedFile->storeAs("product/{$product->id}/applications", $filename, 'public');
                            }

                            $product->applications()->create([
                                'title'       => $appItem['title'] ?? '',
                                'description' => $appItem['description'] ?? '',
                                'badge'       => $appItem['badge'] ?? null,
                                'image'       => $imagePath,
                                'bg_image'    => $imagePath,
                                'grid_width'  => $appItem['grid_width'] ?? ($index === 0 ? 'col-lg-8' : ($index === 1 ? 'col-lg-4' : 'col-12')),
                                'sort_order'  => isset($appItem['sort_order']) ? (int)$appItem['sort_order'] : $index,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return ApiResponse::success($product->load(['productOptions', 'productAttributes', 'images', 'description', 'freeDelivery', 'specials', 'categories', 'relatedProducts', 'boughtTogether', 'faqs', 'applications']), 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update product', 500, [$e->getMessage()]);
        }
    }

    /**
     * Bulk update product status.
     */
    public function bulkStatus(Request $request)
    {
        $validated = $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'integer|exists:products,id',
            'status'        => 'required|in:0,1'
        ]);

        Product::whereIn('id', $validated['product_ids'])->update([
            'status'    => $validated['status'],
            'updatedBy' => Auth::id()
        ]);

        return ApiResponse::success(null, 'Status updated successfully for selected products');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'integer|exists:products,id'
        ]);

        $products = Product::with('images')->whereIn('id', $validated['product_ids'])->get();

        foreach ($products as $product) {
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
            }

            $images = $product->images;
            foreach ($images as $img) {
                if ($img->image && Storage::disk('public')->exists($img->image)) {
                    Storage::disk('public')->delete($img->image);
                }
            }

            $product->delete();
        }

        return ApiResponse::success(null, 'Selected products deleted successfully');
    }

    /**
     * Copy a product.
     */
    public function copy(Request $request)
    {
        $validated = $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'integer|exists:products,id'
        ]);

        try {
            DB::beginTransaction();

            foreach ($validated['product_ids'] as $pid) {
                $original = Product::with(['productOptions', 'productAttributes', 'images', 'description', 'freeDelivery', 'specials', 'categories', 'relatedProducts', 'boughtTogether'])->findOrFail($pid);

                $newProduct = $original->replicate();
                $newProduct->name = 'Copy of ' . $original->name;
                $newProduct->status = 0; // Inactive by default
                $newProduct->createdBy = Auth::id();
                $newProduct->updatedBy = Auth::id();

                if ($original->main_image && Storage::disk('public')->exists($original->main_image)) {
                    $newProduct->save(); // Save first to get the ID
                    $originalExt = pathinfo($original->main_image, PATHINFO_EXTENSION);
                    $newMainImageFilename = Str::slug($newProduct->name) . '.' . $originalExt;
                    $newMainImagePath = "product/{$newProduct->id}/{$newMainImageFilename}";

                    Storage::disk('public')->copy($original->main_image, $newMainImagePath);
                    $newProduct->update(['main_image' => $newMainImagePath]);
                } else {
                    $newProduct->main_image = null;
                    $newProduct->save();
                }

                // Copy description
                if ($original->description) {
                    $newDesc = $original->description->replicate();
                    $newDesc->product_id = $newProduct->id;

                    // Physical copy of files
                    if ($original->description->documentation_pdf && Storage::disk('public')->exists($original->description->documentation_pdf)) {
                        $ext = pathinfo($original->description->documentation_pdf, PATHINFO_EXTENSION);
                        $filename = 'doc_' . time() . '.' . $ext;
                        $newPath = "product/{$newProduct->id}/{$filename}";
                        Storage::disk('public')->copy($original->description->documentation_pdf, $newPath);
                        $newDesc->documentation_pdf = $newPath;
                    }
                    if ($original->description->safety_pdf && Storage::disk('public')->exists($original->description->safety_pdf)) {
                        $ext = pathinfo($original->description->safety_pdf, PATHINFO_EXTENSION);
                        $filename = 'safety_' . time() . '.' . $ext;
                        $newPath = "product/{$newProduct->id}/{$filename}";
                        Storage::disk('public')->copy($original->description->safety_pdf, $newPath);
                        $newDesc->safety_pdf = $newPath;
                    }
                    if ($original->description->instructions_pdf && Storage::disk('public')->exists($original->description->instructions_pdf)) {
                        $ext = pathinfo($original->description->instructions_pdf, PATHINFO_EXTENSION);
                        $filename = 'instruction_' . time() . '.' . $ext;
                        $newPath = "product/{$newProduct->id}/{$filename}";
                        Storage::disk('public')->copy($original->description->instructions_pdf, $newPath);
                        $newDesc->instructions_pdf = $newPath;
                    }
                    if ($original->description->description_image && Storage::disk('public')->exists($original->description->description_image)) {
                        $ext = pathinfo($original->description->description_image, PATHINFO_EXTENSION);
                        $filename = 'desc_img_' . time() . '.' . $ext;
                        $newPath = "product/{$newProduct->id}/{$filename}";
                        Storage::disk('public')->copy($original->description->description_image, $newPath);
                        $newDesc->description_image = $newPath;
                    }

                    $newDesc->save();
                }

                // Copy freeDelivery
                if ($original->freeDelivery) {
                    $newFree = $original->freeDelivery->replicate();
                    $newFree->product_id = $newProduct->id;
                    $newFree->save();
                }

                // Copy specials
                foreach ($original->specials as $spec) {
                    $newSpec = $spec->replicate();
                    $newSpec->product_id = $newProduct->id;
                    $newSpec->save();
                }

                // Copy pivot categories
                $newProduct->categories()->sync($original->categories->pluck('id'));

                // Copy pivot related products
                $newProduct->relatedProducts()->sync($original->relatedProducts->pluck('id'));

                // Copy pivot bought together products
                $newProduct->boughtTogether()->sync($original->boughtTogether->pluck('id'));

                // Copy Options
                $newOptionsData = [];
                foreach ($original->productOptions as $opt) {
                    $newOpt = $opt->toArray();
                    unset($newOpt['id'], $newOpt['created_at'], $newOpt['updated_at']);
                    $newOpt['product_id'] = $newProduct->id;
                    $newOptionsData[] = $newOpt;
                }
                if (!empty($newOptionsData)) {
                    ProductOption::insert($newOptionsData);
                }

                // Copy Attributes
                $newAttributesData = [];
                foreach ($original->productAttributes as $attr) {
                    $newAttr = $attr->toArray();
                    unset($newAttr['id'], $newAttr['created_at'], $newAttr['updated_at']);
                    $newAttr['product_id'] = $newProduct->id;
                    $newAttr['createdBy'] = Auth::id();
                    $newAttr['updatedBy'] = Auth::id();
                    $newAttributesData[] = $newAttr;
                }
                if (!empty($newAttributesData)) {
                    ProductAttribute::insert($newAttributesData);
                }

                // Copy Images (physically copy file and set new product_image id)
                foreach ($original->images as $img) {
                    if ($img->image && Storage::disk('public')->exists($img->image)) {
                        $newImg = $img->replicate();
                        $newImg->product_id = $newProduct->id;
                        $newImg->image = ''; // temp
                        $newImg->createdBy = Auth::id();
                        $newImg->updatedBy = Auth::id();
                        $newImg->save();

                        $imgExt = pathinfo($img->image, PATHINFO_EXTENSION);
                        $newImgFilename = Str::slug($newProduct->name) . '-' . $newImg->id . '.' . $imgExt;
                        $newImgPath = "product/{$newProduct->id}/gallery/{$newImgFilename}";

                        Storage::disk('public')->copy($img->image, $newImgPath);
                        $newImg->update(['image' => $newImgPath]);
                    }
                }
            }

            // Save Product FAQs
            if ($request->has('faqs')) {
                $faqs = is_string($request->faqs) ? json_decode($request->faqs, true) : $request->faqs;
                if (is_array($faqs)) {
                    foreach ($faqs as $index => $faq) {
                        if (!empty($faq['question']) || !empty($faq['answer'])) {
                            $product->faqs()->create([
                                'question'   => $faq['question'] ?? '',
                                'answer'     => $faq['answer'] ?? '',
                                'sort_order' => isset($faq['sort_order']) ? (int)$faq['sort_order'] : $index,
                            ]);
                        }
                    }
                }
            }

            // Update Product Applications
            if ($request->has('applications')) {
                $apps = is_string($request->applications) ? json_decode($request->applications, true) : $request->applications;
                $product->applications()->delete();
                if (is_array($apps)) {
                    foreach ($apps as $index => $appItem) {
                        if (!empty($appItem['title'])) {
                            $product->applications()->create([
                                'title'       => $appItem['title'] ?? '',
                                'description' => $appItem['description'] ?? '',
                                'badge'       => $appItem['badge'] ?? null,
                                'image'       => $appItem['image'] ?? $appItem['bg_image'] ?? null,
                                'bg_image'    => $appItem['bg_image'] ?? $appItem['image'] ?? null,
                                'grid_width'  => $appItem['grid_width'] ?? ($index === 0 ? 'col-lg-8' : ($index === 1 ? 'col-lg-4' : 'col-12')),
                                'sort_order'  => isset($appItem['sort_order']) ? (int)$appItem['sort_order'] : $index,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return ApiResponse::success(null, 'Products copied successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to copy products', 500, [$e->getMessage()]);
        }
    }

    /**
     * Toggle the status (active/inactive).
     */
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = $product->status == 1 ? 0 : 1;
        $product->updatedBy = Auth::id();
        $product->save();

        return ApiResponse::success([
            'status' => $product->status,
        ], $product->status == 1 ? 'Product active' : 'Product inactive');
    }

    /**
     * Delete a product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
            Storage::disk('public')->delete($product->main_image);
        }

        $images = $product->images;
        foreach ($images as $img) {
            if ($img->image && Storage::disk('public')->exists($img->image)) {
                Storage::disk('public')->delete($img->image);
            }
        }

        $product->delete();

        return ApiResponse::success(null, 'Product deleted successfully');
    }
}
