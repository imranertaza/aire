<?php

namespace Tests\Feature\Storefront;

use App\Models\Newsletter;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontPagesTest extends TestCase
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

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
    }

    public function test_solutions_page_loads_successfully(): void
    {
        $response = $this->get(route('solutions'));

        $response->assertStatus(200);
    }

    public function test_docs_page_loads_successfully(): void
    {
        $response = $this->get(route('docs'));

        $response->assertStatus(200);
    }

    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
    }

    public function test_newsletter_subscription_saves_email(): void
    {
        $response = $this->postJson(route('newsletter.subscribe'), [
            'email' => 'subscriber@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('newsletters', [
            'email'  => 'subscriber@example.com',
            'status' => 1,
        ]);
    }

    public function test_newsletter_subscription_honeypot_traps_bot(): void
    {
        $response = $this->postJson(route('newsletter.subscribe'), [
            'email'         => 'spambot@example.com',
            'b_extra_field' => 'bot-value',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // Honeypot should NOT save email to database
        $this->assertDatabaseMissing('newsletters', [
            'email' => 'spambot@example.com',
        ]);
    }

    public function test_newsletter_subscription_validates_email(): void
    {
        $response = $this->postJson(route('newsletter.subscribe'), [
            'email' => 'invalid-email-address',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
