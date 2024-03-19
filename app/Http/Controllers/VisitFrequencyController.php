<?php

namespace App\Http\Controllers;

use App\Models\VisitFrequency;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class VisitFrequencyController extends Controller
{
    use ApiResponseTrait;

    public function index() {
        return $this->successResponse(VisitFrequency::all());
    }

    public function show(VisitFrequency $visitFrequency) {
        return $this->successResponse($visitFrequency);
    }
}
