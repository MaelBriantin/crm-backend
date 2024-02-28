<?php 

namespace App\Services;
use App\Models\Brand;
use App\Traits\ApiResponseTrait;

class BrandService
{
    use ApiResponseTrait;

    public function createBrand($data)
    {
        $data['sku_code'] = $this->generateUniqueSkuCode($data['name']);
        $data['user_id'] = auth()->id();

        $brand = Brand::create($data);

        return $brand;
    }

    private function generateUniqueSkuCode($brandName) {
        do {
            $brandName = iconv('UTF-8', 'ASCII//TRANSLIT', $brandName);
            $brandPrefix = substr(preg_replace('/[^A-Za-z0-9]/', '', $brandName), 0, 3);
            $randomDigits = rand(100, 999);
            $sku_code = strtoupper($brandPrefix) . $randomDigits;
        } while (Brand::where('sku_code', $sku_code)->exists());
        return $sku_code;
    }
}