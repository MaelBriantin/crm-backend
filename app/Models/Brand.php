<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'sku_code',
        'notes',
        'contact_name',
        'contact_email',
        'contact_phone',
        'address',
        'city',
        'postcode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }
}
