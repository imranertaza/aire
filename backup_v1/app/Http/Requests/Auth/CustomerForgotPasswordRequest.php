<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Concerns\ThrottlesFormRequests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

use App\Rules\Recaptcha;

class CustomerForgotPasswordRequest extends FormRequest
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
            'email'                => ['required', 'email', 'max:96', 'exists:customers,email'],
            'g-recaptcha-response' => [new Recaptcha()],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.exists' => 'No account found with this email address.',
        ];
    }

    /**
     * Ensure the forgot password request is not rate limited (5 requests / 15 minutes).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        $this->ensureActionIsNotRateLimited(
            action: 'forgot-password',
            maxAttempts: 5,
            byEmail: true,
            customMessage: 'Too many password reset requests. Please try again in :time.',
        );
    }

    /**
     * Record a password reset request attempt.
     */
    public function hitRateLimiter(): void
    {
        $this->hitActionRateLimiter('forgot-password', 900);
    }
}

