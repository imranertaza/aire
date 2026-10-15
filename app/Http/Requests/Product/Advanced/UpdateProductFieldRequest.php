<?php

namespace App\Http\Requests\Product\Advanced;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'    => 'required|integer|exists:products,id',
            'field' => 'required|string|in:status,featured',
            'value' => 'required',
        ];
    }
}
