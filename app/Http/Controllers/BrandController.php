<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Traits\ApiResponseTrait;


class BrandController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return $this->successResponse(Brand::all());
    }

    public function show(Brand $brand)
    {
        return $this->successResponse($brand);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|int',
            'sku_code' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
        ]);

        $brand = Brand::create($validatedData);

        return $this->successResponse($brand, 'Brand created successfully', 201);
    }

    public function update(Request $request, Brand $brand)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'user_id' => 'int',
            'sku_code' => 'string|max:255',
            'description' => 'string|max:255',
            'contact_name' => 'string|max:255',
            'contact_email' => 'string|max:255',
            'contact_phone' => 'string|max:255',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'postcode' => 'string|max:255',
        ]);

        $brand->update($validatedData);

        return $this->successResponse($brand, 'Brand updated successfully');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return $this->successResponse($brand, 'Brand deleted successfully');
    }
}
