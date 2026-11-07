<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDescription;
use App\Models\ProductShowcase;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheRevalidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);
    }

    /**
     * Test updating a product invalidates product detail, landing, and catalog caches.
     */
    public function test_product_update_invalidates_product_and_catalog_caches(): void
    {
        $product = Product::create([
            'name'     => 'Aire Fresh Purifier X1',
            'slug'     => 'aire-fresh-purifier-x1',
            'model'    => 'AFP-X1',
            'price'    => 450.00,
            'quantity' => 15,
            'status'   => 1,
        ]);

        // Prime cache keys
        Cache::put("product_detail_{$product->slug}", 'cached_detail', 3600);
        Cache::put("product_landing_{$product->slug}", 'cached_landing', 3600);
        Cache::put("product_detail_{$product->id}", 'cached_detail_id', 3600);
        Cache::put("product_landing_{$product->id}", 'cached_landing_id', 3600);
        Cache::put("product_related_{$product->id}", 'cached_related', 3600);
        Cache::put('catalog_categories_tree_v4', 'cached_tree', 3600);
        Cache::put('catalog_category_slug_v4_products', 'cached_root_cat', 3600);
        Cache::put(Product::HOME_SECTIONS_CACHE_KEY, 'cached_home', 3600);

        // Verify they are initially cached
        $this->assertTrue(Cache::has("product_detail_{$product->slug}"));
        $this->assertTrue(Cache::has('catalog_category_slug_v4_products'));

        // Trigger cache invalidation via model save
        $product->update(['price' => 499.00]);

        // Assert all specific and catalog caches were cleared
        $this->assertFalse(Cache::has("product_detail_{$product->slug}"));
        $this->assertFalse(Cache::has("product_landing_{$product->slug}"));
        $this->assertFalse(Cache::has("product_detail_{$product->id}"));
        $this->assertFalse(Cache::has("product_landing_{$product->id}"));
        $this->assertFalse(Cache::has("product_related_{$product->id}"));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));
        $this->assertFalse(Cache::has('catalog_category_slug_v4_products'));
        $this->assertFalse(Cache::has(Product::HOME_SECTIONS_CACHE_KEY));
    }

    /**
     * Test updating product showcase busts root 'products' page and all ancestor category caches.
     */
    public function test_showcase_update_busts_root_products_and_ancestor_category_caches(): void
    {
        // 1. Root category: 'products'
        $rootCategory = ProductCategory::create([
            'category_name' => 'Products',
            'slug'          => 'products',
            'status'        => 1,
            'parent_id'     => null,
        ]);

        // 2. Child category: 'fresh-air-systems'
        $childCategory = ProductCategory::create([
            'category_name' => 'Fresh Air Systems',
            'slug'          => 'fresh-air-systems',
            'status'        => 1,
            'parent_id'     => $rootCategory->id,
        ]);

        // 3. Product assigned to the child category
        $product = Product::create([
            'name'     => 'Fresh Air Unit 200',
            'slug'     => 'fresh-air-unit-200',
            'model'    => 'FAU-200',
            'price'    => 750.00,
            'quantity' => 8,
            'status'   => 1,
        ]);
        $product->categories()->attach($childCategory->id);

        // Prime cache keys for child category, root category, and category tree
        Cache::put("catalog_category_slug_v4_{$childCategory->slug}", 'cached_child_category', 3600);
        Cache::put("catalog_category_slug_v4_{$rootCategory->slug}", 'cached_root_category', 3600);
        Cache::put('catalog_categories_tree_v4', 'cached_tree', 3600);

        $this->assertTrue(Cache::has("catalog_category_slug_v4_{$childCategory->slug}"));
        $this->assertTrue(Cache::has("catalog_category_slug_v4_{$rootCategory->slug}"));

        // Save showcase details for this product
        ProductShowcase::create([
            'product_id'        => $product->id,
            'title'             => 'Single Room Ductless Pro',
            'subtitle'          => 'Updated high-performance ventilator',
            'series_badge'      => 'AIRE HEPA Plus',
            'badge_residential' => 'Residential',
            'badge_fresh_air'   => 'Fresh Air',
            'airflow'           => '350 m³/h',
            'power'             => '45W',
            'coverage_area'     => '40–70 m²',
        ]);

        // Assert BOTH child category AND root 'products' page caches are invalidated!
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$childCategory->slug}"));
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$rootCategory->slug}"));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));
    }

    /**
     * Test updating a category busts its ancestors, children, and tree caches.
     */
    public function test_category_update_busts_ancestor_and_tree_caches(): void
    {
        $root = ProductCategory::create([
            'category_name' => 'Commercial Solutions',
            'slug'          => 'commercial-solutions',
            'status'        => 1,
            'parent_id'     => null,
        ]);

        $sub = ProductCategory::create([
            'category_name' => 'Hospital Ventilation',
            'slug'          => 'hospital-ventilation',
            'status'        => 1,
            'parent_id'     => $root->id,
        ]);

        // Prime caches
        Cache::put("catalog_category_slug_v4_{$root->slug}", 'cached_root', 3600);
        Cache::put("catalog_category_slug_v4_{$sub->slug}", 'cached_sub', 3600);
        Cache::put('catalog_categories_tree_v4', 'cached_tree', 3600);
        Cache::put('catalog_category_slug_v4_products', 'cached_products_root', 3600);

        // Update subcategory
        $sub->update(['category_name' => 'Hospital & Clinic Ventilation']);

        // Assert all were invalidated
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$root->slug}"));
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$sub->slug}"));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));
        $this->assertFalse(Cache::has('catalog_category_slug_v4_products'));
    }

    /**
     * Test updating product description automatically clears product detail cache.
     */
    public function test_product_description_update_invalidates_cache(): void
    {
        $product = Product::create([
            'name'     => 'HEPA Air Filter Core',
            'slug'     => 'hepa-air-filter-core',
            'model'    => 'HAFC-10',
            'price'    => 120.00,
            'quantity' => 50,
            'status'   => 1,
        ]);

        Cache::put("product_detail_{$product->slug}", 'cached_detail', 3600);
        Cache::put("product_landing_{$product->slug}", 'cached_landing', 3600);

        ProductDescription::create([
            'product_id'       => $product->id,
            'name'             => 'HEPA Air Filter Core Pro',
            'description'      => 'Detailed filter specs and air efficiency ratings.',
            'meta_title'       => 'Buy HEPA Air Filter Core',
            'meta_description' => 'High efficiency particulate air filter core.',
        ]);

        $this->assertFalse(Cache::has("product_detail_{$product->slug}"));
        $this->assertFalse(Cache::has("product_landing_{$product->slug}"));
    }

    /**
     * Test bulk cache invalidation without specific product clears all category slugs.
     */
    public function test_bulk_product_cache_invalidation_clears_all_categories(): void
    {
        $cat1 = ProductCategory::create(['category_name' => 'Cat One', 'slug' => 'cat-one', 'status' => 1]);
        $cat2 = ProductCategory::create(['category_name' => 'Cat Two', 'slug' => 'cat-two', 'status' => 1]);

        Cache::put("catalog_category_slug_v4_{$cat1->slug}", 'cache_1', 3600);
        Cache::put("catalog_category_slug_v4_{$cat2->slug}", 'cache_2', 3600);
        Cache::put('catalog_category_slug_v4_products', 'cache_products', 3600);
        Cache::put('catalog_categories_tree_v4', 'cache_tree', 3600);

        // Call bulk / null clear
        Product::clearProductCache(null);

        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$cat1->slug}"));
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$cat2->slug}"));
        $this->assertFalse(Cache::has('catalog_category_slug_v4_products'));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));
    }

    /**
     * Test product deletion triggers ProductCategory::clearCategoryCache() and purges category and product caches.
     */
    public function test_product_deletion_invalidates_all_category_and_product_caches(): void
    {
        $rootCategory = ProductCategory::create([
            'category_name' => 'Products',
            'slug'          => 'products',
            'status'        => 1,
            'parent_id'     => null,
        ]);

        $childCategory = ProductCategory::create([
            'category_name' => 'Fresh Air Systems',
            'slug'          => 'fresh-air-systems',
            'status'        => 1,
            'parent_id'     => $rootCategory->id,
        ]);

        $product = Product::create([
            'name'     => 'Air Master 500',
            'slug'     => 'air-master-500',
            'model'    => 'AM-500',
            'price'    => 1200.00,
            'quantity' => 10,
            'status'   => 1,
        ]);
        $product->categories()->attach([$rootCategory->id, $childCategory->id]);

        // Prime cache keys
        Cache::put("product_detail_{$product->slug}", 'cached_detail', 3600);
        Cache::put("product_landing_{$product->slug}", 'cached_landing', 3600);
        Cache::put("catalog_category_slug_v4_{$childCategory->slug}", 'cached_child_category', 3600);
        Cache::put("catalog_category_slug_v4_{$rootCategory->slug}", 'cached_root_category', 3600);
        Cache::put('catalog_categories_tree_v4', 'cached_tree', 3600);

        $this->assertTrue(Cache::has("product_detail_{$product->slug}"));
        $this->assertTrue(Cache::has("catalog_category_slug_v4_{$childCategory->slug}"));
        $this->assertTrue(Cache::has("catalog_category_slug_v4_{$rootCategory->slug}"));
        $this->assertTrue(Cache::has('catalog_categories_tree_v4'));

        // Delete product
        $product->delete();

        // Assert all category slug and tree caches are purged immediately
        $this->assertFalse(Cache::has("product_detail_{$product->slug}"));
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$childCategory->slug}"));
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$rootCategory->slug}"));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));
    }
}
