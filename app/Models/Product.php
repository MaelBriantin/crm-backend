<?php

namespace App\Models;

use App\Enums\Product\MeasurementUnit;
use App\Enums\Product\VatRate;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'vat_rate',
        'product_type',
        'measurement_quantity',
        'measurement_unit',
        'stock',
        'image',
        'brand_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function getVatRateAttribute($value): VatRate
    {
        return VatRate::from($value);
    }

    public function setVatRateAttribute(VatRate $value): void
    {
        $this->attributes['vat_rate'] = $value->value;
    }

    public function getMeasurementUnitAttribute($value): MeasurementUnit
    {
        return MeasurementUnit::from($value);
    }

    public function setMeasurementUnitAttribute(MeasurementUnit $value): void
    {
        $this->attributes['measurement_unit'] = $value->value;
    }

    public function productSizes()
    {
        if($this->product_type === 'clothes'){
            return $this->hasMany(ProductSize::class);
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }
}
