<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class WizardFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare filter inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        $categorySlugs = (array) $this->input('category_slugs', []);

        $this->merge([
            'category'        => $this->input('category') ?: ($this->input('industry') ?: ($categorySlugs[0] ?? null)),
            'building_type'   => $this->input('building_type') ?: ($this->input('building') ?: ($categorySlugs[1] ?? null)),
            'room_type'       => $this->input('room_type') ?: ($this->input('room') ?: ($categorySlugs[2] ?? null)),
            'area_range'      => $this->input('area_range') ?: ($this->input('coverage') ?: ($categorySlugs[3] ?? null)),
            'occupancy'       => $this->input('occupancy') ?: ($categorySlugs[4] ?? null),
            'health_concern'  => (array) ($this->input('health_concern') ?: ($this->input('health') ?: ($categorySlugs[5] ?? []))),
            'problem'         => (array) ($this->input('problem') ?: ($categorySlugs[6] ?? [])),
            'solution_needed' => (array) ($this->input('solution_needed') ?: ($this->input('solution') ?: ($categorySlugs[7] ?? []))),
            'budget'          => $this->input('budget') ?: ($categorySlugs[8] ?? null),
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
            'category'        => ['nullable', 'string', 'max:128'],
            'building_type'   => ['nullable', 'string', 'max:128'],
            'room_type'       => ['nullable', 'string', 'max:128'],
            'area_range'      => ['nullable', 'string', 'max:128'],
            'occupancy'       => ['nullable', 'string', 'max:128'],
            'health_concern'  => ['nullable', 'array'],
            'problem'         => ['nullable', 'array'],
            'solution_needed' => ['nullable', 'array'],
            'budget'          => ['nullable', 'string', 'max:64'],
        ];
    }
}
