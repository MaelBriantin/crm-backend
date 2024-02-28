<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Traits\ApiResponseTrait;
use App\Services\PostcodeService;
use App\Services\SectorService;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    use ApiResponseTrait;
    protected $postcodeService;
    protected $sectorService;

    public function __construct(PostcodeService $postcodeService, SectorService $sectorService)
    {
        $this->postcodeService = $postcodeService;
        $this->sectorService = $sectorService;
    }

    public function index($withPostcodes = false)
    {
        return $withPostcodes
            ? $this->successResponse(Sector::withCount('postcodes')
                                    ->with('postcodes')
                                    ->get()
                                    ->each
                                    ->append('postcodes_list'))
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
        ], 
        [ 
            'name.unique' => trans('sectors.name_unique')
        ]);

        $sector = $this->sectorService->createSector($validatedData);

        return $this->successResponse($sector);
    }

    public function update(Request $request, Sector $sector)
    {
        $validatedData = $request->validate([
            'name' => "required|string|max:255|unique:sectors,name,$request->id",
            'postcodes' => "array"
        ], 
        [ 
            'name.unique' => trans('sectors.name_unique', ['name' => $request->name])
        ]);

        $sector = $this->sectorService->updateSector($validatedData, $sector);

        return $this->successResponse($sector);
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();

        return $this->successResponse(Sector::all());
    }
}
