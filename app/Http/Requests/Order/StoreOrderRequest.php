<?php

namespace App\Http\Requests\Order;

use App\Enums\Order\PaymentMethod;
use App\Enums\Product\ProductType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:' . PaymentMethod::request(),
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.ordered_quantity' => 'required|integer|min:1',
            'products.*.product_type' => 'required|in:' . ProductType::request(),
            'products.*.product_size_id' => 'nullable|exists:product_sizes,id',
            'deferred_date' => 'nullable|date',
            'comment' => 'nullable|string',
            'vat_total' => 'required|numeric',
            'no_vat_total' => 'required|numeric',
        ];
    }
}
