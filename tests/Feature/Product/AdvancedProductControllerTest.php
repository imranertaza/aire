<?php

namespace Tests\Feature\Product;

use App\Models\Brand;
use App\Models\FilterOption;
use App\Models\FilterOptionValue;
use App\Models\Module;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductAttributeGroup;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AdvancedProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Store $store;
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

        $this->store = Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        Module::create([
            'name'       => 'Bulk Edit Products',
            'module_key' => 'bulk_edit_products',
            'status'     => 1,
        ]);

        Permission::findOrCreate('edit-products', 'user');

        $this->admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@aire.test',
            'password' => bcrypt('password123'),
        ]);

        $this->admin->givePermissionTo('edit-products');

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
            'createdBy'      => $this->admin->id,
            'updatedBy'      => $this->admin->id,
        ], $overrides));
    }

    public function test_it_can_fetch_paginated_products_list(): void
    {
        $this->createProduct(['name' => 'Product A', 'model' => 'MOD-A']);
        $this->createProduct(['name' => 'Product B', 'model' => 'MOD-B']);

        $response = $this->actingAs($this->admin, 'user')
            ->getJson(route('advanced-products.index', ['per_page' => 10]));

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.total', 2);
    }

    public function test_it_can_update_product_field(): void
    {
        $product = $this->createProduct(['status' => 1, 'featured' => 0]);

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.update-field'), [
                'id'    => $product->id,
                'field' => 'status',
                'value' => 0,
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 0);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 0]);
    }

    public function test_it_validates_update_product_field(): void
    {
        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.update-field'), [
                'id'    => 99999,
                'field' => 'invalid_field',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id', 'field', 'value']);
    }

    public function test_it_can_update_row_details_inline(): void
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.update-row'), [
                'id'       => $product->id,
                'name'     => 'Renamed Inverter AC',
                'model'    => 'FTKM50-NEW',
                'price'    => 1350.00,
                'quantity' => 15,
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Renamed Inverter AC')
            ->assertJsonPath('data.model', 'FTKM50-NEW');

        $this->assertDatabaseHas('products', [
            'id'       => $product->id,
            'name'     => 'Renamed Inverter AC',
            'model'    => 'FTKM50-NEW',
            'price'    => 1350.00,
            'quantity' => 15,
        ]);
    }

    public function test_it_can_update_description_seo_details(): void
    {
        $product = $this->createProduct();

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.update-description'), [
                'product_id'       => $product->id,
                'meta_title'       => 'High Efficiency Inverter AC',
                'meta_description' => 'Energy saving quiet split AC unit',
                'meta_keyword'     => 'inverter, split, silent ac',
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.description.meta_title', 'High Efficiency Inverter AC');

        $this->assertDatabaseHas('product_descriptions', [
            'product_id' => $product->id,
            'meta_title' => 'High Efficiency Inverter AC',
        ]);
    }

    public function test_it_can_bulk_update_categories(): void
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.bulk.categories'), [
                'product_ids'  => [$p1->id, $p2->id],
                'category_ids' => [$this->category->id],
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true);

        $this->assertEquals(1, $p1->fresh()->categories()->count());
        $this->assertEquals(1, $p2->fresh()->categories()->count());
    }

    public function test_it_can_bulk_update_options(): void
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.bulk.options'), [
                'product_ids' => [$p1->id, $p2->id],
                'options'     => [
                    [
                        'option_id'       => $this->option->id,
                        'option_value_id' => $this->optionValue->id,
                        'quantity'        => 5,
                        'subtract'        => 1,
                        'price'           => 100.00,
                        'price_prefix'    => '+',
                    ]
                ],
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('product_options', [
            'product_id'      => $p1->id,
            'option_id'       => $this->option->id,
            'option_value_id' => $this->optionValue->id,
        ]);
    }

    public function test_it_can_bulk_update_filter_options(): void
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.bulk.filter-options'), [
                'product_ids'    => [$p1->id, $p2->id],
                'filter_options' => [
                    [
                        'filter_option_id'       => $this->filterOption->id,
                        'filter_option_value_id' => $this->filterOptionValue->id,
                    ]
                ],
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('product_filter_options', [
            'product_id'             => $p1->id,
            'filter_option_id'       => $this->filterOption->id,
            'filter_option_value_id' => $this->filterOptionValue->id,
        ]);
    }

    public function test_it_can_bulk_update_attributes(): void
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.bulk.attributes'), [
                'product_ids' => [$p1->id, $p2->id],
                'attributes'  => [
                    [
                        'attribute_group_id' => $this->attributeGroup->id,
                        'name'               => 'Noise Level',
                        'details'            => '19 dB Whisper Quiet',
                        'sort_order'         => 0,
                    ]
                ],
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('product_attributes', [
            'product_id'         => $p1->id,
            'attribute_group_id' => $this->attributeGroup->id,
            'name'               => 'Noise Level',
        ]);
    }

    public function test_it_can_bulk_update_status(): void
    {
        $p1 = $this->createProduct(['status' => 1]);
        $p2 = $this->createProduct(['status' => 1]);

        $response = $this->actingAs($this->admin, 'user')
            ->postJson(route('advanced-products.bulk.status'), [
                'product_ids' => [$p1->id, $p2->id],
                'field'       => 'status',
                'value'       => 0,
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true);

        $this->assertEquals(0, $p1->fresh()->status);
        $this->assertEquals(0, $p2->fresh()->status);
    }
}
