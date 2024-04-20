<?php

namespace App\Http\Controllers;

use App\Enums\Product\MeasurementUnit;
use App\Enums\Product\ProductType;
use App\Enums\Product\VatRate;
use App\Http\Requests\Product\StoreProductRequest;
use App\Services\ProductService;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function productOptionsIndex()
    {
        $productOptions = [
            'measurement_units' => MeasurementUnit::toLabelValue(),
            'vat_rates' => VatRate::toLabelValue(),
            'product_types' => ProductType::toLabelValue()
        ];
        return $this->successResponse([
            $productOptions
        ]);
    }

    public function index()
    {
        return $this->successResponse(Product::all());
    }

    public function show(Product $product)
    {
        return $this->successResponse($product);
    }

    public function store(StoreProductRequest $storeProductRequest)
    {
        $product = $this->productService->createProduct($storeProductRequest);

        return $this->successResponse($product, 'Product created successfully', 201);
    }
}