<?php

namespace App\Http\Requests\Product\Advanced;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductDescriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'       => 'required|integer|exists:products,id',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
        ];
    }
}
