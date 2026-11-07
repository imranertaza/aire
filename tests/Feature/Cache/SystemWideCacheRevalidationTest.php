<?php

namespace Tests\Feature\Cache;

use App\Models\CategoryFeaturedProduct;
use App\Models\FilterOption;
use App\Models\FilterOptionValue;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductAttributeGroup;
use App\Models\ProductCategory;
use App\Models\ProductDescription;
use App\Models\ProductLanding;
use App\Models\ProductShowcase;
use App\Models\Section;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\Slider;
use App\Models\Store;
use App\Models\User;
use App\Services\Admin\AdvancedProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SystemWideCacheRevalidationTest extends TestCase
{
    use RefreshDatabase;

    protected Store $store;
    protected \App\Models\User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->store = Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->user = \App\Models\User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin_cache_test@aire.test',
            'password' => bcrypt('password123'),
        ]);
    }

    /**
     * 1. Test Product Lifecycle Cache Invalidation
     */
    public function test_product_lifecycle_clears_all_related_product_and_storefront_caches(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Fresh Air Unit 500',
            'slug'     => 'fresh-air-unit-500',
            'model'    => 'FAU-500',
            'price'    => 899.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        // Prime cache
        Cache::put("product_detail_{$product->slug}", 'cached_detail', 3600);
        Cache::put("product_landing_{$product->slug}", 'cached_landing', 3600);
        Cache::put("product_related_{$product->id}", 'cached_related', 3600);
        Cache::put('catalog_categories_tree_v4', 'cached_tree', 3600);
        Cache::put('catalog_category_slug_v4_products', 'cached_products_root', 3600);
        Cache::put(Product::HOME_SECTIONS_CACHE_KEY, 'cached_home', 3600);

        // Update product price
        $product->update(['price' => 950.00]);

        $this->assertFalse(Cache::has("product_detail_{$product->slug}"));
        $this->assertFalse(Cache::has("product_landing_{$product->slug}"));
        $this->assertFalse(Cache::has("product_related_{$product->id}"));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));
        $this->assertFalse(Cache::has('catalog_category_slug_v4_products'));
        $this->assertFalse(Cache::has(Product::HOME_SECTIONS_CACHE_KEY));
    }

    /**
     * 2. Test Product Showcase Saved and Deleted Hooks
     */
    public function test_product_showcase_invalidates_ancestor_and_root_categories(): void
    {
        $rootCat = ProductCategory::create([
            'category_name' => 'Products',
            'slug'          => 'products',
            'status'        => 1,
            'parent_id'     => null,
        ]);

        $subCat = ProductCategory::create([
            'category_name' => 'Air Purifiers',
            'slug'          => 'air-purifiers',
            'status'        => 1,
            'parent_id'     => $rootCat->id,
        ]);

        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'HEPA Air Purifier Pro',
            'slug'     => 'hepa-air-purifier-pro',
            'model'    => 'HAP-PRO',
            'price'    => 350.00,
            'quantity' => 20,
            'status'   => 1,
        ]);
        $product->categories()->attach($subCat->id);

        // Prime caches
        Cache::put("catalog_category_slug_v4_{$subCat->slug}", 'cached_sub', 3600);
        Cache::put("catalog_category_slug_v4_{$rootCat->slug}", 'cached_root', 3600);
        Cache::put('catalog_categories_tree_v4', 'cached_tree', 3600);

        // Create showcase
        $showcase = ProductShowcase::create([
            'product_id'        => $product->id,
            'title'             => 'Single Room Purifier',
            'subtitle'          => 'Clean indoor air guaranteed',
            'series_badge'      => 'AIRPRO HEPA',
            'badge_residential' => 'Residential',
            'badge_fresh_air'   => 'Small Fresh Air',
            'airflow'           => '280 m³/h',
            'power'             => '35W',
            'coverage_area'     => '25–50 m²',
        ]);

        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$subCat->slug}"));
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$rootCat->slug}"));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));

        // Prime again to test delete hook
        Cache::put("catalog_category_slug_v4_{$rootCat->slug}", 'cached_root_again', 3600);
        $showcase->delete();
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$rootCat->slug}"));
    }

    /**
     * 3. Test Product Landing Saved and Deleted Hooks
     */
    public function test_product_landing_lifecycle_invalidates_product_cache(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Flagship Ventilator S9',
            'slug'     => 'flagship-ventilator-s9',
            'model'    => 'FV-S9',
            'price'    => 1200.00,
            'quantity' => 5,
            'status'   => 1,
        ]);

        Cache::put("product_landing_{$product->slug}", 'cached_landing', 3600);
        Cache::put("product_detail_{$product->slug}", 'cached_detail', 3600);

        $landing = ProductLanding::create([
            'product_id'        => $product->id,
            'hero_title'        => 'Revolutionary Fresh Air Experience',
            'hero_description'  => 'Engineered with hospital grade filtration.',
            'status'            => 1,
        ]);

        $this->assertFalse(Cache::has("product_landing_{$product->slug}"));
        $this->assertFalse(Cache::has("product_detail_{$product->slug}"));

        // Delete hook
        Cache::put("product_landing_{$product->slug}", 'cached_landing_2', 3600);
        $landing->delete();
        $this->assertFalse(Cache::has("product_landing_{$product->slug}"));
    }

    /**
     * 4. Test Product Description Saved and Deleted Hooks
     */
    public function test_product_description_lifecycle_invalidates_product_cache(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Commercial Exhaust Unit',
            'slug'     => 'commercial-exhaust-unit',
            'model'    => 'CEU-100',
            'price'    => 2500.00,
            'quantity' => 2,
            'status'   => 1,
        ]);

        Cache::put("product_detail_{$product->slug}", 'cached_detail', 3600);

        $desc = ProductDescription::create([
            'product_id'       => $product->id,
            'description'      => 'Industrial grade high airflow exhaust unit.',
            'meta_title'       => 'Buy Commercial Exhaust Unit',
            'meta_description' => 'Best commercial exhaust for clean air standards.',
        ]);

        $this->assertFalse(Cache::has("product_detail_{$product->slug}"));

        // Delete hook
        Cache::put("product_detail_{$product->slug}", 'cached_detail_2', 3600);
        $desc->delete();
        $this->assertFalse(Cache::has("product_detail_{$product->slug}"));
    }

    /**
     * 5. Test Category Featured Product Cache Invalidation
     */
    public function test_category_featured_product_lifecycle_invalidates_category_cache(): void
    {
        $category = ProductCategory::create([
            'category_name' => 'Featured Solutions',
            'slug'          => 'featured-solutions',
            'status'        => 1,
        ]);

        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Featured Clean Air Unit',
            'slug'     => 'featured-clean-air-unit',
            'model'    => 'FCAU-1',
            'price'    => 500.00,
            'quantity' => 10,
            'status'   => 1,
        ]);

        Cache::put("catalog_category_slug_v4_{$category->slug}", 'cached_cat', 3600);
        Cache::put('catalog_categories_tree_v4', 'cached_tree', 3600);

        $featured = CategoryFeaturedProduct::create([
            'category_id' => $category->id,
            'product_id'  => $product->id,
            'position'    => 'top',
            'sort_order'  => 0,
        ]);

        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$category->slug}"));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));

        // Delete hook
        Cache::put("catalog_category_slug_v4_{$category->slug}", 'cached_cat_2', 3600);
        $featured->delete();
        $this->assertFalse(Cache::has("catalog_category_slug_v4_{$category->slug}"));
    }

    /**
     * 6. Test Sections (CMS Dynamic Content) Lifecycle Cache Invalidation
     */
    public function test_section_lifecycle_invalidates_all_section_and_storefront_caches(): void
    {
        // Prime caches
        Cache::put('all_sections', 'cached_all_sections', 3600);
        Cache::put('storefront_about_sections_v1', 'cached_about_sections', 3600);
        Cache::put('section_hero_banner', 'cached_hero_banner', 3600);
        Cache::put('section_home_hero_banner', 'cached_home_hero_banner', 3600);
        Cache::put(Product::HOME_SECTIONS_CACHE_KEY, 'cached_home_sections', 3600);

        $section = Section::create([
            'name'   => 'hero_banner',
            'title'  => 'Experience Pure Air',
            'status' => 1,
            'data'   => ['tagline' => 'Next-gen ventilation systems'],
        ]);

        $this->assertFalse(Cache::has('all_sections'));
        $this->assertFalse(Cache::has('storefront_about_sections_v1'));
        $this->assertFalse(Cache::has('section_hero_banner'));
        $this->assertFalse(Cache::has('section_home_hero_banner'));
        $this->assertFalse(Cache::has(Product::HOME_SECTIONS_CACHE_KEY));

        // Delete hook
        Cache::put('section_hero_banner', 'cached_hero_again', 3600);
        $section->delete();
        $this->assertFalse(Cache::has('section_hero_banner'));
    }

    /**
     * 7. Test Slider Lifecycle Cache Invalidation
     */
    public function test_slider_lifecycle_invalidates_placement_and_sidebar_ad_caches(): void
    {
        Cache::put('sliders_all_active', 'cached_all_sliders', 3600);
        Cache::put('filter_ad_sliders', 'cached_filter_ad_sliders', 3600);
        Cache::put('storefront_about_ads_v1', 'cached_about_ads', 3600);
        Cache::put('sliders_home_hero', 'cached_home_hero', 3600);
        Cache::put('sliders_placement_home_hero', 'cached_placement_home_hero', 3600);

        $slider = Slider::create([
            'title'   => 'Spring Fresh Air Promo',
            'key'     => 'home_hero, category_sidebar',
            'image'   => 'sliders/spring_promo.jpg',
            'enabled' => 1,
            'order'   => 1,
        ]);

        $this->assertFalse(Cache::has('sliders_all_active'));
        $this->assertFalse(Cache::has('filter_ad_sliders'));
        $this->assertFalse(Cache::has('storefront_about_ads_v1'));
        $this->assertFalse(Cache::has('sliders_home_hero'));
        $this->assertFalse(Cache::has('sliders_placement_home_hero'));

        // Delete hook
        Cache::put('sliders_home_hero', 'cached_home_hero_2', 3600);
        $slider->delete();
        $this->assertFalse(Cache::has('sliders_home_hero'));
    }

    /**
     * 8. Test News and News Categories Lifecycle Cache Invalidation
     */
    public function test_news_lifecycle_invalidates_storefront_news_caches(): void
    {
        Cache::put('storefront_about_news_v1', 'cached_about_news', 3600);
        Cache::put('storefront_news_featured_v1', 'cached_featured_news', 3600);
        Cache::put('storefront_news_categories_v1', 'cached_news_cats', 3600);
        Cache::put('storefront_news_detail_clean-air-2026', 'cached_news_detail', 3600);

        $news = News::create([
            'news_title'  => 'Clean Air 2026 Standards',
            'slug'        => 'clean-air-2026',
            'short_des'   => 'Short overview of new air standards.',
            'f_image'     => 'news/featured.jpg',
            'description' => 'New standards for indoor ventilation and air quality.',
            'status'      => 1,
            'createdBy'   => $this->user->id,
        ]);

        $this->assertFalse(Cache::has('storefront_about_news_v1'));
        $this->assertFalse(Cache::has('storefront_news_featured_v1'));
        $this->assertFalse(Cache::has('storefront_news_categories_v1'));
        $this->assertFalse(Cache::has('storefront_news_detail_clean-air-2026'));

        // News Category
        Cache::put('storefront_news_categories_v1', 'cached_news_cats_again', 3600);
        $cat = NewsCategory::create([
            'category_name' => 'Technology',
            'slug'          => 'technology',
            'status'        => '1',
            'createdBy'     => $this->user->id,
        ]);
        $this->assertFalse(Cache::has('storefront_news_categories_v1'));
    }

    /**
     * 9. Test CMS Page Lifecycle Cache Invalidation
     */
    public function test_page_lifecycle_invalidates_cms_page_and_layout_menu_caches(): void
    {
        Cache::put('layout_legal_pages_menu_v1', 'cached_legal_menu', 3600);
        Cache::put('active_legal_sidebar_pages_v1', 'cached_legal_sidebar', 3600);
        Cache::put('cms_page_privacy-policy', 'cached_privacy_page', 3600);

        $page = Page::create([
            'page_title' => 'Privacy Policy',
            'breadcrumb' => 'Privacy Policy',
            'slug'       => 'privacy-policy',
            'status'     => 1,
            'createdBy'  => $this->user->id,
        ]);

        $this->assertFalse(Cache::has('layout_legal_pages_menu_v1'));
        $this->assertFalse(Cache::has('active_legal_sidebar_pages_v1'));
        $this->assertFalse(Cache::has('cms_page_privacy-policy'));

        // Delete hook
        Cache::put('cms_page_privacy-policy', 'cached_privacy_page_2', 3600);
        $page->delete();
        $this->assertFalse(Cache::has('cms_page_privacy-policy'));
    }

    /**
     * 10. Test AdvancedProductService Bulk Actions Invalidate Cache
     */
    public function test_advanced_product_service_bulk_updates_invalidate_cache(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Smart Air Monitor M1',
            'slug'     => 'smart-air-monitor-m1',
            'model'    => 'SAM-M1',
            'price'    => 150.00,
            'quantity' => 30,
            'status'   => 1,
        ]);

        Cache::put("product_detail_{$product->id}", 'cached_pid_detail', 3600);
        Cache::put('filter_steps_data_v9', 'cached_filter_steps', 3600);
        Cache::put('catalog_categories_tree_v4', 'cached_categories_tree', 3600);

        /** @var AdvancedProductService $service */
        $service = app(AdvancedProductService::class);
        $service->bulkUpdateStatus([$product->id], 'status', 1);

        $this->assertFalse(Cache::has("product_detail_{$product->id}"));
        $this->assertFalse(Cache::has('filter_steps_data_v9'));
        $this->assertFalse(Cache::has('catalog_categories_tree_v4'));
    }

    /**
     * 11. Test Filter Options and Values Lifecycle Cache Invalidation
     */
    public function test_filter_option_and_value_lifecycle_invalidates_filter_caches(): void
    {
        Cache::put('all_filter_options', 'cached_filter_options', 3600);
        Cache::put('filter_all_option_values_v1', 'cached_option_values', 3600);
        Cache::put('filter_budget_option_v1', 'cached_budget_opt', 3600);
        Cache::put('filter_active_db_options', 'cached_active_db_opt', 3600);
        Cache::put('filter_steps_data_v9', 'cached_steps', 3600);

        $option = FilterOption::create([
            'name'       => 'Room Size',
            'type'       => 'checkbox',
            'sort_order' => 1,
            'status'     => 1,
        ]);

        $this->assertFalse(Cache::has('all_filter_options'));
        $this->assertFalse(Cache::has('filter_all_option_values_v1'));
        $this->assertFalse(Cache::has('filter_budget_option_v1'));
        $this->assertFalse(Cache::has('filter_active_db_options'));
        $this->assertFalse(Cache::has('filter_steps_data_v9'));

        // Test FilterOptionValue
        Cache::put('filter_all_option_values_v1', 'cached_option_values_2', 3600);
        Cache::put('filter_steps_data_v9', 'cached_steps_2', 3600);

        $optionValue = FilterOptionValue::create([
            'filter_option_id' => $option->id,
            'name'             => '500-1000 sq ft',
            'sort_order'       => 1,
            'status'           => 1,
        ]);

        $this->assertFalse(Cache::has('filter_all_option_values_v1'));
        $this->assertFalse(Cache::has('filter_steps_data_v9'));

        // Delete hook
        Cache::put('filter_all_option_values_v1', 'cached_option_values_3', 3600);
        $optionValue->delete();
        $this->assertFalse(Cache::has('filter_all_option_values_v1'));
    }

    /**
     * 12. Test Menu and MenuItem Lifecycle Cache Invalidation
     */
    public function test_menu_and_menu_item_lifecycle_invalidates_navigation_caches(): void
    {
        Cache::put('layout_main_header_menu_v1', 'cached_header_menu', 3600);
        Cache::put('layout_footer_menus_v1', 'cached_footer_menu', 3600);
        Cache::put('layout_footer_legal_menu_v1', 'cached_legal_menu', 3600);
        Cache::put('layout_legal_pages_menu_v1', 'cached_legal_pages', 3600);

        $menu = Menu::create([
            'name'     => 'Header Primary Nav',
            'position' => 'header',
            'enabled'  => 1,
        ]);

        $this->assertFalse(Cache::has('layout_main_header_menu_v1'));
        $this->assertFalse(Cache::has('layout_footer_menus_v1'));
        $this->assertFalse(Cache::has('layout_footer_legal_menu_v1'));
        $this->assertFalse(Cache::has('layout_legal_pages_menu_v1'));

        // Test MenuItem creation and update
        Cache::put('layout_main_header_menu_v1', 'cached_header_menu_again', 3600);

        $menuItem = MenuItem::create([
            'menu_id'   => $menu->id,
            'name'      => 'Solutions',
            'link_type' => 'url',
            'url'       => '/solutions',
            'enabled'   => 1,
            'order'     => 1,
        ]);

        $this->assertFalse(Cache::has('layout_main_header_menu_v1'));

        // Delete hook
        Cache::put('layout_main_header_menu_v1', 'cached_header_menu_del', 3600);
        $menuItem->delete();
        $this->assertFalse(Cache::has('layout_main_header_menu_v1'));
    }

    /**
     * 13. Test Setting Lifecycle Cache Invalidation
     */
    public function test_setting_lifecycle_invalidates_settings_cache(): void
    {
        Cache::put('settings', ['site_name' => 'Aire Old'], 3600);
        Cache::put('aire_popular_searches_list', ['purifier', 'hepa'], 3600);

        $setting = Setting::create([
            'label'     => 'site_name',
            'title'     => 'Site Name',
            'value'     => 'Aire Clean Air Systems',
            'createdBy' => $this->user->id,
            'updatedBy' => $this->user->id,
        ]);

        $this->assertFalse(Cache::has('settings'));
        $this->assertFalse(Cache::has('aire_popular_searches_list'));

        // Update hook
        Cache::put('settings', ['site_name' => 'Aire Updated'], 3600);
        $setting->update(['value' => 'Aire Technologies']);
        $this->assertFalse(Cache::has('settings'));

        // Delete hook
        Cache::put('settings', ['site_name' => 'Aire Del'], 3600);
        $setting->delete();
        $this->assertFalse(Cache::has('settings'));
    }

    /**
     * 14. Test ShippingMethod Lifecycle Cache Invalidation
     */
    public function test_shipping_method_lifecycle_invalidates_shipping_caches(): void
    {
        Cache::put('all_shipping_methods', 'cached_all_shipping', 3600);
        Cache::put('active_shipping_methods', 'cached_active_shipping', 3600);

        $shipping = ShippingMethod::create([
            'name'   => 'Standard Express Delivery',
            'code'   => 'express',
            'status' => 1,
        ]);

        $this->assertFalse(Cache::has('all_shipping_methods'));
        $this->assertFalse(Cache::has('active_shipping_methods'));

        // Update hook
        Cache::put('all_shipping_methods', 'cached_all_shipping_2', 3600);
        $shipping->update(['status' => 0]);
        $this->assertFalse(Cache::has('all_shipping_methods'));

        // Delete hook
        Cache::put('active_shipping_methods', 'cached_active_shipping_3', 3600);
        $shipping->delete();
        $this->assertFalse(Cache::has('active_shipping_methods'));
    }

    /**
     * 15. Test User Lifecycle Cache Invalidation
     */
    public function test_user_lifecycle_invalidates_auth_and_profile_caches(): void
    {
        Cache::put("user_{$this->user->id}", 'cached_user_model', 3600);
        Cache::put("admin_me_{$this->user->id}", 'cached_admin_profile', 3600);

        $this->user->update(['name' => 'Updated Admin Name']);

        $this->assertFalse(Cache::has("user_{$this->user->id}"));
        $this->assertFalse(Cache::has("admin_me_{$this->user->id}"));
    }

    /**
     * 16. Test ProductAttributeGroup Lifecycle Cache Invalidation
     */
    public function test_product_attribute_group_lifecycle_invalidates_attribute_caches(): void
    {
        Cache::put('all_attribute_groups', 'cached_attribute_groups', 3600);

        $group = ProductAttributeGroup::create([
            'name'       => 'Technical Specifications',
            'sort_order' => 1,
            'status'     => 1,
        ]);

        $this->assertFalse(Cache::has('all_attribute_groups'));

        // Delete hook
        Cache::put('all_attribute_groups', 'cached_attribute_groups_2', 3600);
        $group->delete();
        $this->assertFalse(Cache::has('all_attribute_groups'));
    }
}

