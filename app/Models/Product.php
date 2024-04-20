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

    protected $fillable = [
        'name',
        'description',
        'reference',
        'purchase_price',
        'selling_price',
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

    protected $casts = [
        'purchase_price' => 'float',
        'selling_price' => 'float',
        'vat_rate' => 'float',
        'is_active' => 'boolean',
    ];

    protected $with = [
        'productSizes',
    ];

    protected $appends = [
        'selling_price_with_vat',
        'product_type_label',
    ];

    public function getSellingPriceWithVatAttribute()
    {
        return $this->selling_price + ($this->selling_price * $this->vat_rate / 100);
    }

    public function getProductTypeLabelAttribute()
    {
        return trans('products.product_types.' . $this->product_type);
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
