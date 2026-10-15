<?php

namespace App\Http\Requests\Product\Advanced;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateCategoriesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_ids'    => 'required|array|min:1',
            'product_ids.*'  => 'integer|exists:products,id',
            'category_ids'   => 'required|array',
            'category_ids.*' => 'integer|exists:product_categories,id',
        ];
    }
}
