<?php

namespace App\Http\Requests\Checkout;

use App\Rules\NotDisposableEmail;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $emailRule = app()->environment('testing') ? 'email:rfc' : 'email:rfc,dns';

        $rules = [
            'email'              => ['required', 'string', $emailRule, 'max:96', new NotDisposableEmail()],
            'phone'              => ['required', 'string', 'max:32'],
            'payment_country_id' => ['required', 'integer'],
            'payment_city'       => ['required', 'string', 'max:128'],
            'address_1'          => ['required', 'string', 'max:128'],
            'address_2'          => ['nullable', 'string', 'max:128'],
            'zip'                  => ['required', 'string', 'max:10'],
            'shippingMethod'       => ['required', 'string'],
            'payment_method'       => ['nullable', 'string'],
            'g-recaptcha-response' => [new \App\Rules\Recaptcha()],
        ];

        if ($this->has('payment_firstname') && $this->has('payment_lastname')) {
            $rules['payment_firstname'] = ['required', 'string', 'max:32'];
            $rules['payment_lastname']  = ['required', 'string', 'max:32'];
        } else {
            $rules['full_name'] = ['required', 'string', 'max:64'];
        }

        if ($this->filled('new_acc_create')) {
            $rules['password'] = ['required', 'string', 'min:6'];
        }

        if ($this->filled('shipping_else')) {
            $rules['shipping_firstname']  = ['required', 'string', 'max:32'];
            $rules['shipping_lastname']   = ['required', 'string', 'max:32'];
            $rules['shipping_phone']      = ['required', 'string', 'max:32'];
            $rules['shipping_country_id'] = ['required', 'integer'];
            $rules['shipping_city']       = ['required', 'string', 'max:128'];
            $rules['shipping_address_1']  = ['required', 'string', 'max:128'];
            $rules['shipping_postcode']   = ['required', 'string', 'max:10'];
        }

        return $rules;
    }
}
