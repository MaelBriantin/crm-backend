<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

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
            CustomerResource::collection(
                Customer::with('sector', 'relationship', 'visitFrequency')
                    ->get()
            )
        );
    }

    public function show(Customer $customer): \Illuminate\Http\JsonResponse
    {
        $customer
            ->load('orders', 'orders.orderedProducts', 'sector', 'relationship', 'visitFrequency')
            ->append('vat_average_order_amount', 'no_vat_average_order_amount');
        return $this->successResponse($customer);
    }

    public function store(StoreCustomerRequest $customerRequest): JsonResponse
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
