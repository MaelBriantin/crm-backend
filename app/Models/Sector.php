<?php

namespace App\Models;

use App\Scopes\UserScope;
use App\Traits\FormatNumberTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use HasFactory;
    use SoftDeletes;
    use FormatNumberTrait;

    protected $fillable = [
        'name',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
    ];

    public function postcodes()
    {
        return $this->hasMany(Postcode::class, 'sector_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Customer::class);
    }

    public function getPostcodesListAttribute()
    {
        return $this->postcodes->map(function ($postcode) {
            return $postcode->city_label;
        })->toArray();
    }

    public function getAverageAmountAttribute()
    {
        if ($this->orders->isNotEmpty()) {
            $totalAmount = $this->orders->sum('vat_total');
            $orderCount = $this->orders->count();
            return $orderCount > 0
                ? $this->format_number($totalAmount / $orderCount)
                : null;
        }
        return null;
    }

    public function scopeByUser($query)
    {
        return $query->where('orders.user_id', auth()->id());
    }

    /* protected static function booted() */
    /* { */
    /* static::addGlobalScope(new UserScope); */
    /* } */
}
