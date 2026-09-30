<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Concerns\ThrottlesFormRequests;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

use App\Rules\Recaptcha;

class CustomerSigninRequest extends FormRequest
{
    use ThrottlesFormRequests;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => Str::lower(trim((string) $this->input('email', ''))),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'                => ['required', 'email', 'max:96'],
            'password'             => ['required', 'string'],
            'g-recaptcha-response' => [new Recaptcha()],
        ];
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        $this->ensureActionIsNotRateLimited(
            action: 'signin',
            maxAttempts: 5,
            byEmail: true,
            customMessage: 'Too many failed login attempts. Please try again in :time.',
            onLockout: fn () => event(new Lockout($this))
        );
    }

    /**
     * Increment the rate limiter attempts.
     */
    public function hitRateLimiter(): void
    {
        $this->hitActionRateLimiter('signin', 60);
    }

    /**
     * Clear the rate limiter attempts.
     */
    public function clearRateLimiter(): void
    {
        $this->clearActionRateLimiter('signin');
    }
}

