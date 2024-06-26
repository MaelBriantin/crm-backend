<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSize extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'product_id',
        'size',
        'stock',
        'created_at',
        'updated_at',
    ];

    public function orderedProducts()
    {
        return $this->hasMany(OrderedProduct::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
