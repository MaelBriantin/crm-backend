<?php

namespace App\Services;

use App\Models\ProductSize;
use App\Traits\ApiResponseTrait;

class ProductSizeService
{

    use ApiResponseTrait;

    public function createProductSize($product, $productRequest)
    { 

        foreach ($productRequest->product_sizes as $productSize) {
            $size = [
                'product_id' => $product->id,
                'size' => $productSize['size'],
                'stock' => $productSize['stock']
            ];
            
            
            try {
                ProductSize::create($size);
            } catch (\Exception $e) {
                return $this->errorResponse($e->getMessage(), 500);
            }
        }
    }
}
