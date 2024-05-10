<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Scopes\UserScope;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

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

    public function getSectorNameAttribute()
    {
        if (!$this->sector) {
            return trans('sectors.out_of_sector');
        }
        return $this->sector->name;
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class);
    }

    public function visitFrequency()
    {
        return $this->belongsTo(VisitFrequency::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }
}
