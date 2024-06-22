<?php

namespace App\Models;

use App\Scopes\UserScope;
use App\Traits\FormatNumberTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use FormatNumberTrait;

    protected $guarded = [];

    protected $appends = ['full_name', 'full_address'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    //    protected $with = ['sector', 'relationship', 'visitFrequency'];

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    public function getIsActiveAttribute($value): bool
    {
        return boolval($value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullnameAttribute(): string
    {
        return "$this->firstname $this->lastname";
    }

    public function getFullAddressAttribute(): string
    {
        return "$this->address - $this->postcode $this->city";
    }

    public function getVatAverageOrderAmountAttribute()
    {
        return self::getAverageAmount($this, 'vat_total');
    }

    public function getNoVatAverageOrderAmountAttribute()
    {
        return self::getAverageAmount($this, 'no_vat_total');
    }

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(Relationship::class);
    }

    public function visitFrequency(): BelongsTo
    {
        return $this->belongsTo(VisitFrequency::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

    private function getAverageAmount($value, $column)
    {
        if ($value->orders->isNotEmpty()) {
            $totalAmount = $value->orders->sum($column);
            $orderCount = $value->orders->count();
            return $orderCount > 0
                ? $value->format_number($totalAmount / $orderCount)
                : null;
        }
        return null;
    }
}
