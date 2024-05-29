<?php

namespace App\Models;

use App\Enums\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderedProduct extends Model
{
    protected $guarded = [];

    protected $with = ['orderedProduct'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderedProduct()
    {
        return $this->morphTo(type: 'product_type');
    }

}
