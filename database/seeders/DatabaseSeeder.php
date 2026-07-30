<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Core & System Configuration Seeders
        $this->call(AdminSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(IconSeeder::class);

        // 2. CMS & Content Seeders
        $this->call(CategorySeeder::class);
        $this->call(PostSeeder::class);
        $this->call(CategoryMapSeeder::class);
        $this->call(NewsCategorySeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(NewsCategoryMapSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(EventCategorySeeder::class);
        $this->call(EventSeeder::class);
        $this->call(GallerySeeder::class);
        $this->call(GalleryDetailsSeeder::class);
        $this->call(NoticeSeeder::class);
        $this->call(ResultSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(CommitteeMemberSeeder::class);
        $this->call(PlayerSeeder::class);

        // 3. E-Commerce Prerequisites & Settings
        $this->call(BrandSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(OptionSeeder::class);
        $this->call(OptionValueSeeder::class);
        $this->call(ProductAttributeGroupSeeder::class);
        $this->call(ShippingMethodSeeder::class);
        $this->call(ShippingSettingsSeeder::class);
        $this->call(WeightShippingSettingsSeeder::class);
        $this->call(GeoZoneSeeder::class);
        $this->call(GeoZoneShippingRateSeeder::class);
        $this->call(PaymentMethodSeeder::class);

        // 4. Products & Catalog Details (depends on Store, Brand, ProductCategory, Option, OptionValue, ProductAttributeGroup)
        $this->call(ProductSeeder::class);
        $this->call(ProductAttributeSeeder::class);
        $this->call(ProductOptionSeeder::class);
        $this->call(ProductToCategorySeeder::class);

        // 5. Customers & Customer Interactions
        $this->call(CustomerSeeder::class);
        $this->call(ProductFeedbackSeeder::class);

        // 6. Coupons & Offers (depends on ProductCategory, Product, ShippingMethod)
        $this->call(CuponSeeder::class);
        $this->call(CouponCategorySeeder::class);
        $this->call(CouponProductSeeder::class);
        $this->call(CouponShippingSeeder::class);
        $this->call(OfferSeeder::class);

        // 7. Orders & Additional Modules (depends on Customer, Product, PaymentMethod)
        $this->call(OrderSeeder::class);
        $this->call(NewModulesSeeder::class);

        Artisan::call("optimize:clear");
    }
}
