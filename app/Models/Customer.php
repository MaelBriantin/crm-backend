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
        'is_active',
        'sector_id',
        'user_id',
    ];

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
        // return $value ? 'Actif' : 'Inactif';
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
            return 'Hors secteur';
        }
        return $this->sector->name;
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }
}
