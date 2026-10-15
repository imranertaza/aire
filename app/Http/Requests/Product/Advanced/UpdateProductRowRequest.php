<?php

namespace App\Http\Requests\Product\Advanced;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'       => 'required|integer|exists:products,id',
            'name'     => 'required|string|max:255',
            'model'    => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ];
    }
}
