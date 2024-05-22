<?php

namespace App\Services;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use DB;
use Exception;
use Illuminate\Database\QueryException;

class OrderService
{
    protected OrderedProductService $orderedProductService;

    public function __construct(OrderedProductService $orderedProductService)
    {
        $this->orderedProductService = $orderedProductService;
    }

    /**
     * @throws Exception
     */
    public function createOrder(StoreOrderRequest $request)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();
            $newOrder = Order::create([
                'user_id' => auth()->user()->id,
                'customer_id' => $validatedData['customer_id'],
                'order_date' => now(),
                'payment_method' => $validatedData['payment_method'],
                'comment' => $validatedData['comment'],
                'deferred_date' => $validatedData['deferred_date'] ?? null,
                'is_payed' => !$validatedData['deferred_date'],
                'vat_total' => $validatedData['vat_total'],
                'no_vat_total' => $validatedData['no_vat_total'],
            ]);

            foreach ($validatedData['products'] as $product) {
                $this->orderedProductService->createOrderedProduct($product, $newOrder->id);
            }

            DB::commit();

            return Order::where('id', $newOrder->id)->with('orderedProducts')->first();

        } catch (QueryException $e) {

            DB::rollBack();
            throw new Exception(trans('orders.order_creation_error'));

        }
    }
}
