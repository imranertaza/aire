<?php

namespace Tests\Feature\Storefront;

use App\Models\Section;
use App\Models\Store;
use App\Services\Storefront\StorefrontService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageDynamicSectionsTest extends TestCase
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

    public function test_about_page_loads_with_fallback_defaults_when_sections_table_is_empty(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('A Cleaner Tomorrow Starts Here');
        $response->assertSee('Our Journey');
        $response->assertSee('Mission & Vision');
        $response->assertSee('Leadership');
    }

    public function test_about_page_renders_with_dynamic_sections_from_database(): void
    {
        Section::create([
            'name' => 'about_hero',
            'data' => [
                'badge'    => 'SPECIAL BADGE TEST',
                'title'    => 'Custom Dynamic Hero Heading',
                'subtitle' => 'Custom subtitle description for our company.',
            ],
        ]);

        Section::create([
            'name' => 'about_story',
            'data' => [
                'number'     => 1,
                'title'      => 'Custom History Story',
                'subtitle'   => 'How we transformed pure air.',
                'hero_title' => 'Custom Journey Title',
                'hero_desc'  => 'Detailed history text.',
                'milestones' => [
                    [
                        'year'  => '1995',
                        'title' => 'The Breakthrough Year',
                        'desc'  => 'Invented revolutionary filtration.',
                    ],
                ],
                'stats' => [
                    [
                        'icon'  => 'bi bi-globe',
                        'title' => '150+ Nations',
                        'desc'  => 'Worldwide coverage.',
                    ],
                ],
            ],
        ]);

        Section::create([
            'name' => 'about_leadership',
            'data' => [
                'number'   => 3,
                'title'    => 'Our Inspiring Leaders',
                'subtitle' => 'Meet our team members.',
                'members'  => [
                    [
                        'name'  => 'Professor Alexander Wright',
                        'role'  => 'Founder & Chief Scientist',
                        'bio'   => 'Leading research in atmospheric purification.',
                        'image' => '',
                    ],
                ],
            ],
        ]);

        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('SPECIAL BADGE TEST');
        $response->assertSee('Custom Dynamic Hero Heading');
        $response->assertSee('The Breakthrough Year');
        $response->assertSee('150+ Nations');
        $response->assertSee('Professor Alexander Wright');
        $response->assertSee('Founder & Chief Scientist');
    }

    public function test_storefront_service_get_about_sections_returns_all_nine_keys(): void
    {
        $service = app(StorefrontService::class);
        $sections = $service->getAboutSections();

        $expectedKeys = [
            'hero',
            'story',
            'mission_vision',
            'leadership',
            'innovation',
            'quality',
            'careers',
            'news',
            'global',
        ];

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $sections);
            $this->assertIsArray($sections[$key]);
            $this->assertNotEmpty($sections[$key]['title']);
        }
    }
}
