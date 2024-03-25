<?php

namespace App\Models;

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
        'vat_rate_id',
        'product_type',
        'measure_quantity',
        'measure_unit_id',
        'stock',
        'image',
        'brand_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

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

    public function measureUnit()
    {
        return $this->belongsTo(MeasureUnit::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function vatRate()
    {
        return $this->belongsTo(VatRate::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }
}
