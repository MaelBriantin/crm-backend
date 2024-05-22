<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Traits\ApiResponseTrait;
use App\Exceptions\BrandCreationException;
use Illuminate\Database\QueryException;
use App\Services\BrandService;


class BrandController extends Controller
{
    use ApiResponseTrait;

    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

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
            'notes' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
        ]);

        try {
            $brand = $this->brandService->createBrand($validatedData);
            return $this->successResponse($brand);
        } catch (QueryException $e) {
            throw new BrandCreationException($e);
        }
    }

    public function update(Request $request, Brand $brand)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'sku_code' => 'string|max:255',
            'notes' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:5',
        ]);

        $brand->update($validatedData);
        return $this->successResponse($brand);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return $this->successResponse($brand);
    }
}
