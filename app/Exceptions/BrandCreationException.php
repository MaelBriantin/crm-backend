<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\Brand;

class BrandCreationException extends Exception
{
    public $sku_code;

    public function __construct(QueryException $e)
    {
        if ($e->getCode() == 23000) {
            if (Str::contains($e->getMessage(), 'brands.brands_sku_code_unique')) {
                preg_match("/'([A-Z]+)'/", $e->getMessage(), $matches);
                $sku_code = $matches[1] ?? null;

                // Extract the brand name from the query
                preg_match("/values \((.*?),/", $e->getMessage(), $brandMatches);
                $brandName = $brandMatches[1] ?? null;

                // Generate a new unique SKU code
                $this->sku_code = $this->generateUniqueSkuCode($brandName);
                $message = trans('brands.sku_code_unique', ['sku_code' => $this->sku_code]);
            } else {
                $message = trans('brands.creation_error');
            }
        } else {
            $message = trans('sectors.creation_error');
        }
        parent::__construct($message, $e->getCode(), $e);
    }

    private function generateUniqueSkuCode($brandName) {
        do {
            $brandPrefix = substr(preg_replace('/[^A-Za-z]/', '', $brandName), 0, 3);
            $randomDigits = rand(100, 999);
            $sku_code = strtoupper($brandPrefix) . $randomDigits;
        } while (Brand::where('sku_code', $sku_code)->exists());
        return $sku_code;
    }
}