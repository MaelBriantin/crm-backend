<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    use ApiResponseTrait;

    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse(
            Customer::orderBy('is_active', 'desc')
                ->get()
                ->each
                ->append(['full_name', 'full_address', 'sector_name'])
                ->load('sector')
        );
    }

    public function show(Customer $customer): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse($customer);
    }	

    public function store(Request $request)
    {
        $customer = $this->customerService->createCustomer($request);

        return $this->successResponse($customer ?? []);
    }

    public function update(Request $request, Customer $customer): \Illuminate\Http\JsonResponse
    {
        $newCustomer = $this->customerService->updateCustomer($request, $customer);

        return $this->successResponse($newCustomer ?? []);
    }

    public function destroy(Customer $customer): \Illuminate\Http\JsonResponse
    {
        $customer->delete();

        return $this->successResponse($customer);
    }
}
