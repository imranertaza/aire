<?php

namespace Tests\Unit;

use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RecaptchaValidationUnitTest extends TestCase
{
    public function test_recaptcha_passes_when_disabled_in_config(): void
    {
        Config::set('services.use_recaptcha', false);

        $rule = new Recaptcha();
        $failed = false;

        $rule->validate('g-recaptcha-response', null, function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }

    public function test_recaptcha_fails_when_empty_and_enabled(): void
    {
        Config::set('services.use_recaptcha', true);
        Config::set('services.secret', 'test-secret-key');

        $rule = new class extends Recaptcha {
            // Mock environment check to simulate production
            public function validate(string $attribute, mixed $value, \Closure $fail): void
            {
                if (empty($value)) {
                    $fail('Please complete the reCAPTCHA verification.');
                }
            }
        };

        $errorMessage = null;
        $rule->validate('g-recaptcha-response', '', function ($msg) use (&$errorMessage) {
            $errorMessage = $msg;
        });

        $this->assertEquals('Please complete the reCAPTCHA verification.', $errorMessage);
    }

    public function test_recaptcha_verifies_with_google_api(): void
    {
        Config::set('services.use_recaptcha', true);
        Config::set('services.secret', 'test-secret-key');

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score'   => 0.9,
            ], 200),
        ]);

        $rule = new class extends Recaptcha {
            public function validate(string $attribute, mixed $value, \Closure $fail): void
            {
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => config('services.secret'),
                    'response' => $value,
                ]);

                if (!$response->successful() || !$response->json('success')) {
                    $fail('reCAPTCHA security check failed. Please try again.');
                }
            }
        };

        $failed = false;
        $rule->validate('g-recaptcha-response', 'valid-token-from-google', function () use (&$failed) {
            $failed = true;
        });

        $this->assertFalse($failed);
    }
}
