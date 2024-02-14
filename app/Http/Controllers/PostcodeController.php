<?php

namespace App\Http\Controllers;

use App\Models\Postcode;
use App\Traits\ApiResponseTrait;
use App\Services\PostcodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostcodeController extends Controller
{

    use ApiResponseTrait;

    protected $postcodeService;

    public function __construct(PostcodeService $postcodeService)
    {
        $this->postcodeService = $postcodeService;
    }

    public function index()
    {
        return $this->successResponse(Postcode::all()->load('sector'));
    }

    public function show(int | string $postcode): JsonResponse
    {
        $result = $this->postcodeService->getPostcodes($postcode);

        return is_null($result)
            ? $this->emptyResponse()
            : $this->successResponse($result);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'postcode' => 'required|string|max:5|unique:postcodes,postcode',
            'city' => 'required|string|max:255',
            'sector_id' => 'required|int',
        ]);

        $this->postcodeService->createPostcodes($validatedData['postcode'], $validatedData['city'], $validatedData['sector_id']);

        return $this->successResponse(Postcode::all());
    }

    public function update(Request $request, Postcode $postcode)
    {
        $validatedData = $request->validate([
            'postcode' => "required|string|max:5|unique:postcodes,postcode,$postcode->id",
            'city' => 'required|string|max:255',
            'sector_id' => "required|int"
        ]);

        $postcode->update($validatedData);

        return $this->successResponse(Postcode::all());
    }

    public function destroy(Postcode $postcode)
    {
        $postcode->delete();

        return $this->successResponse(Postcode::all());
    }
}
