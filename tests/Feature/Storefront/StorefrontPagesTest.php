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

    public function test_contact_form_submission_succeeds(): void
    {
        \Illuminate\Support\Facades\Mail::fake();

        $response = $this->postJson(route('contact.submit'), [
            'name'    => 'John Doe',
            'email'   => 'john@example.com',
            'phone'   => '+1234567890',
            'subject' => 'Product Consultation',
            'message' => 'I would like to know more about the AIRE Pro S1 system.',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_contact_form_honeypot_traps_bot(): void
    {
        \Illuminate\Support\Facades\Mail::fake();

        $response = $this->postJson(route('contact.submit'), [
            'name'          => 'Spam Bot',
            'email'         => 'spambot@example.com',
            'message'       => 'Buy cheap stuff',
            'b_extra_field' => 'bot-value',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // Email should NOT be sent to admin
        \Illuminate\Support\Facades\Mail::assertNothingSent();
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->postJson(route('contact.submit'), [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'message']);
    }
}

