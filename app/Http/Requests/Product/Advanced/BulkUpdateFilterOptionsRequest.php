<?php

namespace App\Http\Requests\Product\Advanced;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateFilterOptionsRequest extends FormRequest
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
            'filter_options' => 'required|array',
        ];
    }
}
