<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'description' => 'nullable|string|max:255',
            'reference' => 'string|max:45',
            'purchase_price' => 'numeric',
            'selling_price' => 'numeric',
            'brand' => 'array',
            'product_type' => 'string',
            'measurement_quantity' => 'integer',
            'measurement_unit' => 'string',
            'vat_rate' => 'numeric',
            'stock' => 'integer',
            'image' => 'string',
            'is_active' => 'boolean',
        ];
    }
}
