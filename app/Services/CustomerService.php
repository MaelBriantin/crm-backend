<?php

namespace App\Services;

use App\Exceptions\CustomerCreationException;
use App\Models\Customer;
use App\Models\Sector;
use Illuminate\Http\Request;

class CustomerService
{
    /**
     * Create a new customer.
     *
     * @param array $validatedData The validated data for the customer.
     * @param Illuminate\Http\Request $request The request object.
     * @return void
     */
    public function createCustomer(Request $request)
    {

        $validatedData = $request->validate([
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
        ]);

        try {
            $sectorId = !is_null($request->sector) && $request->sector['id'] != 0
                ? $request->sector['id'] : null;

            if ($sectorId && !Sector::where('id', $sectorId)->exists()) {
                // Throw an exception if the sector_id does not exist in the database
                throw new \Exception(trans('customers.invalid_sector_id'));
            }

            $validatedData['sector_id'] = $sectorId;
            $validatedData['user_id'] = auth()->user()->id;

            return Customer::create($validatedData);

        } catch (\Exception $e) {
            throw new CustomerCreationException($e);
        }
    }

    /**
     * Update a customer.
     *
     * @param array $validatedData The validated data for the customer.
     * @param Customer $customer The customer to update.
     * @return void
     */
    public function updateCustomer(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'firstname' => 'string|max:45',
            'lastname' => 'string|max:45',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:25',
            'address' => 'string|max:255',
            'postcode' => 'string|max:5',
            'city' => 'string|max:255',
            'notes' => 'nullable|string|max:255',
            'sector' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        try {
            if($customer->sector_id != $request->sector['id']){
                $sectorId = !is_null($request->sector) && $request->sector['id'] != 0
                    ? $request->sector['id'] : null;
    
                if ($sectorId && !Sector::where('id', $sectorId)->exists()) {
                    // Throw an exception if the sector_id does not exist in the database
                    throw new \Exception(trans('customers.invalid_sector_id'));
                }
            } else {
                $sectorId = $customer->sector_id;
            }

            $validatedData['sector_id'] = $sectorId;
            $validatedData['user_id'] = auth()->user()->id;
            
            return $customer->update($validatedData);

        } catch (\Exception $e) {
            throw new CustomerCreationException($e);
        }
    }
}
