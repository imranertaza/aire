<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_seeders_can_run_without_errors(): void
    {
        $seeders = [
            \Database\Seeders\AdminSeeder::class,
            \Database\Seeders\RolePermissionSeeder::class,
            \Database\Seeders\MenuSeeder::class,
            \Database\Seeders\PageSeeder::class,
            \Database\Seeders\MenuItemSeeder::class,
            \Database\Seeders\SettingsSeeder::class,
            \Database\Seeders\StoreSeeder::class,
            \Database\Seeders\ModuleSeeder::class,
            \Database\Seeders\IconSeeder::class,
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\PostSeeder::class,
            \Database\Seeders\CategoryMapSeeder::class,
            \Database\Seeders\NewsCategorySeeder::class,
            \Database\Seeders\NewsSeeder::class,
            \Database\Seeders\NewsCategoryMapSeeder::class,
            \Database\Seeders\BlogSeeder::class,
            \Database\Seeders\EventCategorySeeder::class,
            \Database\Seeders\EventSeeder::class,
            \Database\Seeders\GallerySeeder::class,
            \Database\Seeders\GalleryDetailsSeeder::class,
            \Database\Seeders\NoticeSeeder::class,
            \Database\Seeders\ResultSeeder::class,
            \Database\Seeders\SectionSeeder::class,
            \Database\Seeders\SliderSeeder::class,
            \Database\Seeders\CommitteeMemberSeeder::class,
            \Database\Seeders\PlayerSeeder::class,
            \Database\Seeders\BrandSeeder::class,
            \Database\Seeders\ProductCategorySeeder::class,
            \Database\Seeders\ProductsForEveryCategorySeeder::class,
            \Database\Seeders\ProductAttributesAndOptionsSeeder::class,
            \Database\Seeders\OptionSeeder::class,
            \Database\Seeders\ProductAttributeGroupSeeder::class,
            \Database\Seeders\ShippingMethodSeeder::class,
            \Database\Seeders\ShippingSettingsSeeder::class,
            \Database\Seeders\WeightShippingSettingsSeeder::class,
            \Database\Seeders\CountrySeeder::class,
            \Database\Seeders\ZoneSeeder::class,
            \Database\Seeders\GeoZoneSeeder::class,
            \Database\Seeders\GeoZoneShippingRateSeeder::class,
            \Database\Seeders\GeoZoneDetailSeeder::class,
            \Database\Seeders\PaymentMethodSeeder::class,
            \Database\Seeders\ProductSeeder::class,
            \Database\Seeders\ProductFeedbackSeeder::class,
            \Database\Seeders\ProductFaqSeeder::class,
            \Database\Seeders\ProductOverviewSeeder::class,
            \Database\Seeders\ProductRelatedSeeder::class,
            \Database\Seeders\ProductApplicationSeeder::class,
            \Database\Seeders\ProductTagSeeder::class,
            \Database\Seeders\FixProductImagesSeeder::class,
            \Database\Seeders\FilterOptionSeeder::class,
            \Database\Seeders\ProductFilterOptionSeeder::class,
            \Database\Seeders\ProductLandingSeeder::class,
            \Database\Seeders\ProductShowcaseSeeder::class,
            \Database\Seeders\ResourceSeeder::class,
            \Database\Seeders\CuponSeeder::class,
            \Database\Seeders\CouponCategorySeeder::class,
            \Database\Seeders\CouponProductSeeder::class,
            \Database\Seeders\CouponShippingSeeder::class,
            \Database\Seeders\OfferSeeder::class,
            \Database\Seeders\OrderSeeder::class,
            \Database\Seeders\NewModulesSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            $exitCode = Artisan::call('db:seed', ['--class' => $seeder]);
            $this->assertEquals(0, $exitCode, "Seeder failed: {$seeder}. Output: " . Artisan::output());
        }
    }
}

