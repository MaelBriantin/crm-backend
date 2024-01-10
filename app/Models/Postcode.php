<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'postcode',
        'sector_id',
        'created_at',
        'updated_at',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function sector() {
        return $this->belongsTo(Sector::class);
    }
}
