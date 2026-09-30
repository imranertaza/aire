<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class DropdownSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'search'      => $this->has('search') ? trim((string) $this->query('search', '')) : null,
            'category_id' => $this->filled('category_id') && is_numeric($this->query('category_id')) ? (int) $this->query('category_id') : $this->query('category_id'),
            'limit'       => $this->filled('limit') && is_numeric($this->query('limit')) ? (int) $this->query('limit') : 8,
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
            'search'      => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer', 'min:1', 'exists:product_categories,id'],
            'limit'       => ['nullable', 'integer', 'min:1', 'max:50'],
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.exists' => 'Selected category is invalid or does not exist.',
            'limit.max'          => 'Search result limit cannot exceed 50 items.',
        ];
    }
}
