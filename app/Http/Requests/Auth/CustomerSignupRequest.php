<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Concerns\ThrottlesFormRequests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

use App\Rules\NotDisposableEmail;
use App\Rules\Recaptcha;

class CustomerSignupRequest extends FormRequest
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
            'name'  => trim((string) $this->input('name', '')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $emailRule = app()->environment('testing') ? 'email:rfc' : 'email:rfc,dns';

        return [
            'name'                 => ['required', 'string', 'max:64'],
            'email'                => ['required', 'string', $emailRule, 'max:96', 'unique:customers,email', new NotDisposableEmail()],
            'password'             => ['required', 'string', 'min:6'],
            'phone'                => ['nullable', 'string', 'max:32'],
            'b_extra_field'        => ['nullable', 'string', 'max:100'], // Honeypot field
            'g-recaptcha-response' => [new Recaptcha()],
        ];
    }

    /**
     * Ensure the registration request is not rate limited (5 registrations / hour per IP).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        $this->ensureActionIsNotRateLimited(
            action: 'signup',
            maxAttempts: 5,
            byEmail: false,
            customMessage: 'Too many registration attempts. Please try again in :time.',
        );
    }

    /**
     * Record a registration attempt against the rate limiter.
     */
    public function hitRateLimiter(): void
    {
        $this->hitActionRateLimiter('signup', 3600, byEmail: false);
    }
}
