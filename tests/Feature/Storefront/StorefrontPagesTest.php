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
        $response->assertSee('home-category-showcase-section');
        $response->assertSee('Fresh Air Unit');
        $response->assertSee('Air Pro Mask');
        $response->assertSee('Accessories');
        $response->assertSee('Air Purifiers');
        $response->assertSee('Solutions for Home');
        $response->assertSee('Solutions for Business');
        $response->assertSee('Find Your Solutions');
    }

    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
    }

    public function test_resources_page_loads_successfully(): void
    {
        $response = $this->get(route('resources'));

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

    public function test_header_renders_category_megamenu_quickview(): void
    {
        $parentCat = \App\Models\ProductCategory::create([
            'category_name' => 'Air Purifiers',
            'slug'          => 'products',
            'status'        => 1,
        ]);

        $childCat = \App\Models\ProductCategory::create([
            'parent_id'     => $parentCat->id,
            'category_name' => 'Home & Office',
            'slug'          => 'home-office',
            'status'        => 1,
        ]);

        $product = \App\Models\Product::create([
            'store_id' => 1,
            'name'     => 'TA400 Air Purifier',
            'slug'     => 'ta400-air-purifier',
            'model'    => 'TA400',
            'price'    => 561.64,
            'quantity' => 10,
            'status'   => 1,
        ]);
        $childCat->products()->attach($product->id);

        \Illuminate\Support\Facades\Cache::forget('layout_header_megamenu_categories_v2');
        \Illuminate\Support\Facades\Cache::forget('layout_main_header_menu_v2');

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('quickViewCategory-products', false);
        $response->assertSee('Air Purifiers');
        $response->assertSee('Home &amp; Office', false);
        $response->assertSee('TA400 Air Purifier');
        $response->assertSee('View all Air Purifiers &rarr;', false);
        $response->assertDontSee('quickview-features-grid', false);
    }
}
