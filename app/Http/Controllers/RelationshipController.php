<?php

namespace App\Http\Controllers;

use App\Models\Relationship;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\Relations\Relation;

class RelationshipController extends Controller
{

    use ApiResponseTrait;

    public function index()
    {
        return $this->successResponse(Relationship::all());
    }

    public function show(Relationship $relationship)
    {
        return $this->successResponse($relationship);
    }
}
