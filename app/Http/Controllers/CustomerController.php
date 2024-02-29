<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    use ApiResponseTrait;

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse(Customer::all());
    }

    public function show(Customer $customer): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse($customer);
    }	

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:25',
            'address' => 'required|string|max:255',
            'postcode' => 'required|string|max:5',
            'city' => 'required|string|max:255',
            'notes' => 'string|max:255',
            'sector_id' => 'int',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $customer = Customer::create($validatedData);

        return $this->successResponse($customer);
    }

    public function update(Request $request, Customer $customer): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'string|max:45',
            'last_name' => 'string|max:45',
            'email' => 'email|max:255',
            'phone' => 'string|max:25',
            'address' => 'string|max:255',
            'postcode' => 'string|max:5',
            'city' => 'string|max:255',
            'notes' => 'string|max:255',
            'sector_id' => 'int',
            'user_id' => 'int'
        ]);

        $customer->update($validatedData);

        return $this->successResponse($customer);
    }

    public function destroy(Customer $customer): \Illuminate\Http\JsonResponse
    {
        $customer->delete();

        return $this->successResponse($customer);
    }
}
