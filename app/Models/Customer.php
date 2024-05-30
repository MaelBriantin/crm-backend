<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = ['full_name', 'full_address'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }


//    protected $with = ['sector', 'relationship', 'visitFrequency'];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function getIsActiveAttribute($value)
    {
        return boolval($value);
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
        return "$this->address - $this->postcode $this->city";
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class);
    }

    public function visitFrequency()
    {
        return $this->belongsTo(VisitFrequency::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }
}
