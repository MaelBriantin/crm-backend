<?php

namespace App\Services;

use App\Enums\Product\ProductType;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Models\ProductSize;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class OrderedProductService
{
    use ApiResponseTrait;

    /**
     * @throws Exception
     */
    public function createOrderedProduct($product, $order_id): OrderedProduct
    {
        $validatedData = validator($product, [
            'product_type' => 'required|string|in:' . ProductType::request(),
            'ordered_quantity' => 'required|integer',
            'product_id' => 'required|integer|exists:products,id',
            'product_size_id' => 'nullable|integer|exists:product_sizes,id',
        ])->validated();

        $product = Product::find($validatedData['product_id']);
        if (!$this->canUpdateProductQuantity($validatedData['ordered_quantity'], $product, ProductSize::find($validatedData['product_size_id'] ?? null))) {
            throw new \Exception(trans('orders.product_quantity_error', ['product_name' => $product->name]));
        }
        $newOrderedProduct = new OrderedProduct();
        $newOrderedProduct->order_id = $order_id;
        $newOrderedProduct->product_type = $validatedData['product_type'];
        $newOrderedProduct->ordered_product_id = $validatedData['product_type' === ProductType::CLOTHES ? 'product_size_id' : 'product_id'];
        $newOrderedProduct->ordered_quantity = $validatedData['ordered_quantity'];
        $newOrderedProduct->product_name = $product['name'];
        $newOrderedProduct->product_reference = $product['reference'];
        $newOrderedProduct->no_vat_price = $product['selling_price'];
        $newOrderedProduct->vat_price = $product['selling_price_with_vat'];

        if (isset($validatedData['product_size_id'])) {
            self::updateProductQuantity(
                $validatedData['ordered_quantity'],
                Product::find($validatedData['product_id']),
                ProductSize::find($validatedData['product_size_id'])
            );
        } else {
            self::updateProductQuantity(
                $validatedData['ordered_quantity'],
                Product::find($validatedData['product_id'])
            );
        }

        $newOrderedProduct->save();

        return $newOrderedProduct;
    }

    private function canUpdateProductQuantity($ordered_quantity, $product, $product_size = null): bool
    {
        if ($product_size) {
            return $product_size->stock >= $ordered_quantity;
        }
        return $product->stock >= $ordered_quantity;
    }

    private function updateProductQuantity($ordered_quantity, $product, $product_size = null): void
    {
        if ($product_size) {
            ProductSize::where('id', $product_size->id)
                ->update(['stock' => $product_size->stock - $ordered_quantity]);
        }
        Product::where('id', $product->id)
            ->update(['stock' => $product->stock - $ordered_quantity]);
    }
}
