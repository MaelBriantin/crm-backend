<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Traits\ApiResponseTrait;
use App\Services\PostcodeService;
use App\Services\SectorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    /**
     * @return JsonResponse
     * @param mixed $withPostcodes
     */
    public function index($withPostcodes = false): JsonResponse
    {
        if($withPostcodes) {

//            return $this->successResponse(Sector::withCount(['postcodes', 'customers'])
//                ->with('postcodes')
//                ->withCount('customers')
//                ->get()
//                ->each
//                ->append('postcodes_list'));
            $sectors = DB::select("
                SELECT sectors.id,
                    sectors.name,
                COUNT(postcodes.id) AS postcodes_count,
                COUNT(DISTINCT customers.id) AS customers_count,
                (SELECT GROUP_CONCAT(CONCAT(postcodes.postcode, ' - ', postcodes.city) SEPARATOR ', ')
                    FROM postcodes
                WHERE postcodes.sector_id = sectors.id) AS postcodes_list,
                (SELECT JSON_ARRAYAGG(JSON_OBJECT('id', postcodes.id, 'postcode', postcodes.postcode, 'city', postcodes.city))
                    FROM postcodes
                WHERE postcodes.sector_id = sectors.id) AS postcodes
                    FROM sectors
                        INNER JOIN postcodes ON sectors.id = postcodes.sector_id
                        INNER JOIN customers ON sectors.id = customers.sector_id
                GROUP BY sectors.id, sectors.name");

            collect($sectors)->map(function($sector) {
                $sector->postcodes_list = explode(', ', $sector->postcodes_list);
                $sector->postcodes = json_decode($sector->postcodes);
            });
            return $this->successResponse($sectors);
        }
        return $this->successResponse(Sector::withCount(['postcodes', 'customers'])->get());
    }
    /**
     * @return JsonResponse
     */
    public function indexWithPostcodes(): JsonResponse
    {
        return $this->index(true);
    }
    /**
     * @return JsonResponse|JsonResponse<array>
     * @param mixed $sector
     * @param mixed $withPostcodes
     */
    public function show($sector, $withPostcodes = false): JsonResponse
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
    /**
     * @return JsonResponse|JsonResponse<array>
     * @param mixed $sector
     */
    public function showWithPostcodes($sector): JsonResponse
    {
        return $this->show($sector, true);
    }
    /**
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
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
    /**
     * @return JsonResponse
     */
    public function update(Request $request, Sector $sector): JsonResponse
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
    /**
     * @return JsonResponse
     */
    public function destroy(Sector $sector): JsonResponse
    {
        $sector->delete();

        return $this->successResponse(Sector::all());
    }
}
