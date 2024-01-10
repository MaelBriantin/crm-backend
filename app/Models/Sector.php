<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // protected $withCount = ['postcodes'];
    // protected $with = ['postcodes'];

    public function postcodes()
    {
        return $this->hasMany(Postcode::class, 'sector_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
