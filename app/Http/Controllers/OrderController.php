<?php

namespace App\Http\Controllers;

use App\Enums\Order\PaymentMethod;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

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