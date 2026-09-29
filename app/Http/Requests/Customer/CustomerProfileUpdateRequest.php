<?php

namespace App\Http\Requests\Customer;

use App\Rules\NotDisposableEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomerProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('customer')->check();
    }

    /**
     * Prepare inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'firstname' => trim((string) $this->input('firstname', '')),
            'lastname'  => trim((string) $this->input('lastname', '')),
            'email'     => Str::lower(trim((string) $this->input('email', ''))),
            'phone'     => trim((string) $this->input('phone', '')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customerId = Auth::guard('customer')->id();
        $emailRule = app()->environment('testing') ? 'email:rfc' : 'email:rfc,dns';

        return [
            'firstname'        => ['required', 'string', 'max:64'],
            'lastname'         => ['required', 'string', 'max:64'],
            'email'            => ['required', 'string', $emailRule, 'max:96', 'unique:customers,email,' . $customerId, new NotDisposableEmail()],
            'phone'            => ['nullable', 'string', 'max:32'],
            'current_password' => ['required_with:new_password'],
            'new_password'     => ['nullable', 'string', 'min:6', 'confirmed'],
            'pic'              => ['nullable', 'image', 'max:2048'],
        ];
    }
}
