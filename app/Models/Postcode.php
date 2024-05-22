<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'postcode',
        'city',
        'sector_id',
        'created_at',
        'updated_at',
        'user_id',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
    ];

    public function sector() {
        return $this->belongsTo(Sector::class);
    }
}
