<?php

namespace App\Services;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sector;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

        if (isset($validatedData['deferred_date'])) {
//            $deferredDate = Carbon::createFromFormat('Y-m-d', $validatedData['deferred_date']);
//            if ($deferredDate->isPast() || $deferredDate->isToday()) {
//                throw new Exception(trans('orders.deferred_date_invalid'));
//            }
            if (!$this->checkDeferredDateStatus($validatedData['deferred_date'])) {
                throw new Exception(trans('orders.deferred_date_invalid'));
            }
        }

        try {
            DB::beginTransaction();
            $total = $this->calculateTotal($validatedData['products']);
            $customer = Customer::find($validatedData['customer_id']);
            $sector = Sector::find($customer->sector_id) ?? null;

            $newOrder = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => auth()->user()->id,
                'sector_id' => $sector->id ?? null,
                'customer_id' => $validatedData['customer_id'],
                'customer_full_name' => $customer->firstname . ' ' . $customer->lastname,
                'customer_address' => $customer->address,
                'customer_city' => $customer->postcode . ' - ' . $customer->city,
                'order_date' => now(),
                'payment_method' => $validatedData['payment_method'],
                'comment' => $validatedData['comment'] ?? null,
                'deferred_date' => $validatedData['deferred_date'] ?? null,
                'paid_at' => isset($validatedData['deferred_date']) ? null : now(),
                'vat_total' => $total['vat_total'],
                'no_vat_total' => $total['no_vat_total'],
            ]);

            foreach ($validatedData['products'] as $product) {
                $this->orderedProductService->createOrderedProduct($product, $newOrder->id);
            }


            DB::commit();

            return Order::where('id', $newOrder->id)->with('orderedProducts')->first();

        } catch (QueryException $e) {

            DB::rollBack();
            // throw new Exception(trans('orders.order_creation_error'));
            throw new Exception($e->getMessage());

        }
    }

    public function confirmPayment(Order $order): void
    {
        $order->update([
            'paid_at' => now()
        ]);
    }

    private function calculateTotal($products): array
    {
        $productIds = array_column($products, 'product_id');
        $foundProducts = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $total_vat = 0;
        $total_no_vat = 0;

        foreach ($products as $product) {
            $product = (object) $product;
            $foundProduct = $foundProducts[$product->product_id];
            $total_vat += $foundProduct->selling_price_with_vat * $product->ordered_quantity;
            $total_no_vat += $foundProduct->selling_price * $product->ordered_quantity;
        }
        return [
            'vat_total' => $total_vat,
            'no_vat_total' => $total_no_vat,
        ];
    }

    private function generateOrderNumber(): string
    {
        $year = now()->year;
        $month = now()->month;
        $orderCount = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
        $newOrderNumber = $orderCount + 1;
        return $year . str_pad($month, 2, '0', STR_PAD_LEFT) . str_pad($newOrderNumber, 4, '0', STR_PAD_LEFT);
    }

    public function checkDeferredDateStatus($deferredDate): bool
    {
        $deferredDate = Carbon::createFromFormat('Y-m-d', $deferredDate);
        if ($deferredDate->isPast() || $deferredDate->isToday()) {
            return false;
        }
        return true;
    }
}
