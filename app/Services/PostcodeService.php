<?php

namespace App\Services;

use App\Models\Postcode;
use App\Traits\ApiResponseTrait;

class PostcodeService
{
    use ApiResponseTrait;

    public function createPostcodes($postcodeValue, $city, $sectorId)
    {
        if ($postcodeValue[3] === '*') {
            $prefix = substr($postcodeValue, 0, 3);
            $suffixes = ['00', '10', '20', '30', '40', '50', '60', '70', '80', '90'];

            foreach ($suffixes as $suffix) {
                $newPostcode = $prefix . $suffix;

                Postcode::updateOrCreate([
                    'postcode' => $newPostcode,
                    'city' => $city,
                    'sector_id' => $sectorId
                ]);
            }
        } else {
            Postcode::updateOrCreate([
                'postcode' => $postcodeValue,
                'city' => $city,
                'sector_id' => $sectorId
            ]);
        }
    }

    public function getPostcodes($postcode)
    {
        if (is_string($postcode) && isset($postcode[3]) && $postcode[3] === '*') {
            $prefix = substr($postcode, 0, 3);
            return Postcode::where('postcode', 'like', "{$prefix}%")->get();
        } else {
            $result = Postcode::find($postcode);

            if (!$result) {
                $result = Postcode::with('sector')->where('postcode', '=', $postcode)->first();
            }

            if ($result) {
                $result->load('sector');
                return $result;
            } else {
                return null;
            }
        }
    }
}
