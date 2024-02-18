<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class SectorCreationException extends Exception
{
    public $postcode;

    public function __construct(QueryException $e)
    {
        if ($e->getCode() == 23000) {
            if (Str::contains($e->getMessage(), 'sectors.sectors_name_unique')) {
                $message = trans('sectors.name_unique');
            } elseif (Str::contains($e->getMessage(), 'postcodes.postcodes_postcode_unique')) {
                preg_match("/'(\d+)'/", $e->getMessage(), $matches);
                $postcode = $matches[1] ?? null;
                $message = trans('postcodes.postcode_unique', ['postcode' => $postcode]);
                $this->postcode = $postcode;
            } 
            else if (str_contains($e->getMessage(), 'postcodes.postcodes_postcode_city_unique')){
                preg_match("/'(\d+-[^']+)'/", $e->getMessage(), $matches);
                $postcode_city = $matches[1] ?? null;
                $message = trans('postcodes.postcode_city_unique', ['postcode_city' => $postcode_city]);
                $this->postcode = $postcode_city;
            }
            else {
                $message = trans('sectors.creation_error');
            }
        } else {
            $message = trans('sectors.creation_error');
        }

        parent::__construct($message, $e->getCode(), $e);
    }
}