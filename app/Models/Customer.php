<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
        'notes',
        'sector_id',
        'user_id',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullnameAttribute()
    {
        return "$this->firstname $this->lastname";
    }
    
    public function getFullAddressAttribute()
    {
        return "$this->address, $this->postcode $this->city";
    }
    
    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }
}
