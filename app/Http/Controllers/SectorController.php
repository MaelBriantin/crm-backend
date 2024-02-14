<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Traits\ApiResponseTrait;
use App\Services\PostcodeService;
use App\Models\Postcode;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    use ApiResponseTrait;
    protected $postcodeService;

    public function __construct(PostcodeService $postcodeService)
    {
        $this->postcodeService = $postcodeService;
    }

    public function index($withPostcodes = false)
    {
        return $withPostcodes
            ? $this->successResponse(Sector::withCount('postcodes')->with('postcodes')->get())
            : $this->successResponse(Sector::withCount('postcodes')->get());
    }

    public function indexWithPostcodes()
    {
        return $this->index(true);
    }

    public function show($sector, $withPostcodes = false)
    {
        $result = is_numeric($sector)
            ? Sector::withCount('postcodes')->find($sector)
            : Sector::withCount('postcodes')->where('name', '=', $sector)->first();

        if ($result) {
            if ($withPostcodes) {
                $result->load('postcodes');
            }
            return $this->successResponse($result);
        }

        return $this->emptyResponse();
    }


    public function showWithPostcodes($sector)
    {
        return $this->show($sector, true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => "required|string|max:255|unique:sectors,name",
            'postcodes' => "array"
        ]);

        $sector = Sector::create([
            'name' => $validatedData['name'],
            'user_id' => auth()->user()->id
        ]);

        if ($request->has('postcodes')) {
            foreach ($request['postcodes'] as $postcode) {
                $this->postcodeService->createPostcodes($postcode['postcode'], $postcode['city'], $sector->id);
            }
        }

        return $this->successResponse(Sector::withCount('postcodes')->get());
    }

    public function update(Request $request, Sector $sector)
    {
        $validatedData = $request->validate([
            // name must be unique, except for the actual sector name
            'name' => "required|string|max:255|unique:sectors,name,$sector->id",
            'postcode' => "array"
        ]);

        if ($request->has('postcodes')) {
            foreach ($request->input('postcodes', []) as $postcode) {
                $postcodeValue = $postcode['postcode'];
                $postcodeCity = $postcode['city'];
                $this->postcodeService->createPostcodes($postcodeValue, $postcodeCity, $sector->id);
            }
        }

        $sector->update($validatedData);

        return $this->successResponse(Sector::all());
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();

        return $this->successResponse(Sector::all());
    }
}
