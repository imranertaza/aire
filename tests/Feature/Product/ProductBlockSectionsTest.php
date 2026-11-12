<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductSection;
use App\Models\Section;
use App\Models\User;
use App\Services\Admin\ProductManagementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ProductBlockSectionsTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;
    protected Section $sectionA;
    protected Section $sectionB;

    protected function setUp(): void
    {
        parent::setUp();

        \App\Models\Store::create([
            'id' => 1,
            'name' => 'Default Store',
            'is_default' => 1,
        ]);

        // Find or create test product
        $this->product = Product::create([
            'store_id' => 1,
            'name' => 'AIRE Test Unit',
            'slug' => 'aire-test-unit',
            'model' => 'ATU-01',
            'price' => 999.00,
            'quantity' => 10,
            'status' => 1,
        ]);

        // Create two test visual block sections
        $this->sectionA = Section::updateOrCreate(
            ['name' => 'test_block_promo_banner'],
            [
                'status' => 1,
                'data' => [
                    'title' => 'Promo Banner',
                    'header_title' => 'Special Laboratory Filtration',
                    'blocks' => [
                        [
                            'type' => 'header',
                            'settings' => [
                                'title' => 'Special Laboratory Filtration',
                                'subtitle' => 'Medical Grade Clean Air',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->sectionB = Section::updateOrCreate(
            ['name' => 'test_block_spec_matrix'],
            [
                'status' => 1,
                'data' => [
                    'title' => 'Technical Specs Matrix',
                    'header_title' => 'Engineering Excellence Matrix',
                    'blocks' => [
                        [
                            'type' => 'content',
                            'settings' => [
                                'content' => '<p>Direct airflow performance test verified.</p>',
                            ],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Test Eloquent relationship Product -> blockSections.
     */
    public function test_product_has_many_block_sections_relation()
    {
        $this->product->blockSections()->delete();

        $sec1 = $this->product->blockSections()->create([
            'section_name' => $this->sectionA->name,
            'slot_key'     => 'after:overview',
            'sort_order'   => 0,
            'is_enabled'   => true,
        ]);

        $sec2 = $this->product->blockSections()->create([
            'section_name' => $this->sectionB->name,
            'slot_key'     => 'after:specs',
            'sort_order'   => 1,
            'is_enabled'   => true,
        ]);

        $this->assertCount(2, $this->product->refresh()->blockSections);
        $this->assertEquals($this->sectionA->name, $this->product->blockSections->first()->section_name);
        $this->assertEquals('after:overview', $this->product->blockSections->first()->slot_key);
        $this->assertTrue($this->product->blockSections->first()->is_enabled);
    }

    /**
     * Test ProductManagementService updateProduct persists block sections properly.
     */
    public function test_service_updates_and_syncs_block_sections()
    {
        $service = app(ProductManagementService::class);

        $request = Request::create("/api/products/{$this->product->id}", 'POST', [
            'name'           => $this->product->name,
            'slug'           => $this->product->slug,
            'model'          => $this->product->model,
            'price'          => $this->product->price,
            'quantity'       => $this->product->quantity,
            'block_sections' => json_encode([
                [
                    'section_name' => $this->sectionA->name,
                    'slot_key'     => 'after:overview',
                    'sort_order'   => 0,
                    'is_enabled'   => 1,
                ],
                [
                    'section_name' => $this->sectionB->name,
                    'slot_key'     => 'after:overview',
                    'sort_order'   => 1,
                    'is_enabled'   => 0, // Disabled
                ],
            ]),
        ]);

        $updated = $service->updateProduct($this->product, [
            'name'     => $this->product->name,
            'slug'     => $this->product->slug,
            'model'    => $this->product->model,
            'price'    => $this->product->price,
            'quantity' => $this->product->quantity,
        ], $request);

        $this->assertCount(2, $updated->blockSections);
        $first = $updated->blockSections->first();
        $this->assertEquals($this->sectionA->name, $first->section_name);
        $this->assertTrue($first->is_enabled);

        $second = $updated->blockSections->last();
        $this->assertEquals($this->sectionB->name, $second->section_name);
        $this->assertFalse($second->is_enabled);
    }

    /**
     * Test render_page_slot renders product-specific block sections when Product context is provided.
     */
    public function test_render_page_slot_renders_product_specific_sections()
    {
        Cache::forget("product_sections_{$this->product->id}");

        $this->product->blockSections()->delete();

        // Assign sectionA to 'after:overview'
        $this->product->blockSections()->create([
            'section_name' => $this->sectionA->name,
            'slot_key'     => 'after:overview',
            'sort_order'   => 0,
            'is_enabled'   => true,
        ]);

        // Slot without product context should not render this product's private section
        $globalHtml = render_page_slot('product', 'after:overview');
        $this->assertStringNotContainsString('Special Laboratory Filtration', $globalHtml);

        // Slot with product context MUST render the product's custom block section
        $productHtml = render_page_slot('product', 'after:overview', $this->product);
        $this->assertStringContainsString('Special Laboratory Filtration', $productHtml);

        // Other slots on the product (e.g. 'after:specs') should remain empty for this section
        $specsHtml = render_page_slot('product', 'after:specs', $this->product);
        $this->assertStringNotContainsString('Special Laboratory Filtration', $specsHtml);
    }

    /**
     * Test cache busting when product block sections are updated.
     */
    public function test_cache_is_invalidated_when_product_sections_change()
    {
        $cacheKey = "product_sections_{$this->product->id}";

        $this->product->blockSections()->delete();
        $this->product->blockSections()->create([
            'section_name' => $this->sectionA->name,
            'slot_key'     => 'after:overview',
            'sort_order'   => 0,
            'is_enabled'   => true,
        ]);

        // Warm up cache
        $cachedSections = Cache::remember($cacheKey, 86400, function () {
            return $this->product->blockSections()->where('is_enabled', 1)->get();
        });
        $this->assertCount(1, $cachedSections);

        // Invalidate via Product::clearProductCache
        Product::clearProductCache($this->product);
        $this->assertFalse(Cache::has($cacheKey));
    }
}
