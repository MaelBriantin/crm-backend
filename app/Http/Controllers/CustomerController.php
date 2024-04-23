<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
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
        // return $this->successResponse(
        //     Customer::orderBy('is_active', 'desc')
        //         ->get()
        //         ->each
        //         ->append(['full_name', 'full_address', 'sector_name'])
        //         ->load('sector')
        // );
        return $this->successResponse(CustomerResource::collection(Customer::all()));
    }

    public function show(Customer $customer): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse($customer);
    }	

    public function store(StoreCustomerRequest $customerRequest)
    {
        $customer = $this->customerService->createCustomer($customerRequest);

        return $this->successResponse($customer ?? []);
    }

    public function update(UpdateCustomerRequest $customerRequest, Customer $customer): \Illuminate\Http\JsonResponse
    {
        $newCustomer = $this->customerService->updateCustomer($customerRequest, $customer);

        return $this->successResponse($newCustomer ?? []);
    }

    public function destroy(Customer $customer): \Illuminate\Http\JsonResponse
    {
        $customer->delete();

        return $this->successResponse($customer);
    }
}
