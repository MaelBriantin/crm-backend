<?php

namespace App\Services;

use App\Exceptions\CustomerCreationException;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Relationship;
use App\Models\VisitFrequency;
use App\Models\Customer;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CustomerService
{
    /**
     * Create a new customer.
     *
     * @param StoreCustomerRequest $customerRequest The request object containing the customer data.
     * @return Customer The created customer object.
     */
    public function createCustomer(StoreCustomerRequest $customerRequest): Customer
    {

        $validatedData = $customerRequest->validated();

        try {
            $sectorId = !is_null($validatedData['sector']) && $validatedData['sector']['id'] != 0
                ? $validatedData['sector']['id'] : null;

            if ($sectorId && !Sector::where('id', $sectorId)->exists()) {
                // Throw an exception if the sector_id does not exist in the database
                throw new \Exception(trans('customers.invalid_sector_id'));
            }

            $visitFrequencyId = !is_null($validatedData['visit_frequency']) && $validatedData['visit_frequency']['id'] != 0
                ? $validatedData['visit_frequency']['id'] : null;

            if ($visitFrequencyId && !VisitFrequency::where('id', $visitFrequencyId)->exists()) {
                // Throw an exception if the visit_frequency_id does not exist in the database
                throw new \Exception(trans('customers.invalid_visit_frequency_id'));
            }

            $relationshipId = !is_null($validatedData['relationship']) && $validatedData['relationship']['id'] != 0
                ? $validatedData['relationship']['id'] : null;

            if ($relationshipId && !Relationship::where('id', $relationshipId)->exists()) {
                // Throw an exception if the relationship_id does not exist in the database
                throw new \Exception(trans('customers.invalid_relationship_id'));
            }

            $validatedData['sector_id'] = $sectorId;
            $validatedData['visit_frequency_id'] = $visitFrequencyId;
            $validatedData['relationship_id'] = $relationshipId;
            $validatedData['user_id'] = auth()->user()->id;

            unset($validatedData['visit_frequency']);
            unset($validatedData['relationship']);
            unset($validatedData['sector']);

            return Customer::create($validatedData);

        } catch (\Exception $e) {
            throw new CustomerCreationException($e);
        }
    }

    /**
     * Update a customer.
     *
     * @param UpdateCustomerRequest $customerRequest The request object containing the updated customer data.
     * @param Customer $customer The customer object to be updated.
     * @return Customer The updated customer object.
     */
    public function updateCustomer(UpdateCustomerRequest $customerRequest, Customer $customer): Customer
    {
        $validatedData = $customerRequest->validated();

        try {
            if(!is_null($validatedData['sector']) && $customer->sector_id != $validatedData['sector']['id']){
                $sectorId = !is_null($validatedData['sector']) && $validatedData['sector']['id'] != 0
                    ? $validatedData['sector']['id'] : null;

                if ($sectorId && !Sector::where('id', $sectorId)->exists()) {
                    // Throw an exception if the sector_id does not exist in the database
                    throw new \Exception(trans('customers.invalid_sector_id'));
                }
            } else {
                $sectorId = $customer->sector_id;
                unset($validatedData['sector']);
            }

            if(!is_null($validatedData['visit_frequency']) && $customer->visit_frequency_id != $validatedData['visit_frequency']['id']){
                $visitFrequencyId = !is_null($validatedData['visit_frequency']) && $validatedData['visit_frequency']['id'] != 0
                    ? $validatedData['visit_frequency']['id'] : null;

                if ($visitFrequencyId && !VisitFrequency::where('id', $visitFrequencyId)->exists()) {
                    // Throw an exception if the visit_frequency_id does not exist in the database
                    throw new \Exception(trans('customers.invalid_visit_frequency_id'));
                }
            } else if(is_null($validatedData['visit_frequency']) && $customer->visit_frequency_id != null){
                $visitFrequencyId = null;
            } else {
                $visitFrequencyId = $customer->visit_frequency_id;
            }

            if(!is_null($validatedData['relationship']) && $customer->relationship_id != $validatedData['relationship']['id']){
                $relationshipId = !is_null($validatedData['relationship']) && $validatedData['relationship']['id'] != 0
                    ? $validatedData['relationship']['id'] : null;

                if ($relationshipId && !Relationship::where('id', $relationshipId)->exists()) {
                    // Throw an exception if the relationship_id does not exist in the database
                    throw new \Exception(trans('customers.invalid_relationship_id'));
                }
            } else if(is_null($validatedData['relationship']) && $customer->relationship_id != null) {
                $relationshipId = null;
            } else {
                $relationshipId = $customer->relationship_id;
            }

            $validatedData['sector_id'] = $sectorId;
            $validatedData['visit_frequency_id'] = $visitFrequencyId;
            $validatedData['relationship_id'] = $relationshipId;
            $validatedData['user_id'] = auth()->user()->id;

            unset($validatedData['visit_frequency']);
            unset($validatedData['relationship']);
            unset($validatedData['sector']);

            $customer->update($validatedData);

            return $customer;

        } catch (\Exception $e) {
            throw new CustomerCreationException($e);
        }
    }
}
