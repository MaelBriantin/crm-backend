<?php

namespace App\Services;

use App\Exceptions\SectorCreationException;
use App\Models\Sector;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Exception;

class SectorService
{
    protected $postcodeService;

    public function __construct(PostcodeService $postcodeService)
    {
        $this->postcodeService = $postcodeService;
    }

    public function createSector($data)
    {
        try {
            DB::beginTransaction();

            $sector = Sector::create([
                'name' => $data['name'],
                'user_id' => auth()->user()->id
            ]);

            foreach ($data['postcodes'] as $postcode) {
                $this->postcodeService->createPostcodes($postcode['postcode'], $postcode['city'], $sector->id);
            }

            DB::commit();

            return $sector;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new SectorCreationException($e);
        }
    }

    public function updateSector($data, Sector $sector)
    {
        try {
            DB::beginTransaction();
            
            if (isset($data['postcodes'])) {
                $sector->postcodes()->delete();
                foreach ($data['postcodes'] as $postcode) {
                    $this->postcodeService->createPostcodes($postcode['postcode'], $postcode['city'], $sector->id);
                }
            }

            $sector->update($data);
            
            DB::commit();

            return $sector;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new SectorCreationException($e);
        }
    }
}