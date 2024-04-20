<?php

namespace App\Services;

use App\Enums\Product\ProductType;
use App\Http\Requests\Product\StoreProductRequest;
use App\Traits\ApiResponseTrait;
use App\Models\Product;
use App\Models\ProductSize;

class ProductService
{
    use ApiResponseTrait;

    private $productSizeService;

    public function __construct(ProductSizeService $productSizeService)
    {
        $this->productSizeService = $productSizeService;
    }

    public function createProduct(StoreProductRequest $productRequest)
    {
        try {
            $data = $productRequest->validated();
            $data['user_id'] = auth()->user()->id;

            $newProduct = Product::create($data);
            
            if ($newProduct['product_type'] === ProductType::CLOTHES) {
                $this->productSizeService->createProductSize($newProduct, $productRequest);
            }

            return $newProduct;
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function updateProduct(StoreProductRequest $productRequest, Product $product)
    {
        try {
            $data = $productRequest->validated();
            $data['user_id'] ?? $data['user_id'] = auth()->user()->id;

            $product->update($data);
            return $product;
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}