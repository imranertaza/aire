<?php

namespace Tests\Feature\Section;

use App\Models\Section;
use App\Models\Store;
use App\Models\User;
use App\Services\Storefront\StorefrontService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SectionManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;
    protected Store $store;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Create default store
        $this->store = Store::create([
            'id'         => 1,
            'name'       => 'Default Store',
            'is_default' => 1,
        ]);

        // Create permissions
        Permission::findOrCreate('manage-frontend', 'user');

        // Create Admin User with manage-frontend permission
        $this->admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@aire.test',
            'password' => bcrypt('password123'),
            'status'   => 1,
        ]);
        $this->admin->givePermissionTo('manage-frontend');

        // Create regular user without permission
        $this->regularUser = User::create([
            'name'     => 'Regular User',
            'email'    => 'user@aire.test',
            'password' => bcrypt('password123'),
            'status'   => 1,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_section_endpoints(): void
    {
        $response = $this->getJson('/api/sections');
        $response->assertStatus(401);

        $responseAbout = $this->getJson('/api/sections/about-sections');
        $responseAbout->assertStatus(401);

        $responseHome = $this->getJson('/api/sections/home-sections');
        $responseHome->assertStatus(401);
    }

    public function test_user_without_permission_cannot_access_sections(): void
    {
        Sanctum::actingAs($this->regularUser, ['*'], 'user');

        $response = $this->getJson('/api/sections');
        $response->assertStatus(403);
    }

    public function test_admin_can_retrieve_paginated_sections_list(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        Section::create([
            'name' => 'about_hero',
            'data' => [
                'badge'    => 'OUR STORY',
                'title'    => 'A Cleaner Tomorrow Starts Here',
                'subtitle' => 'Pioneering clean air solutions.',
            ],
        ]);

        $response = $this->getJson('/api/sections');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data',
                    'current_page',
                    'total',
                ],
                'message',
            ]);
    }

    public function test_admin_can_retrieve_home_sections_in_ordered_sequence(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        Section::create([
            'name' => 'home_benefits',
            'data' => [
                'badge' => 'BENEFITS',
                'title' => 'Pure Living Benefits',
            ],
        ]);

        $response = $this->getJson('/api/sections/home-sections');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);
    }

    public function test_admin_can_retrieve_about_sections_in_ordered_sequence(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        Section::create([
            'name' => 'about_hero',
            'data' => [
                'badge' => 'OUR STORY',
                'title' => 'A Cleaner Tomorrow Starts Here',
            ],
        ]);

        Section::create([
            'name' => 'about_story',
            'data' => [
                'number'     => 1,
                'title'      => 'Our Journey',
                'hero_title' => 'The Story Behind AIRE',
            ],
        ]);

        $response = $this->getJson('/api/sections/about-sections');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $sections = $response->json('data');
        $this->assertNotEmpty($sections);
        $this->assertEquals('about_hero', $sections[0]['name']);
    }

    public function test_admin_can_retrieve_single_section_by_id(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        $section = Section::create([
            'name' => 'about_leadership',
            'data' => [
                'title'        => 'Leadership',
                'team_heading' => 'Meet Our Leadership Team',
            ],
        ]);

        $response = $this->getJson("/api/sections/{$section->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'id'   => $section->id,
                    'name' => 'about_leadership',
                ],
            ]);
    }

    public function test_admin_can_update_about_section_with_valid_json_data(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        $section = Section::create([
            'name' => 'about_hero',
            'data' => [
                'badge'    => 'OLD BADGE',
                'title'    => 'Old Title',
                'subtitle' => 'Old Subtitle',
            ],
        ]);

        $updatedPayload = [
            'badge'    => 'NEW VISION',
            'title'    => 'Updated Hero Title',
            'subtitle' => 'Updated Subtitle Narrative',
        ];

        $response = $this->putJson("/api/sections/{$section->id}", [
            'data' => json_encode($updatedPayload),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $section->refresh();
        $this->assertEquals('NEW VISION', $section->data['badge']);
        $this->assertEquals('Updated Hero Title', $section->data['title']);
    }

    public function test_admin_can_update_section_with_image_upload(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        $section = Section::create([
            'name' => 'about_mission_vision',
            'data' => [
                'title' => 'Mission & Vision',
            ],
        ]);

        $imageFile = UploadedFile::fake()->image('purpose.jpg', 800, 600);

        $response = $this->postJson("/api/sections/{$section->id}?_method=PUT", [
            'data'  => json_encode([
                'title'         => 'Updated Mission & Vision',
                'purpose_title' => 'Global Clean Air Mission',
            ]),
            'image' => $imageFile,
        ]);

        $response->assertStatus(200);

        $section->refresh();
        $this->assertEquals('Updated Mission & Vision', $section->data['title']);
        $this->assertNotEmpty($section->data['image']);
        Storage::disk('public')->assertExists($section->data['image']);
    }

    public function test_section_update_validates_json_format(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        $section = Section::create([
            'name' => 'about_careers',
            'data' => ['title' => 'Careers'],
        ]);

        $response = $this->putJson("/api/sections/{$section->id}", [
            'data' => 'not-a-valid-json-string',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['data']);
    }

    public function test_updating_section_invalidates_storefront_cache(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        $section = Section::create([
            'name' => 'about_hero',
            'data' => [
                'badge' => 'INITIAL BADGE',
                'title' => 'Initial Title',
            ],
        ]);

        // Pre-warm the cache via StorefrontService
        $service = app(StorefrontService::class);
        $initialSections = $service->getAboutSections();
        $this->assertEquals('Initial Title', $initialSections['hero']['title']);

        // Update section via API
        $response = $this->putJson("/api/sections/{$section->id}", [
            'data' => json_encode([
                'badge' => 'CACHED BADGE TEST',
                'title' => 'Freshly Updated Title',
            ]),
        ]);

        $response->assertStatus(200);

        // Fetch again from StorefrontService and verify cache was cleared and fresh title returned
        $freshSections = $service->getAboutSections();
        $this->assertEquals('Freshly Updated Title', $freshSections['hero']['title']);
    }

    public function test_admin_can_retrieve_and_update_section_by_name(): void
    {
        Sanctum::actingAs($this->admin, ['*'], 'user');

        Section::create([
            'name' => 'about_news',
            'data' => [
                'title'        => 'Old News Title',
                'banner_title' => 'Old Banner',
            ],
        ]);

        // Get by name
        $getResponse = $this->getJson('/api/sections/by-name/about_news');
        $getResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'name' => 'about_news',
                ],
            ]);

        // Update by name
        $updateResponse = $this->putJson('/api/sections/by-name/about_news', [
            'data' => json_encode([
                'title'        => 'Updated Press Center',
                'banner_title' => 'Official Media Inquiries',
            ]),
        ]);

        $updateResponse->assertStatus(200);

        $section = Section::where('name', 'about_news')->first();
        $this->assertEquals('Updated Press Center', $section->data['title']);
    }
}
