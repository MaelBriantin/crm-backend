<?php

namespace App\Http\Controllers;

use App\Enums\Product\MeasurementUnit;
use App\Enums\Product\VatRate;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;
    public function productOptionsIndex()
    {
        return $this->successResponse([
            'measurement_units' => MeasurementUnit::toArray(),
            'vat_rates' => VatRate::toArray(),
        ]);
    }
}
