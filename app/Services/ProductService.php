<?php 

namespace App\Services;

use App\Enums\Product\ProductType;
use App\Http\Requests\StoreProductRequest;
use App\Traits\ApiResponseTrait;
use App\Models\Product;

class ProductService
{
    use ApiResponseTrait;

    public function createProduct(StoreProductRequest $productRequest)
    {
        try {
            $data = $productRequest->validated();
            $data['user_id'] = auth()->user()->id;

            if($productRequest->product_type === ProductType::CLOTHES) {
                $data['measurement_unit'] = null;
            }

            if($productRequest->product_type === ProductType::DEFAULT) {
                $data['vat_rate'] = null;
            }

            return Product::create($data);
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
