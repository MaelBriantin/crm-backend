<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitFrequency extends Model
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

    public function getLabelAttribute($value)
    {
        return trans("visit_frequencies.label.{$this->value}");
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
