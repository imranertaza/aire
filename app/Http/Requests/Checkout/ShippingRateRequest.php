<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRateRequest extends FormRequest
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
        $cityId    = $this->input('city_id') ?? $this->input('shipCityId');
        $countryId = $this->input('country_id') ?? $this->input('payment_country_id');
        $paymethod = $this->input('paymethod') ?? $this->input('shipping_method', 'zone_rate');

        $this->merge([
            'city_id'    => $cityId !== null ? trim((string) $cityId) : null,
            'country_id' => $countryId !== null && is_numeric($countryId) ? (int) $countryId : null,
            'paymethod'  => trim((string) $paymethod),
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
            'city_id'    => ['nullable', 'string', 'max:128'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'paymethod'  => ['nullable', 'string', 'max:64'],
        ];
    }
}
