<?php

namespace Tests\Feature\Storefront;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DynamicPageTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@aire.test',
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_dynamic_page_loads_successfully(): void
    {
        $page = Page::create([
            'page_title'       => 'Custom Air Quality Guide',
            'slug'             => 'custom-air-quality-guide',
            'breadcrumb'       => 'Guide',
            'short_des'        => 'A detailed guide on cleanroom ventilation standards.',
            'page_description' => '<p>This is dynamic cleanroom ventilation content with H13 HEPA specifications.</p>',
            'meta_title'       => 'Custom Air Quality Guide | Aire',
            'meta_description' => 'A detailed guide on cleanroom ventilation standards.',
            'status'           => 1,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(200);
        $response->assertSee('Custom Air Quality Guide');
        $response->assertSee('cleanroom ventilation content');
        $response->assertSee('Verified IAQ Content');
    }

    public function test_inactive_dynamic_page_returns_404(): void
    {
        $page = Page::create([
            'page_title'       => 'Draft Page',
            'slug'             => 'draft-page',
            'breadcrumb'       => 'Draft',
            'short_des'        => 'Draft page short description.',
            'page_description' => '<p>Draft content</p>',
            'status'           => 0,
            'createdBy'        => $this->user->id,
            'updatedBy'        => $this->user->id,
        ]);

        $response = $this->get(route('page.show', $page->slug));

        $response->assertStatus(404);
    }

    public function test_non_existent_page_returns_404(): void
    {
        $response = $this->get('/page/non-existent-random-slug-999');

        $response->assertStatus(404);
    }
}
