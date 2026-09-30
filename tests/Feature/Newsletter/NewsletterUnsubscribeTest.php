<?php

namespace Tests\Feature\Newsletter;

use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterUnsubscribeTest extends TestCase
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

    public function test_newsletter_creation_generates_unsubscribe_token(): void
    {
        $newsletter = Newsletter::create([
            'email'  => 'john@example.com',
            'status' => 1,
        ]);

        $this->assertNotEmpty($newsletter->unsubscribe_token);
        $this->assertEquals(64, strlen($newsletter->unsubscribe_token));
    }

    public function test_user_can_unsubscribe_via_get_request(): void
    {
        $newsletter = Newsletter::create([
            'email'  => 'subscriber@example.com',
            'status' => 1,
        ]);

        $response = $this->get(route('newsletter.unsubscribe', ['token' => $newsletter->unsubscribe_token]));

        $response->assertStatus(200);
        $response->assertSee('subscriber@example.com');
        $response->assertSee('You are Unsubscribed');

        $this->assertDatabaseHas('newsletters', [
            'id'     => $newsletter->id,
            'status' => 0,
        ]);
        $this->assertNotNull($newsletter->fresh()->unsubscribed_at);
    }

    public function test_email_client_can_unsubscribe_via_rfc8058_post_request(): void
    {
        $newsletter = Newsletter::create([
            'email'  => 'rfc8058@example.com',
            'status' => 1,
        ]);

        $response = $this->post(route('newsletter.unsubscribe', ['token' => $newsletter->unsubscribe_token]));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('newsletters', [
            'id'     => $newsletter->id,
            'status' => 0,
        ]);
    }

    public function test_user_can_resubscribe_after_unsubscribing(): void
    {
        $newsletter = Newsletter::create([
            'email'  => 'reconnect@example.com',
            'status' => 0,
        ]);

        $response = $this->post(route('newsletter.resubscribe', ['token' => $newsletter->unsubscribe_token]));

        $response->assertRedirect();
        $this->assertDatabaseHas('newsletters', [
            'id'     => $newsletter->id,
            'status' => 1,
            'unsubscribed_at' => null,
        ]);
    }

    public function test_customer_can_unsubscribe_using_their_token(): void
    {
        $customer = Customer::create([
            'firstname'  => 'Jane',
            'lastname'   => 'Doe',
            'email'      => 'jane.customer@example.com',
            'phone'      => '01711112222',
            'password'   => bcrypt('password123'),
            'status'     => 1,
            'newsletter' => 1,
        ]);

        $response = $this->get(route('newsletter.unsubscribe', ['token' => $customer->unsubscribe_token]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'id'         => $customer->id,
            'newsletter' => 0,
        ]);
    }

    public function test_invalid_unsubscribe_token_returns_error_view(): void
    {
        $response = $this->get(route('newsletter.unsubscribe', ['token' => 'invalid-token-123456']));

        $response->assertStatus(200);
        $response->assertSee('Invalid or Expired Link');
    }
}
