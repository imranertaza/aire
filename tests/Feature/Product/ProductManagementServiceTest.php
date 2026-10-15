<?php

namespace Tests\Feature\Product;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\User;
use App\Services\Admin\ProductManagementService;
use App\Services\Admin\ProductMediaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductManagementServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProductManagementService $service;
    protected ProductMediaService $mediaService;
    protected Store $store;
    protected User $user;
    protected Brand $brand;
    protected ProductCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->mediaService = new ProductMediaService();
        $this->service = new ProductManagementService($this->mediaService);

        $this->store = Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        $this->user = User::create([
            'name'     => 'Service Tester',
            'email'    => 'service_tester@aire.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($this->user, 'user');

        $this->brand = Brand::create(['name' => 'AIRE Premium', 'status' => 1]);
        $this->category = ProductCategory::create(['category_name' => 'Mini Split AC', 'slug' => 'mini-split-ac', 'status' => 1]);
    }

    public function test_service_can_create_product_with_media_and_relations(): void
    {
        $mainImage = UploadedFile::fake()->image('main.jpg', 600, 600);
        $galleryImage = UploadedFile::fake()->image('gallery1.jpg', 600, 600);

        $postData = [
            'name'                  => 'Mini Split Pro Inverter',
            'model'                 => 'MSP-2026',
            'price'                 => 899.00,
            'quantity'              => 15,
            'category_ids'          => [$this->category->id],
            'description'           => 'High efficiency cooling system',
            'special_price'         => 799.00,
            'product_free_delivery' => 1,
            'faqs'                  => [
                ['question' => 'Is it energy saving?', 'answer' => 'Yes, 24 SEER rating.'],
            ],
            'applications'          => [
                ['title' => 'Living Room Application', 'description' => 'Ideal for large areas.'],
            ],
        ];

        $request = Request::create('/api/v1/products', 'POST', $postData, [], [
            'main_image'     => $mainImage,
            'gallery_images' => [$galleryImage],
        ]);

        $data = array_merge($postData, [
            'options'        => [],
            'filter_options' => [],
            'attributes'     => [],
        ]);

        $product = $this->service->createProduct($data, $request);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', ['name' => 'Mini Split Pro Inverter', 'model' => 'MSP-2026']);
        $this->assertDatabaseHas('product_descriptions', ['product_id' => $product->id, 'description' => 'High efficiency cooling system']);
        $this->assertDatabaseHas('product_specials', ['product_id' => $product->id, 'special_price' => 799.00]);
        $this->assertDatabaseHas('product_free_deliveries', ['product_id' => $product->id]);
        $this->assertDatabaseHas('product_faqs', ['product_id' => $product->id, 'question' => 'Is it energy saving?']);
        $this->assertDatabaseHas('product_applications', ['product_id' => $product->id, 'title' => 'Living Room Application']);
        $this->assertCount(1, $product->images);
        $this->assertNotNull($product->main_image);
    }

    public function test_service_can_update_product_and_relationships(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Original Name',
            'model'    => 'ORIG-01',
            'price'    => 500,
            'quantity' => 10,
        ]);

        $postData = [
            'name'        => 'Updated Name',
            'model'       => 'ORIG-01-REV',
            'price'       => 550,
            'quantity'    => 12,
            'description' => 'Updated Description',
        ];

        $request = Request::create("/api/v1/products/{$product->id}", 'POST', $postData);

        $data = array_merge($postData, [
            'options'        => [],
            'filter_options' => [],
        ]);

        $updated = $this->service->updateProduct($product, $data, $request);

        $this->assertEquals('Updated Name', $updated->fresh()->name);
        $this->assertEquals(550, $updated->fresh()->price);
        $this->assertDatabaseHas('product_descriptions', ['product_id' => $product->id, 'description' => 'Updated Description']);
    }

    public function test_service_can_toggle_product_status(): void
    {
        $product = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Status Unit',
            'model'    => 'SU-001',
            'price'    => 200,
            'quantity' => 5,
            'status'   => 1,
        ]);

        $newStatus = $this->service->toggleStatus($product);
        $this->assertEquals(0, $newStatus);
        $this->assertEquals(0, $product->fresh()->status);

        $newStatusAgain = $this->service->toggleStatus($product);
        $this->assertEquals(1, $newStatusAgain);
        $this->assertEquals(1, $product->fresh()->status);
    }

    public function test_service_can_bulk_update_status_and_bulk_delete(): void
    {
        $p1 = Product::create(['store_id' => $this->store->id, 'name' => 'P1', 'model' => 'P-1', 'price' => 10, 'quantity' => 1, 'status' => 1]);
        $p2 = Product::create(['store_id' => $this->store->id, 'name' => 'P2', 'model' => 'P-2', 'price' => 10, 'quantity' => 1, 'status' => 1]);

        $this->service->bulkUpdateStatus([$p1->id, $p2->id], 0);

        $this->assertEquals(0, $p1->fresh()->status);
        $this->assertEquals(0, $p2->fresh()->status);

        $this->service->bulkDelete([$p1->id, $p2->id]);

        $this->assertDatabaseMissing('products', ['id' => $p1->id]);
        $this->assertDatabaseMissing('products', ['id' => $p2->id]);
    }

    public function test_service_can_copy_products_with_media_and_relations(): void
    {
        $original = Product::create([
            'store_id' => $this->store->id,
            'name'     => 'Commercial Chiller Unit',
            'model'    => 'CCU-500',
            'price'    => 3500.00,
            'quantity' => 3,
            'status'   => 1,
        ]);

        $original->faqs()->create(['question' => 'How many tons?', 'answer' => '5 Tons']);

        $this->service->copyProducts([$original->id]);

        $this->assertDatabaseHas('products', [
            'name'   => 'Copy of Commercial Chiller Unit',
            'status' => 0,
        ]);

        $copy = Product::where('name', 'Copy of Commercial Chiller Unit')->first();
        $this->assertNotNull($copy);
        $this->assertDatabaseHas('product_faqs', [
            'product_id' => $copy->id,
            'question'   => 'How many tons?',
        ]);
    }
}
