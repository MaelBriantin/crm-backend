<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
    ];

//    protected $appends = [
//       'city_label',
//    ];

    public function sector() {
        return $this->belongsTo(Sector::class);
    }

    public function getCityLabelAttribute()
    {
        return "$this->postcode - $this->city";
    }
}
