<?php

namespace App\Models;

use App\Enums\Product\MeasurementUnit;
use App\Enums\Product\ProductType;
use App\Enums\Product\VatRate;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function casts(): array
    {
        return [
            'purchase_price' => 'float',
            'selling_price' => 'float',
            'vat_rate' => 'float',
            'is_active' => 'boolean',
        ];
    }

    protected $with = [
        'productSizes',
    ];

    protected $appends = [
        'product_type_label',
        'brand_name',
    ];

    public function getBrandNameAttribute()
    {
        return $this->brand->name;
    }

    public function getProductTypeLabelAttribute()
    {
        return trans('products.product_types.' . $this->product_type);
    }

    public function orderedProducts()
    {
        return $this->hasMany(OrderedProduct::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
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
