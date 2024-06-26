<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Product\MeasurementUnit;
use App\Enums\Product\VatRate;
use App\Enums\Product\ProductType;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'reference' => 'required|string|max:45|unique:products,reference',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'selling_price_with_vat' => 'required|numeric',
            'brand_id' => 'required|integer|exists:brands,id',
            'product_type' => ['required', 'string', 'in:' . ProductType::request()],
            'measurement_quantity' => 'nullable|integer',
            'measurement_unit' => ['nullable', 'string', 'in:' . MeasurementUnit::request()],
            'vat_rate' => ['string', 'in:' . VatRate::request()],
            'stock' => 'nullable|integer',
            'alert_stock' => 'nullable|integer',
            'image' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'reference.unique' => trans('products.reference_unique')
        ];
    }
}
