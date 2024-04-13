<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'id' => 'required|integer|exists:customers,id',
            'firstname' => 'required|string|max:45',
            'lastname' => 'required|string|max:45',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:25',
            'address' => 'required|string|max:255',
            'postcode' => 'required|string|max:5',
            'city' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'sector' => 'nullable|array',
            'is_active' => 'boolean',
            'visit_frequency_id' => 'nullable|integer|exists:visit_frequencies,id',
            'visit_frequency' => 'nullable|array',
            'visit_day' => 'nullable|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'visit_schedule' => 'nullable|string|max:255',
            'relationship_id' => 'nullable|integer|exists:relationships,id',
            'relationship' => 'nullable|array',
            'sector_id' => 'nullable|integer|exists:sectors,id',
        ];
    }
}
