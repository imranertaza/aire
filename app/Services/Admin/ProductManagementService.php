<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductFilterOption;
use App\Models\ProductImage;
use App\Models\ProductLanding;
use App\Models\ProductOption;
use App\Models\ProductShowcase;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductManagementService
{
    public function __construct(
        protected ProductMediaService $mediaService
    ) {}

    /**
     * Retrieve paginated products list for admin.
     */
    public function listProducts(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::with(['brand', 'categories'])
            ->search($filters['search'] ?? null);

        // 3-Level Category Filtering: Level 3 (Child) > Level 2 (Sub) > Level 1 (Parent) > Category ID
        $categoryId = $filters['level3_id'] ?? $filters['level2_id'] ?? $filters['level1_id'] ?? $filters['category_id'] ?? null;
        if (!empty($categoryId)) {
            $ids = ProductCategory::getCategoryAndDescendantIds((int) $categoryId);
            $query->whereHas('categories', function ($q) use ($ids) {
                $q->whereIn('product_categories.id', $ids);
            });
        }

        return $query->latest('id')->paginate($perPage)->onEachSide(1);
    }

    /**
     * Retrieve dropdown products list.
     */
    public function dropdownList(?string $search = null, ?int $categoryId = null, ?int $limit = 500): Collection
    {
        $query = Product::select('id', 'name', 'model', 'price', 'main_image', 'status');

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

        if ($limit) {
            $query->limit($limit);
        }

        return $query->orderBy('name')->get();
    }

    /**
     * Find a product with all relations for edit / view.
     */
    public function getProductWithRelations(int $id): Product
    {
        return Product::withAdminRelations()->findOrFail($id);
    }

    /**
     * Create a new product with all its relations and media.
     */
    public function createProduct(array $validated, Request $request): Product
    {
        return DB::transaction(function () use ($validated, $request) {
            $store = Store::where('is_default', 1)->first() ?: Store::first();
            $storeId = $store ? $store->id : 1;

            $product = Product::create([
                'store_id'       => $storeId,
                'name'           => $validated['name'],
                'slug'           => !empty($validated['slug']) ? Str::slug($validated['slug']) : null,
                'model'          => $validated['model'],
                'product_code'   => $validated['product_code'] ?? null,
                'brand_id'       => $validated['brand_id'] ?? null,
                'price'          => $validated['price'],
                'quantity'       => $validated['quantity'],
                'featured'       => filter_var($validated['featured'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'status'         => filter_var($validated['status'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'date_available' => $validated['date_available'] ?? null,
                'weight'         => $validated['weight'] ?? 0.0000,
                'length'         => $validated['length'] ?? 0.0000,
                'width'          => $validated['width'] ?? 0.0000,
                'height'         => $validated['height'] ?? 0.0000,
                'sort_order'     => $validated['sort_order'] ?? 0,
                'main_image'     => null,
                'alt_name'       => $validated['name'],
                'createdBy'      => Auth::id(),
                'updatedBy'      => Auth::id(),
            ]);

            // 1. Main & Quick View Images
            if ($request->hasFile('main_image')) {
                $this->mediaService->saveMainImage($request->file('main_image'), $product);
            }
            if ($request->hasFile('quickview_image')) {
                $this->mediaService->saveQuickviewImage($request->file('quickview_image'), $product);
            }

            // 2. Description
            $this->saveDescription($product, $request, $validated);

            // 3. Overview
            $this->saveOverview($product, $request);

            // 4. Free Delivery
            if (filter_var($request->input('product_free_delivery') ?? 0, FILTER_VALIDATE_BOOLEAN)) {
                $product->freeDelivery()->create(['sort_order' => 0]);
            }

            // 5. Specials
            $specialPrice = $request->input('special_price');
            if ($specialPrice !== null && $specialPrice !== '') {
                $product->specials()->create([
                    'special_price' => $specialPrice,
                    'start_date'    => $request->input('special_start_date') ?: Carbon::now()->toDateString(),
                    'end_date'      => $request->input('special_end_date') ?: Carbon::now()->addYears(5)->toDateString(),
                ]);
            }

            // 6. Pivots
            $this->syncPivots($product, $request);

            // 7. Options & Filters
            $this->saveOptions($product, $validated['options'] ?? []);
            $this->saveFilterOptions($product, $validated['filter_options'] ?? []);

            // 8. Attributes
            $this->saveAttributes($product, $validated['attributes'] ?? $request->input('attributes'));

            // 9. Gallery Images & Videos
            if ($request->hasFile('gallery_images')) {
                $galleryFiles = $request->file('gallery_images');
                $galleryFiles = is_array($galleryFiles) ? $galleryFiles : [$galleryFiles];
                $gallerySortOrders = $request->input('gallery_sort_orders', []);
                if (is_string($gallerySortOrders)) {
                    $gallerySortOrders = json_decode($gallerySortOrders, true) ?: [];
                }
                $this->mediaService->saveGalleryImages($galleryFiles, $product, is_array($gallerySortOrders) ? $gallerySortOrders : []);
            }

            $galleryVideos = $request->input('gallery_videos', []);
            if (is_string($galleryVideos)) {
                $galleryVideos = json_decode($galleryVideos, true) ?: [];
            }
            if (!empty($galleryVideos) && is_array($galleryVideos)) {
                $this->mediaService->saveGalleryVideos($galleryVideos, $product);
            }

            // 10. FAQs & Applications
            $this->saveFaqs($product, $request->input('faqs'));
            $this->saveApplications($product, $request);

            // 11. Showcase
            $this->saveShowcase($product, $request);

            // 12. Landing Page
            $this->saveLandingPage($product, $request);

            Product::clearProductCache($product);

            return $product->load([
                'productOptions',
                'productFilterOptions',
                'productAttributes',
                'images',
                'description',
                'freeDelivery',
                'specials',
                'categories',
                'relatedProducts',
                'boughtTogether',
                'faqs',
                'applications',
                'productLanding',
                'showcase'
            ]);
        });
    }

    /**
     * Update an existing product and its relations.
     */
    public function updateProduct(Product $product, array $validated, Request $request): Product
    {
        return DB::transaction(function () use ($product, $validated, $request) {
            $deletedFiles = $request->input('deleted_files') ?: [];
            if (is_string($deletedFiles)) {
                $deletedFiles = json_decode($deletedFiles, true) ?: [];
            }

            // 1. Core Fields
            $product->update([
                'name'           => $validated['name'],
                'slug'           => !empty($validated['slug']) ? Str::slug($validated['slug']) : $product->slug,
                'model'          => $validated['model'],
                'product_code'   => $validated['product_code'] ?? null,
                'brand_id'       => $validated['brand_id'] ?? null,
                'price'          => $validated['price'],
                'quantity'       => $validated['quantity'],
                'featured'       => filter_var($validated['featured'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'status'         => filter_var($validated['status'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'date_available' => $validated['date_available'] ?? null,
                'weight'         => $validated['weight'] ?? 0.0000,
                'length'         => $validated['length'] ?? 0.0000,
                'width'          => $validated['width'] ?? 0.0000,
                'height'         => $validated['height'] ?? 0.0000,
                'sort_order'     => $validated['sort_order'] ?? 0,
                'alt_name'       => $validated['name'],
                'updatedBy'      => Auth::id(),
            ]);

            // 2. Main Image
            if ($request->hasFile('main_image')) {
                $this->mediaService->saveMainImage($request->file('main_image'), $product);
            } elseif (in_array('main_image', $deletedFiles)) {
                $this->mediaService->deleteFile($product->main_image);
                $product->update(['main_image' => null]);
            }

            // Quick View Image
            if ($request->hasFile('quickview_image')) {
                $this->mediaService->saveQuickviewImage($request->file('quickview_image'), $product);
            } elseif (in_array('quickview_image', $deletedFiles)) {
                $this->mediaService->deleteFile($product->quickview_image);
                $product->update(['quickview_image' => null]);
            }

            // 3. Description
            $this->updateDescription($product, $request, $deletedFiles, $validated);

            // 4. Overview
            $this->updateOverview($product, $request, $deletedFiles);

            // 5. Free Delivery
            $isFreeDelivery = filter_var($request->input('product_free_delivery') ?? 0, FILTER_VALIDATE_BOOLEAN);
            if ($isFreeDelivery) {
                $product->freeDelivery()->updateOrCreate([], ['sort_order' => 0]);
            } else {
                $product->freeDelivery()->delete();
            }

            // 6. Specials
            $specialPrice = $request->input('special_price');
            if ($specialPrice !== null && $specialPrice !== '') {
                $product->specials()->updateOrCreate([], [
                    'special_price' => $specialPrice,
                    'start_date'    => $request->input('special_start_date') ?: Carbon::now()->toDateString(),
                    'end_date'      => $request->input('special_end_date') ?: Carbon::now()->addYears(5)->toDateString(),
                ]);
            } else {
                $product->specials()->delete();
            }

            // 7. Pivots
            $this->syncPivots($product, $request);

            // 8. Options & Filters
            $product->productOptions()->delete();
            $this->saveOptions($product, $validated['options'] ?? []);

            $product->productFilterOptions()->delete();
            $this->saveFilterOptions($product, $validated['filter_options'] ?? []);

            // 9. Attributes
            $product->productAttributes()->delete();
            $this->saveAttributes($product, $validated['attributes'] ?? $request->input('attributes'));

            // 10. Gallery Images
            $deletedImages = $request->input('deleted_images');
            if (is_string($deletedImages)) {
                $deletedImages = json_decode($deletedImages, true);
            }
            if (!empty($deletedImages) && is_array($deletedImages)) {
                $this->mediaService->deleteGalleryImages($deletedImages, $product->id);
            }

            // Update existing images sort orders
            $existingSortOrders = $request->input('existing_image_sort_orders');
            if (is_string($existingSortOrders)) {
                $existingSortOrders = json_decode($existingSortOrders, true);
            }
            if (!empty($existingSortOrders) && is_array($existingSortOrders)) {
                $this->mediaService->updateGallerySortOrders($existingSortOrders, $product->id);
            }

            // 10. Gallery Images & Videos
            if ($request->hasFile('gallery_images')) {
                $galleryFiles = $request->file('gallery_images');
                $galleryFiles = is_array($galleryFiles) ? $galleryFiles : [$galleryFiles];
                $gallerySortOrders = $request->input('gallery_sort_orders', []);
                if (is_string($gallerySortOrders)) {
                    $gallerySortOrders = json_decode($gallerySortOrders, true) ?: [];
                }
                $this->mediaService->saveGalleryImages($galleryFiles, $product, is_array($gallerySortOrders) ? $gallerySortOrders : []);
            }

            $galleryVideos = $request->input('gallery_videos', []);
            if (is_string($galleryVideos)) {
                $galleryVideos = json_decode($galleryVideos, true) ?: [];
            }
            if (!empty($galleryVideos) && is_array($galleryVideos)) {
                $this->mediaService->saveGalleryVideos($galleryVideos, $product);
            }

            // 11. FAQs & Applications
            $this->updateFaqs($product, $request->input('faqs'));
            $this->updateApplications($product, $request);

            // 12. Landing Page & Showcase
            $this->updateLandingPage($product, $request, $deletedFiles);
            $this->updateShowcase($product, $request, $deletedFiles);

            Product::clearProductCache($product);

            return $product->refresh()->load([
                'productOptions',
                'productAttributes',
                'images',
                'description',
                'freeDelivery',
                'specials',
                'categories',
                'relatedProducts',
                'boughtTogether',
                'faqs',
                'applications',
                'productLanding',
                'showcase'
            ]);
        });
    }

    /**
     * Delete a single product and clean storage.
     */
    public function deleteProduct(Product $product): void
    {
        ProductCategory::clearCategoryCache();
        $this->mediaService->deleteProductDirectory($product->id);
        $product->delete();
        ProductCategory::clearCategoryCache();
    }

    /**
     * Bulk delete products.
     *
     * @param array<int> $productIds
     */
    public function bulkDelete(array $productIds): void
    {
        ProductCategory::clearCategoryCache();
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $this->deleteProduct($product);
        }

        ProductCategory::clearCategoryCache();
        Product::clearProductCache();
    }

    /**
     * Bulk update status for products.
     *
     * @param array<int> $productIds
     */
    public function bulkUpdateStatus(array $productIds, int $status): void
    {
        Product::whereIn('id', $productIds)->update([
            'status'    => $status,
            'updatedBy' => Auth::id(),
        ]);

        Product::clearProductCache();
        foreach ($productIds as $pid) {
            Cache::forget("product_detail_{$pid}");
            Cache::forget("product_landing_{$pid}");
            Cache::forget("product_related_{$pid}");
        }
    }

    /**
     * Toggle product status (active/inactive).
     */
    public function toggleStatus(Product $product): int
    {
        $newStatus = $product->status == 1 ? 0 : 1;
        $product->status = $newStatus;
        $product->updatedBy = Auth::id();
        $product->save();

        return $newStatus;
    }

    /**
     * Duplicate existing products and their media/relations.
     *
     * @param array<int> $productIds
     */
    public function copyProducts(array $productIds): void
    {
        DB::transaction(function () use ($productIds) {
            foreach ($productIds as $pid) {
                $original = Product::withReplicationRelations()->findOrFail($pid);

                $newProduct = $original->replicate(['slug']);
                $newProduct->name = 'Copy of ' . $original->name;
                $newProduct->slug = null;
                $newProduct->status = 0;
                $newProduct->createdBy = Auth::id();
                $newProduct->updatedBy = Auth::id();
                $newProduct->save();

                // 1. Copy Main Image
                if ($original->main_image) {
                    $originalExt = pathinfo($original->main_image, PATHINFO_EXTENSION);
                    $newMainImageFilename = Str::slug($newProduct->name) . '.' . $originalExt;
                    $newMainImagePath = $this->mediaService->copyFile($original->main_image, "product/{$newProduct->id}", $newMainImageFilename);
                    if ($newMainImagePath) {
                        $newProduct->update(['main_image' => $newMainImagePath]);
                    }
                }

                // 2. Copy Description & Auxiliary PDFs
                if ($original->description) {
                    $newDesc = $original->description->replicate();
                    $newDesc->product_id = $newProduct->id;

                    foreach (['documentation_pdf' => 'doc', 'safety_pdf' => 'safety', 'instructions_pdf' => 'instruction', 'description_image' => 'desc_img'] as $field => $prefix) {
                        if ($original->description->$field) {
                            $ext = pathinfo($original->description->$field, PATHINFO_EXTENSION);
                            $filename = "{$prefix}_" . time() . '.' . $ext;
                            $newPath = $this->mediaService->copyFile($original->description->$field, "product/{$newProduct->id}", $filename);
                            $newDesc->$field = $newPath;
                        }
                    }

                    $newDesc->save();
                }

                // 3. Copy Free Delivery & Specials
                if ($original->freeDelivery) {
                    $newFree = $original->freeDelivery->replicate();
                    $newFree->product_id = $newProduct->id;
                    $newFree->save();
                }

                foreach ($original->specials as $spec) {
                    $newSpec = $spec->replicate();
                    $newSpec->product_id = $newProduct->id;
                    $newSpec->save();
                }

                // 4. Copy Pivots
                $newProduct->categories()->sync($original->categories->pluck('id'));
                $newProduct->relatedProducts()->sync($original->relatedProducts->pluck('id'));
                $newProduct->boughtTogether()->sync($original->boughtTogether->pluck('id'));

                // 5. Copy Options
                $newOptions = [];
                foreach ($original->productOptions as $opt) {
                    $newOpt = $opt->toArray();
                    unset($newOpt['id'], $newOpt['created_at'], $newOpt['updated_at']);
                    $newOpt['product_id'] = $newProduct->id;
                    $newOptions[] = $newOpt;
                }
                if (!empty($newOptions)) {
                    ProductOption::insert($newOptions);
                }

                // 6. Copy Attributes
                $newAttributes = [];
                foreach ($original->productAttributes as $attr) {
                    $newAttr = $attr->toArray();
                    unset($newAttr['id'], $newAttr['created_at'], $newAttr['updated_at']);
                    $newAttr['product_id'] = $newProduct->id;
                    $newAttr['createdBy'] = Auth::id();
                    $newAttr['updatedBy'] = Auth::id();
                    $newAttributes[] = $newAttr;
                }
                if (!empty($newAttributes)) {
                    ProductAttribute::insert($newAttributes);
                }

                // 7. Copy Gallery Images
                foreach ($original->images as $img) {
                    if ($img->image && $this->mediaService->fileExists($img->image)) {
                        $newImg = $img->replicate();
                        $newImg->product_id = $newProduct->id;
                        $newImg->image = '';
                        $newImg->createdBy = Auth::id();
                        $newImg->updatedBy = Auth::id();
                        $newImg->save();

                        $imgExt = pathinfo($img->image, PATHINFO_EXTENSION);
                        $newImgFilename = Str::slug($newProduct->name) . '-' . $newImg->id . '.' . $imgExt;
                        $newImgPath = $this->mediaService->copyFile($img->image, "product/{$newProduct->id}/gallery", $newImgFilename);
                        if ($newImgPath) {
                            $newImg->update(['image' => $newImgPath]);
                        }
                    }
                }

                // 8. Copy FAQs, Applications, Showcase, Landing
                foreach ($original->faqs as $faq) {
                    $newFaq = $faq->replicate();
                    $newFaq->product_id = $newProduct->id;
                    $newFaq->save();
                }

                foreach ($original->applications as $app) {
                    $newApp = $app->replicate();
                    $newApp->product_id = $newProduct->id;
                    $newApp->save();
                }

                if ($original->showcase) {
                    $newShowcase = $original->showcase->replicate();
                    $newShowcase->product_id = $newProduct->id;
                    $newShowcase->save();
                }

                if ($original->productLanding) {
                    $newLanding = $original->productLanding->replicate();
                    $newLanding->product_id = $newProduct->id;
                    $newLanding->save();
                }
            }
        });
    }

    // =========================================================================
    // Internal Helper Methods
    // =========================================================================

    protected function syncPivots(Product $product, Request $request): void
    {
        $categories = $this->parseArrayInput($request->input('category_ids'));
        $product->categories()->sync($categories);

        $related = $this->parseArrayInput($request->input('related_ids'));
        $product->relatedProducts()->sync($related);

        $boughtTogether = $this->parseArrayInput($request->input('bought_together_ids'));
        $product->boughtTogether()->sync($boughtTogether);

        Product::clearProductCache($product);
    }

    protected function parseArrayInput(mixed $input): array
    {
        if (empty($input)) return [];
        if (is_array($input)) return $input;
        if (is_string($input)) return json_decode($input, true) ?: [];
        return [];
    }

    protected function saveOptions(Product $product, array $options): void
    {
        if (empty($options)) return;

        $optionData = [];
        foreach ($options as $opt) {
            if (empty($opt['option_id']) || empty($opt['option_value_id'])) continue;
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
        if (!empty($optionData)) {
            ProductOption::insert($optionData);
        }
    }

    protected function saveFilterOptions(Product $product, array $filterOptions): void
    {
        if (empty($filterOptions)) return;

        $filterOptionData = [];
        foreach ($filterOptions as $fOpt) {
            if (empty($fOpt['filter_option_id']) || empty($fOpt['filter_option_value_id'])) continue;
            $filterOptionData[] = [
                'product_id'             => $product->id,
                'filter_option_id'       => $fOpt['filter_option_id'],
                'filter_option_value_id' => $fOpt['filter_option_value_id'],
            ];
        }
        if (!empty($filterOptionData)) {
            ProductFilterOption::insert($filterOptionData);
        }
    }

    protected function saveAttributes(Product $product, mixed $attributes): void
    {
        if (is_string($attributes)) {
            $attributes = json_decode($attributes, true);
        }
        if (empty($attributes) || !is_array($attributes)) return;

        $attributeData = [];
        $now = now();
        foreach ($attributes as $attr) {
            if (!is_array($attr) || empty($attr['name']) || empty($attr['attribute_group_id'])) continue;
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

    protected function saveFaqs(Product $product, mixed $faqs): void
    {
        if (is_string($faqs)) {
            $faqs = json_decode($faqs, true);
        }
        if (empty($faqs) || !is_array($faqs)) return;

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

    protected function updateFaqs(Product $product, mixed $faqs): void
    {
        if (is_string($faqs)) {
            $faqs = json_decode($faqs, true);
        }
        $product->faqs()->delete();
        $this->saveFaqs($product, $faqs);
    }

    protected function saveApplications(Product $product, Request $request): void
    {
        $apps = $request->input('applications');
        if (is_string($apps)) {
            $apps = json_decode($apps, true);
        }
        if (empty($apps) || !is_array($apps)) return;

        foreach ($apps as $index => $appItem) {
            if (empty($appItem['title'])) continue;

            $imagePath = $appItem['bg_image'] ?? $appItem['image'] ?? null;
            $uploadedFile = $request->file("applications.{$index}.bg_image_file")
                ?? ($request->file('applications')[$index]['bg_image_file'] ?? null);

            if ($uploadedFile) {
                $imagePath = $this->mediaService->uploadAuxiliaryFile($uploadedFile, $product->id, 'applications', "app_{$index}");
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

    protected function updateApplications(Product $product, Request $request): void
    {
        $product->applications()->delete();
        $this->saveApplications($product, $request);
    }

    protected function saveDescription(Product $product, Request $request, array $validated = []): void
    {
        $descData = $this->extractDescriptionFields($request, $validated);

        foreach (['documentation_pdf' => 'doc', 'safety_pdf' => 'safety', 'instructions_pdf' => 'instruction', 'description_image' => 'desc_img', 'specs_image' => 'specs_bg', 'features_image' => 'feat_bg', 'technology_image' => 'tech', 'in_the_box_image' => 'box_bg'] as $fileField => $prefix) {
            if ($request->hasFile($fileField)) {
                $descData[$fileField] = $this->mediaService->uploadAuxiliaryFile($request->file($fileField), $product->id, '', $prefix);
            } elseif ($request->filled($fileField) && is_string($request->input($fileField))) {
                $descData[$fileField] = $request->input($fileField);
            }
        }

        $product->description()->create($descData);
    }

    protected function updateDescription(Product $product, Request $request, array $deletedFiles, array $validated = []): void
    {
        $descData = $this->extractDescriptionFields($request, $validated);
        $existing = $product->description;

        foreach (['documentation_pdf' => 'doc', 'safety_pdf' => 'safety', 'instructions_pdf' => 'instruction', 'description_image' => 'desc_img', 'specs_image' => 'specs_bg', 'features_image' => 'feat_bg', 'technology_image' => 'tech', 'in_the_box_image' => 'box_bg'] as $fileField => $prefix) {
            if (in_array($fileField, $deletedFiles)) {
                if ($existing && $existing->$fileField) {
                    $this->mediaService->deleteFile($existing->$fileField);
                }
                $descData[$fileField] = null;
            }

            if ($request->hasFile($fileField)) {
                if ($existing && $existing->$fileField) {
                    $this->mediaService->deleteFile($existing->$fileField);
                }
                $descData[$fileField] = $this->mediaService->uploadAuxiliaryFile($request->file($fileField), $product->id, '', $prefix);
            } elseif ($request->filled($fileField) && is_string($request->input($fileField))) {
                $descData[$fileField] = $request->input($fileField);
            }
        }

        $product->description()->updateOrCreate([], $descData);
    }

    protected function extractDescriptionFields(Request $request, array $validated = []): array
    {
        return [
            'description'          => $validated['description'] ?? $request->input('description'),
            'tag'                  => $validated['tag'] ?? $request->input('tag'),
            'meta_title'           => $validated['meta_title'] ?? $request->input('meta_title'),
            'meta_description'     => $validated['meta_description'] ?? $request->input('meta_description'),
            'meta_keyword'         => $validated['meta_keyword'] ?? $request->input('meta_keyword'),
            'video'                => $validated['video'] ?? $request->input('video'),
            'specs_badge'          => $request->input('specs_badge'),
            'specs_title'          => $request->input('specs_title'),
            'specs_description'    => $request->input('specs_description'),
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
            'features_badge'       => $request->input('features_badge'),
            'features_title'       => $request->input('features_title'),
            'features_description' => $request->input('features_description'),
            'feature1_icon'        => $request->input('feature1_icon'),
            'feature1_title'       => $request->input('feature1_title'),
            'feature1_desc'        => $request->input('feature1_desc'),
            'feature2_icon'        => $request->input('feature2_icon'),
            'feature2_title'       => $request->input('feature2_title'),
            'feature2_desc'        => $request->input('feature2_desc'),
            'feature3_icon'        => $request->input('feature3_icon'),
            'feature3_title'       => $request->input('feature3_title'),
            'feature3_desc'        => $request->input('feature3_desc'),
            'applications_title'       => $request->input('applications_title'),
            'applications_description' => $request->input('applications_description'),
            'technology_badge'            => $request->input('technology_badge'),
            'technology_title'            => $request->input('technology_title'),
            'technology_description'      => $request->input('technology_description'),
            'technology_card_title'       => $request->input('technology_card_title'),
            'technology_card_description' => $request->input('technology_card_description'),
            'tech_feature1_title'         => $request->input('tech_feature1_title'),
            'tech_feature1_desc'          => $request->input('tech_feature1_desc'),
            'tech_feature2_title'         => $request->input('tech_feature2_title'),
            'tech_feature2_desc'          => $request->input('tech_feature2_desc'),
            'tech_feature3_title'         => $request->input('tech_feature3_title'),
            'tech_feature3_desc'          => $request->input('tech_feature3_desc'),
            'in_the_box_badge'            => $request->input('in_the_box_badge'),
            'in_the_box_title'            => $request->input('in_the_box_title'),
            'in_the_box_description'      => $request->input('in_the_box_description'),
            'in_the_box_items'            => $this->normalizeInTheBoxItems($request->input('in_the_box_items')),
        ];
    }

    /**
     * Normalize in_the_box_items array or JSON string into a clean array.
     */
    protected function normalizeInTheBoxItems(mixed $items): ?array
    {
        if (is_string($items)) {
            $items = json_decode($items, true);
        }

        if (!is_array($items)) {
            return null;
        }

        $cleaned = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }
            $title = isset($item['title']) ? trim((string) $item['title']) : '';
            $desc = isset($item['description']) ? trim((string) $item['description']) : '';
            if ($title !== '' || $desc !== '') {
                $cleaned[] = [
                    'title'       => $title,
                    'description' => $desc,
                ];
            }
        }

        return !empty($cleaned) ? $cleaned : null;
    }

    protected function saveOverview(Product $product, Request $request): void
    {
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
            $overviewData['image'] = $this->mediaService->uploadAuxiliaryFile($request->file('overview_image'), $product->id, '', 'overview');
        }

        $product->overview()->create($overviewData);
    }

    protected function updateOverview(Product $product, Request $request, array $deletedFiles): void
    {
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

        $existing = $product->overview;

        if (in_array('overview_image', $deletedFiles)) {
            if ($existing && $existing->image) {
                $this->mediaService->deleteFile($existing->image);
            }
            $overviewData['image'] = null;
        }

        if ($request->hasFile('overview_image')) {
            if ($existing && $existing->image) {
                $this->mediaService->deleteFile($existing->image);
            }
            $overviewData['image'] = $this->mediaService->uploadAuxiliaryFile($request->file('overview_image'), $product->id, '', 'overview');
        }

        $product->overview()->updateOrCreate([], $overviewData);
    }

    protected function saveShowcase(Product $product, Request $request): void
    {
        $showcaseInputKeys = [
            'showcase_title', 'showcase_subtitle', 'showcase_modal_subtitle',
            'showcase_series_badge', 'showcase_badge_residential', 'showcase_badge_fresh_air',
            'showcase_diagram_brand', 'showcase_diagram_model', 'showcase_diagram_system',
            'showcase_airflow', 'showcase_power', 'showcase_coverage_area',
            'showcase_feature_pills', 'showcase_spec_highlights', 'showcase_matched_features',
            'showcase_health_tags', 'showcase_hero_bg_image', 'showcase_diagram_image'
        ];
        $hasShowcaseData = false;
        foreach ($showcaseInputKeys as $key) {
            if ($request->has($key)) {
                $hasShowcaseData = true;
                break;
            }
        }
        if (!$hasShowcaseData && !$request->hasFile('showcase_hero_bg_image_file') && !$request->hasFile('showcase_diagram_image_file')) {
            return;
        }

        $showcaseData = $this->extractShowcaseFields($request);

        if ($request->hasFile('showcase_hero_bg_image_file')) {
            $showcaseData['hero_bg_image'] = $this->mediaService->uploadAuxiliaryFile($request->file('showcase_hero_bg_image_file'), $product->id, 'showcase', 'showcase_hero');
        } elseif ($request->filled('showcase_hero_bg_image') && is_string($request->input('showcase_hero_bg_image'))) {
            $showcaseData['hero_bg_image'] = $request->input('showcase_hero_bg_image');
        }

        if ($request->hasFile('showcase_diagram_image_file')) {
            $showcaseData['diagram_image'] = $this->mediaService->uploadAuxiliaryFile($request->file('showcase_diagram_image_file'), $product->id, 'showcase', 'showcase_diag');
        } elseif ($request->filled('showcase_diagram_image') && is_string($request->input('showcase_diagram_image'))) {
            $showcaseData['diagram_image'] = $request->input('showcase_diagram_image');
        }

        $product->showcase()->create($showcaseData);
        Product::clearProductCache($product);
    }

    protected function updateShowcase(Product $product, Request $request, array $deletedFiles): void
    {
        $showcaseInputKeys = [
            'showcase_title', 'showcase_subtitle', 'showcase_modal_subtitle',
            'showcase_series_badge', 'showcase_badge_residential', 'showcase_badge_fresh_air',
            'showcase_diagram_brand', 'showcase_diagram_model', 'showcase_diagram_system',
            'showcase_airflow', 'showcase_power', 'showcase_coverage_area',
            'showcase_feature_pills', 'showcase_spec_highlights', 'showcase_matched_features',
            'showcase_health_tags', 'showcase_hero_bg_image', 'showcase_diagram_image'
        ];
        $hasShowcaseData = false;
        foreach ($showcaseInputKeys as $key) {
            if ($request->has($key)) {
                $hasShowcaseData = true;
                break;
            }
        }
        if (!$hasShowcaseData && !$request->hasFile('showcase_hero_bg_image_file') && !$request->hasFile('showcase_diagram_image_file') && !in_array('showcase_hero_bg_image', $deletedFiles) && !in_array('showcase_diagram_image', $deletedFiles)) {
            return;
        }

        $showcaseData = $this->extractShowcaseFields($request);
        $productShowcase = $product->showcase;

        if (in_array('showcase_hero_bg_image', $deletedFiles)) {
            if ($productShowcase && $productShowcase->hero_bg_image) {
                $this->mediaService->deleteFile($productShowcase->hero_bg_image);
            }
            $showcaseData['hero_bg_image'] = null;
        }
        if (in_array('showcase_diagram_image', $deletedFiles)) {
            if ($productShowcase && $productShowcase->diagram_image) {
                $this->mediaService->deleteFile($productShowcase->diagram_image);
            }
            $showcaseData['diagram_image'] = null;
        }

        if ($request->hasFile('showcase_hero_bg_image_file')) {
            if ($productShowcase && $productShowcase->hero_bg_image) {
                $this->mediaService->deleteFile($productShowcase->hero_bg_image);
            }
            $showcaseData['hero_bg_image'] = $this->mediaService->uploadAuxiliaryFile($request->file('showcase_hero_bg_image_file'), $product->id, 'showcase', 'showcase_hero');
        } elseif ($request->filled('showcase_hero_bg_image') && is_string($request->input('showcase_hero_bg_image'))) {
            $showcaseData['hero_bg_image'] = $request->input('showcase_hero_bg_image');
        }

        if ($request->hasFile('showcase_diagram_image_file')) {
            if ($productShowcase && $productShowcase->diagram_image) {
                $this->mediaService->deleteFile($productShowcase->diagram_image);
            }
            $showcaseData['diagram_image'] = $this->mediaService->uploadAuxiliaryFile($request->file('showcase_diagram_image_file'), $product->id, 'showcase', 'showcase_diag');
        } elseif ($request->filled('showcase_diagram_image') && is_string($request->input('showcase_diagram_image'))) {
            $showcaseData['diagram_image'] = $request->input('showcase_diagram_image');
        }

        $product->showcase()->updateOrCreate([], $showcaseData);
    }

    protected function extractShowcaseFields(Request $request): array
    {
        $featurePills = $request->input('showcase_feature_pills');
        $specHighlights = $request->input('showcase_spec_highlights');
        $matchedFeatures = $request->input('showcase_matched_features');
        $healthTags = $request->input('showcase_health_tags');

        return [
            'title'             => $request->input('showcase_title'),
            'subtitle'          => $request->input('showcase_subtitle'),
            'modal_subtitle'    => $request->input('showcase_modal_subtitle') ?? $request->input('modal_subtitle'),
            'series_badge'      => $request->input('showcase_series_badge'),
            'badge_residential' => $request->input('showcase_badge_residential', 'Residential'),
            'badge_fresh_air'   => $request->input('showcase_badge_fresh_air', 'Small Fresh Air'),
            'diagram_brand'     => $request->input('showcase_diagram_brand'),
            'diagram_model'     => $request->input('showcase_diagram_model'),
            'diagram_system'    => $request->input('showcase_diagram_system'),
            'airflow'           => $request->input('showcase_airflow'),
            'power'             => $request->input('showcase_power'),
            'coverage_area'     => $request->input('showcase_coverage_area'),
            'feature_pills'     => is_string($featurePills) ? json_decode($featurePills, true) : (is_array($featurePills) ? $featurePills : null),
            'spec_highlights'   => is_string($specHighlights) ? json_decode($specHighlights, true) : (is_array($specHighlights) ? $specHighlights : null),
            'matched_features'  => is_string($matchedFeatures) ? json_decode($matchedFeatures, true) : (is_array($matchedFeatures) ? $matchedFeatures : null),
            'health_tags'       => is_string($healthTags) ? json_decode($healthTags, true) : (is_array($healthTags) ? $healthTags : null),
        ];
    }

    protected function saveLandingPage(Product $product, Request $request): void
    {
        if (!$request->has('landing_enabled') && !$request->has('landing_status') && !$request->has('landing_hero_title') && !$request->has('landing_hero_tag')) {
            return;
        }

        $landingStatus = (int) ($request->input('landing_enabled') ?? $request->input('landing_status', 0));
        if ($landingStatus !== 1 && !$request->has('landing_hero_title')) {
            return;
        }

        $landingData = $this->extractLandingFields($request);
        $landingData['status'] = $landingStatus;

        foreach (['hero_image', 'science_image', 'lifestyle_image', 'filter_tech_image', 'specs_image'] as $imgKey) {
            $fileKey = "landing_{$imgKey}_file";
            $textKey = "landing_{$imgKey}";

            if ($request->hasFile($fileKey)) {
                $landingData[$imgKey] = $this->mediaService->uploadAuxiliaryFile($request->file($fileKey), $product->id, 'landing', $imgKey);
            } elseif ($request->filled($textKey) && is_string($request->input($textKey))) {
                $landingData[$imgKey] = $request->input($textKey);
            }
        }

        if ($request->hasFile('landing_specs_group_images') && is_array($landingData['specs_groups'])) {
            $groupImageFiles = $request->file('landing_specs_group_images');
            foreach ($groupImageFiles as $gIdx => $file) {
                if (isset($landingData['specs_groups'][$gIdx]) && $file) {
                    $landingData['specs_groups'][$gIdx]['image'] = $this->mediaService->uploadAuxiliaryFile($file, $product->id, 'landing', "specs_group_{$gIdx}");
                }
            }
        }

        $product->productLanding()->updateOrCreate([], $landingData);
    }

    protected function updateLandingPage(Product $product, Request $request, array $deletedFiles): void
    {
        if (!$request->has('landing_enabled') && !$request->has('landing_status') && !$request->has('landing_hero_title') && !$request->has('landing_hero_tag')) {
            return;
        }

        $landingStatus = (int) ($request->input('landing_enabled') ?? $request->input('landing_status', 0));
        if ($landingStatus === 1) {
            $landingData = $this->extractLandingFields($request);
            $landingData['status'] = 1;
            $landing = $product->productLanding ?: ProductLanding::firstOrNew(['product_id' => $product->id]);

            foreach (['hero_image', 'science_image', 'lifestyle_image', 'filter_tech_image', 'specs_image'] as $imgKey) {
                $fileKey = "landing_{$imgKey}_file";
                $textKey = "landing_{$imgKey}";

                if (in_array("landing_{$imgKey}", $deletedFiles)) {
                    if ($landing->$imgKey) {
                        $this->mediaService->deleteFile($landing->$imgKey);
                    }
                    $landingData[$imgKey] = null;
                }

                if ($request->hasFile($fileKey)) {
                    if ($landing->$imgKey) {
                        $this->mediaService->deleteFile($landing->$imgKey);
                    }
                    $landingData[$imgKey] = $this->mediaService->uploadAuxiliaryFile($request->file($fileKey), $product->id, 'landing', $imgKey);
                } elseif ($request->filled($textKey) && is_string($request->input($textKey))) {
                    $landingData[$imgKey] = $request->input($textKey);
                }
            }

            if ($request->hasFile('landing_specs_group_images') && is_array($landingData['specs_groups'])) {
                $groupImageFiles = $request->file('landing_specs_group_images');
                $existingGroups = $landing->specs_groups ?? [];
                foreach ($groupImageFiles as $gIdx => $file) {
                    if (isset($landingData['specs_groups'][$gIdx]) && $file) {
                        if (!empty($existingGroups[$gIdx]['image']) && !str_starts_with($existingGroups[$gIdx]['image'], 'http')) {
                            $this->mediaService->deleteFile($existingGroups[$gIdx]['image']);
                        }
                        $landingData['specs_groups'][$gIdx]['image'] = $this->mediaService->uploadAuxiliaryFile($file, $product->id, 'landing', "specs_group_{$gIdx}");
                    }
                }
            }

            $product->productLanding()->updateOrCreate([], $landingData);
        } else {
            ProductLanding::where('product_id', $product->id)->update(['status' => 0]);
        }
    }

    protected function extractLandingFields(Request $request): array
    {
        $scienceFeatures = $request->input('landing_science_features');
        $specsGroups = $request->input('landing_specs_groups');

        return [
            'hero_tag'                  => $request->input('landing_hero_tag') ?? $request->input('landing_hero_badge'),
            'hero_title'                => $request->input('landing_hero_title'),
            'hero_description'          => $request->input('landing_hero_description'),
            'hero_button_text'          => $request->input('landing_hero_button_text'),
            'hero_button_url'           => $request->input('landing_hero_button_url'),

            'science_tag'               => $request->input('landing_science_tag'),
            'science_title'             => $request->input('landing_science_title'),
            'science_description'       => $request->input('landing_science_description'),
            'science_stat1_value'       => $request->input('landing_science_stat1_value'),
            'science_stat1_label'       => $request->input('landing_science_stat1_label'),
            'science_stat2_value'       => $request->input('landing_science_stat2_value'),
            'science_stat2_label'       => $request->input('landing_science_stat2_label'),
            'science_features'          => is_string($scienceFeatures) ? json_decode($scienceFeatures, true) : (is_array($scienceFeatures) ? $scienceFeatures : null),

            'lifestyle_tag'             => $request->input('landing_lifestyle_tag'),
            'lifestyle_title'           => $request->input('landing_lifestyle_title'),
            'lifestyle_description'     => $request->input('landing_lifestyle_description'),
            'lifestyle_button_text'     => $request->input('landing_lifestyle_button_text'),
            'lifestyle_button_url'      => $request->input('landing_lifestyle_button_url'),

            'filter_tech_title'         => $request->input('landing_filter_tech_title'),
            'filter_tech_description'   => $request->input('landing_filter_tech_description'),
            'filter_tech_badge_text'    => $request->input('landing_filter_tech_badge_text'),

            'specs_title'               => $request->input('landing_specs_title'),
            'specs_subtitle'            => $request->input('landing_specs_subtitle') ?? $request->input('landing_specs_description'),
            'specs_button_text'         => $request->input('landing_specs_button_text'),
            'specs_button_url'          => $request->input('landing_specs_button_url'),
            'specs_groups'              => is_string($specsGroups) ? json_decode($specsGroups, true) : (is_array($specsGroups) ? $specsGroups : null),
        ];
    }
}
