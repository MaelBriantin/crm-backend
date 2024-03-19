<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'label',
    ];

    protected $visible = [
        'id',
        'value',
        'label',
    ];

    public function getLabelAttribute()
    {
        return trans("relationships.label.$this->value");
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    
}
