<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class ApplyCouponRequest extends FormRequest
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
        $code = $this->input('coupon_code') ?? $this->input('code');

        if ($code !== null) {
            $this->merge([
                'coupon_code' => trim((string) $code),
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
        return [
            'coupon_code'          => ['required', 'string', 'max:64'],
            'g-recaptcha-response' => [new \App\Rules\Recaptcha()],
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
            'coupon_code.required' => 'Please enter a valid coupon code.',
            'coupon_code.string'   => 'Coupon code format is invalid.',
            'coupon_code.max'      => 'Coupon code cannot exceed 64 characters.',
        ];
    }
}
