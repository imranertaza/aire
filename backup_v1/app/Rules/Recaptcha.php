<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Bypass if reCAPTCHA is disabled in settings or running in automated testing
        if (!config('services.use_recaptcha') || app()->environment('testing')) {
            return;
        }

        $secret = config('services.secret');
        if (empty($secret)) {
            return;
        }

        if (empty($value) || !is_string($value)) {
            $fail('Please complete the reCAPTCHA verification.');
            return;
        }

        try {
            $response = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secret,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            if (!$response->successful() || !$response->json('success')) {
                $fail('reCAPTCHA security check failed. Please try again.');
                return;
            }

            // For reCAPTCHA v3, check bot score (threshold >= 0.3)
            $score = $response->json('score');
            if ($score !== null && $score < 0.3) {
                $fail('reCAPTCHA security verification failed. Please try again.');
            }
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA verification exception: ' . $e->getMessage());
        }
    }
}
