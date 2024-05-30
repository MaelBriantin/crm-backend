<?php

namespace App\Models;

use App\Enums\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderedProduct extends Model
{
    protected $guarded = [];

    protected $with = ['product', 'productSize'];

    protected $appends = ['vat_total_price', 'no_vat_total_price'];

    public function getVatTotalPriceAttribute()
    {
        return $this->ordered_quantity * $this->vat_price;
    }

    public function getNoVatTotalPriceAttribute()
    {
        return $this->ordered_quantity * $this->no_vat_price;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
