<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'created_at',
        'updated_at',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // protected $appends = ['postcodes_list'];

    // protected $withCount = ['postcodes'];
    // protected $with = ['postcodes'];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }

    public function postcodes()
    {
        return $this->hasMany(Postcode::class, 'sector_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPostcodesListAttribute()
    {
        return $this->postcodes->map(function ($postcode) {
            return "$postcode->postcode - $postcode->city";
        })->toArray();
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('order', function (Builder $builder) {
    //         $builder->orderBy('name', 'asc');
    //     });
    // }
}
