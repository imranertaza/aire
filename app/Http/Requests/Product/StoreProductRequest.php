<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation (decode multipart stringified JSONs).
     */
    protected function prepareForValidation(): void
    {
        $jsonFields = [
            'category_ids',
            'related_ids',
            'bought_together_ids',
            'options',
            'filter_options',
            'attributes',
            'deleted_images',
            'faqs',
            'applications',
            'showcase_feature_pills',
            'showcase_spec_highlights',
            'showcase_matched_features',
            'showcase_health_tags',
            'landing_specs_groups',
        ];

        foreach ($jsonFields as $field) {
            if ($this->has($field) && is_string($this->input($field))) {
                $decoded = json_decode($this->input($field), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $this->merge([$field => $decoded]);
                }
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Core Details
            'name'                  => 'required|string|max:255',
            'model'                 => 'required|string|max:255',
            'slug'                  => 'nullable|string|max:255|unique:products,slug',
            'product_code'          => 'nullable|string|max:255',
            'brand_id'              => 'nullable|integer|exists:brands,id',
            'price'                 => 'required|numeric|min:0',
            'quantity'              => 'required|integer|min:0',
            'featured'              => 'nullable|in:0,1,true,false',
            'status'                => 'nullable|in:0,1,true,false',
            'date_available'        => 'nullable|date',
            'weight'                => 'nullable|numeric|min:0',
            'length'                => 'nullable|numeric|min:0',
            'width'                 => 'nullable|numeric|min:0',
            'height'                => 'nullable|numeric|min:0',
            'sort_order'            => 'nullable|integer|min:0',

            // Main & Gallery Media
            'main_image'            => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'gallery_images'        => 'nullable|array',
            'gallery_images.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',

            // Relational Product & Category IDs
            'category_ids'          => 'nullable|array',
            'category_ids.*'        => 'integer|exists:product_categories,id',
            'related_ids'           => 'nullable|array',
            'related_ids.*'         => 'integer|exists:products,id',
            'bought_together_ids'   => 'nullable|array',
            'bought_together_ids.*' => 'integer|exists:products,id',

            // Options & Variant Attributes
            'options'               => 'nullable|array',
            'options.*.option_id'   => 'required_with:options|integer|exists:options,id',
            'options.*.option_value_id' => 'required_with:options|integer|exists:option_values,id',
            'options.*.quantity'    => 'nullable|integer|min:0',
            'options.*.subtract'    => 'nullable|in:0,1,true,false',
            'options.*.price'       => 'nullable|numeric|min:0',
            'options.*.price_prefix'=> 'nullable|in:+,-',

            'filter_options'        => 'nullable|array',
            'filter_options.*.filter_option_id'       => 'required_with:filter_options|integer|exists:filter_options,id',
            'filter_options.*.filter_option_value_id' => 'required_with:filter_options|integer|exists:filter_option_values,id',

            'attributes'            => 'nullable|array',
            'attributes.*.attribute_group_id' => 'required_with:attributes|integer|exists:product_attribute_groups,id',
            'attributes.*.name'     => 'required_with:attributes|string|max:255',
            'attributes.*.details'  => 'nullable|string',
            'attributes.*.sort_order' => 'nullable|integer|min:0',

            // SEO & Descriptions
            'description'           => 'nullable|string',
            'tag'                   => 'nullable|string|max:255',
            'meta_title'            => 'nullable|string|max:255',
            'meta_description'      => 'nullable|string|max:255',
            'meta_keyword'          => 'nullable|string|max:255',
            'video'                 => 'nullable|string|max:255',

            // Specials & Free Delivery
            'special_price'         => 'nullable|numeric|min:0',
            'special_start_date'    => 'nullable|date',
            'special_end_date'      => 'nullable|date|after_or_equal:special_start_date',
            'product_free_delivery' => 'nullable|in:0,1,true,false',

            // Auxiliary Files & PDFs
            'documentation_pdf'     => 'nullable|file|mimes:pdf|max:10240',
            'safety_pdf'            => 'nullable|file|mimes:pdf|max:10240',
            'instructions_pdf'      => 'nullable|file|mimes:pdf|max:10240',
            'description_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'specs_image'           => 'nullable',
            'features_image'        => 'nullable',
            'technology_image'      => 'nullable',
            'overview_image'        => 'nullable',

            // Showcase & Landing Files
            'showcase_hero_bg_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'showcase_diagram_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'landing_hero_image_file'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'landing_science_image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'landing_lifestyle_image_file'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'landing_filter_tech_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'landing_specs_image_file'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // FAQs & Applications
            'faqs'                  => 'nullable|array',
            'faqs.*.question'       => 'nullable|string|max:500',
            'faqs.*.answer'         => 'nullable|string',
            'faqs.*.sort_order'     => 'nullable|integer|min:0',

            'applications'          => 'nullable|array',
            'applications.*.title'  => 'nullable|string|max:255',
            'applications.*.description' => 'nullable|string',
            'applications.*.badge'  => 'nullable|string|max:100',
            'applications.*.sort_order'  => 'nullable|integer|min:0',
        ];
    }
}
