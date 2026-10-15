<?php

namespace Tests\Feature\Product;

use App\Models\Brand;
use App\Models\FilterOption;
use App\Models\FilterOptionValue;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductAttributeGroup;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\User;
use App\Services\Admin\AdvancedProductService;
use App\Services\Common\FileUploadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvancedProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AdvancedProductService $service;
    protected Store $store;
    protected User $user;
    protected Brand $brand;
    protected ProductCategory $category;
    protected Option $option;
    protected OptionValue $optionValue;
    protected FilterOption $filterOption;
    protected FilterOptionValue $filterOptionValue;
    protected ProductAttributeGroup $attributeGroup;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new AdvancedProductService(new FileUploadService());

        $this->store = Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->user = User::create([
            'name'     => 'Admin Tester',
            'email'    => 'admin.tester@aire.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($this->user, 'user');

        $this->brand = Brand::create([
            'name'   => 'Daikin',
            'slug'   => 'daikin',
            'status' => 1,
        ]);

        $this->category = ProductCategory::create([
            'category_name' => 'Air Conditioners',
            'slug'          => 'air-conditioners',
            'status'        => 1,
        ]);

        $this->option = Option::create([
            'name'       => 'Capacity',
            'type'       => 'select',
            'sort_order' => 1,
        ]);

        $this->optionValue = OptionValue::create([
            'option_id'  => $this->option->id,
            'name'       => '1.5 Ton',
            'sort_order' => 1,
        ]);

        $this->filterOption = FilterOption::create([
            'name'       => 'Cooling Capacity',
            'type'       => 'select',
            'sort_order' => 1,
        ]);

        $this->filterOptionValue = FilterOptionValue::create([
            'filter_option_id' => $this->filterOption->id,
            'name'             => '18000 BTU',
            'sort_order'       => 1,
        ]);

        $this->attributeGroup = ProductAttributeGroup::create([
            'name'       => 'Technical Specs',
            'sort_order' => 1,
        ]);
    }

    private function createProduct(array $overrides = []): Product
    {
        return Product::create(array_merge([
            'store_id'       => $this->store->id,
            'name'           => 'Ductless Inverter AC 1.5 Ton',
            'model'          => 'FTKM50',
            'product_code'   => 'PC-100',
            'brand_id'       => $this->brand->id,
            'price'          => 1200.00,
            'quantity'       => 25,
            'featured'       => 0,
            'status'         => 1,
            'sort_order'     => 1,
            'createdBy'      => $this->user->id,
            'updatedBy'      => $this->user->id,
        ], $overrides));
    }

    public function test_it_lists_products_with_pagination_and_search(): void
    {
        $this->createProduct(['name' => 'Daikin Premium AC', 'model' => 'DKN-01']);
        $this->createProduct(['name' => 'Mitsubishi Heavy AC', 'model' => 'MTS-02']);

        $all = $this->service->listProducts([], 10);
        $this->assertEquals(2, $all->total());

        $searched = $this->service->listProducts(['search' => 'Daikin'], 10);
        $this->assertEquals(1, $searched->total());
        $this->assertEquals('Daikin Premium AC', $searched->first()->name);
    }

    public function test_it_updates_single_field(): void
    {
        $product = $this->createProduct(['status' => 1, 'featured' => 0]);

        $updated = $this->service->updateField($product->id, 'status', 0);
        $this->assertEquals(0, $updated->status);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 0]);

        $updatedFeatured = $this->service->updateField($product->id, 'featured', 1);
        $this->assertEquals(1, $updatedFeatured->featured);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'featured' => 1]);
    }

    public function test_it_updates_row_details_inline(): void
    {
        $product = $this->createProduct([
            'name'     => 'Original Name',
            'model'    => 'ORIG-01',
            'price'    => 500.00,
            'quantity' => 10,
        ]);

        $updated = $this->service->updateRow($product->id, [
            'name'     => 'Updated Product Name',
            'model'    => 'UPD-02',
            'price'    => 750.50,
            'quantity' => 40,
        ]);

        $this->assertEquals('Updated Product Name', $updated->name);
        $this->assertEquals('UPD-02', $updated->model);
        $this->assertEquals(750.50, $updated->price);
        $this->assertEquals(40, $updated->quantity);

        $this->assertDatabaseHas('products', [
            'id'       => $product->id,
            'name'     => 'Updated Product Name',
            'model'    => 'UPD-02',
            'price'    => 750.50,
            'quantity' => 40,
        ]);
    }

    public function test_it_updates_description_seo_details(): void
    {
        $product = $this->createProduct();

        $updated = $this->service->updateDescription($product->id, [
            'meta_title'       => 'Best AC 2026',
            'meta_description' => 'Top energy saving split AC',
            'meta_keyword'     => 'ac, inverter, daikin',
        ]);

        $this->assertNotNull($updated->description);
        $this->assertEquals('Best AC 2026', $updated->description->meta_title);
        $this->assertEquals('Top energy saving split AC', $updated->description->meta_description);

        $this->assertDatabaseHas('product_descriptions', [
            'product_id'   => $product->id,
            'meta_title'   => 'Best AC 2026',
            'meta_keyword' => 'ac, inverter, daikin',
        ]);
    }

    public function test_it_bulk_updates_categories(): void
    {
        $p1 = $this->createProduct(['name' => 'Product 1']);
        $p2 = $this->createProduct(['name' => 'Product 2']);

        $cat2 = ProductCategory::create([
            'category_name' => 'Commercial AC',
            'slug'          => 'commercial-ac',
            'status'        => 1,
        ]);

        $this->service->bulkUpdateCategories([$p1->id, $p2->id], [$this->category->id, $cat2->id]);

        $this->assertEquals(2, $p1->fresh()->categories()->count());
        $this->assertEquals(2, $p2->fresh()->categories()->count());
    }

    public function test_it_bulk_updates_options(): void
    {
        $p1 = $this->createProduct(['name' => 'Product 1']);
        $p2 = $this->createProduct(['name' => 'Product 2']);

        $options = [
            [
                'option_id'       => $this->option->id,
                'option_value_id' => $this->optionValue->id,
                'quantity'        => 10,
                'subtract'        => 1,
                'price'           => 150.00,
                'price_prefix'    => '+',
            ]
        ];

        $this->service->bulkUpdateOptions([$p1->id, $p2->id], $options);

        $this->assertDatabaseHas('product_options', [
            'product_id'      => $p1->id,
            'option_id'       => $this->option->id,
            'option_value_id' => $this->optionValue->id,
        ]);

        $this->assertDatabaseHas('product_options', [
            'product_id'      => $p2->id,
            'option_id'       => $this->option->id,
            'option_value_id' => $this->optionValue->id,
        ]);
    }

    public function test_it_bulk_updates_filter_options(): void
    {
        $p1 = $this->createProduct(['name' => 'Product 1']);
        $p2 = $this->createProduct(['name' => 'Product 2']);

        $filterOptions = [
            [
                'filter_option_id'       => $this->filterOption->id,
                'filter_option_value_id' => $this->filterOptionValue->id,
            ]
        ];

        $this->service->bulkUpdateFilterOptions([$p1->id, $p2->id], $filterOptions);

        $this->assertDatabaseHas('product_filter_options', [
            'product_id'             => $p1->id,
            'filter_option_id'       => $this->filterOption->id,
            'filter_option_value_id' => $this->filterOptionValue->id,
        ]);

        $this->assertDatabaseHas('product_filter_options', [
            'product_id'             => $p2->id,
            'filter_option_id'       => $this->filterOption->id,
            'filter_option_value_id' => $this->filterOptionValue->id,
        ]);
    }

    public function test_it_bulk_updates_attributes(): void
    {
        $p1 = $this->createProduct(['name' => 'Product 1']);
        $p2 = $this->createProduct(['name' => 'Product 2']);

        $attributes = [
            [
                'attribute_group_id' => $this->attributeGroup->id,
                'name'               => 'Refrigerant',
                'details'            => 'R32 Eco Friendly',
                'sort_order'         => 1,
            ]
        ];

        $this->service->bulkUpdateAttributes([$p1->id, $p2->id], $attributes);

        $this->assertDatabaseHas('product_attributes', [
            'product_id'         => $p1->id,
            'attribute_group_id' => $this->attributeGroup->id,
            'name'               => 'Refrigerant',
            'details'            => 'R32 Eco Friendly',
        ]);

        $this->assertDatabaseHas('product_attributes', [
            'product_id'         => $p2->id,
            'attribute_group_id' => $this->attributeGroup->id,
            'name'               => 'Refrigerant',
            'details'            => 'R32 Eco Friendly',
        ]);
    }

    public function test_it_bulk_updates_status_and_featured(): void
    {
        $p1 = $this->createProduct(['status' => 1, 'featured' => 0]);
        $p2 = $this->createProduct(['status' => 1, 'featured' => 0]);

        $this->service->bulkUpdateStatus([$p1->id, $p2->id], 'status', 0);
        $this->assertEquals(0, $p1->fresh()->status);
        $this->assertEquals(0, $p2->fresh()->status);

        $this->service->bulkUpdateStatus([$p1->id, $p2->id], 'featured', 1);
        $this->assertEquals(1, $p1->fresh()->featured);
        $this->assertEquals(1, $p2->fresh()->featured);
    }
}
