<?php

namespace App\Http\Controllers;

use App\Enums\Order\PaymentMethod;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\ApiResponseTrait;
use Exception;

class OrderController extends Controller
{
    use ApiResponseTrait;

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @throws Exception
     */
    public function getOrderOptions()
    {
        $orderOptions = [
            'payment_methods' => PaymentMethod::toLabelValue(),
        ];
        return static::successResponse([$orderOptions]);
    }

    public function index()
    {
        $orders = Order::withCount('orderedProducts')
            ->orderByDesc('order_number')
            ->with('customer', 'sector')
            ->get();
        $orders->each(function ($order) {
            $order->append([
                'payment_status',
                'payment_status_label',
            ]);
        });
        return static::successResponse($orders);
    }

    public function show(Order $order)
    {
        $order->load('customer', 'sector', 'orderedProducts');
        $order->append([
            'payment_status',
            'payment_status_label',
            'payment_method_label'
        ]);
        return static::successResponse($order);
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request);
            return static::successResponse($order, 201);
        } catch (Exception $e) {
            return static::errorResponse($e->getMessage(), 500);
        }
    }
}
