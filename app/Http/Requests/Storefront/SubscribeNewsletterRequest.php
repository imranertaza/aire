<?php

namespace App\Http\Requests\Storefront;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

use App\Rules\NotDisposableEmail;
use App\Rules\Recaptcha;

class SubscribeNewsletterRequest extends FormRequest
{
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
        if ($this->has('email')) {
            $this->merge([
                'email' => Str::lower(strip_tags(trim((string) $this->input('email', '')))),
            ]);
        }
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
            'email'                => ['required', 'string', $emailRule, 'max:150', new NotDisposableEmail()],
            'b_extra_field'        => ['nullable', 'string', 'max:100'], // Honeypot field
            'g-recaptcha-response' => [new Recaptcha()],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please provide your email address.',
            'email.email'    => 'Please enter a valid email address.',
        ];
    }
}
