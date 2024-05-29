<?php

namespace App\Models;

use App\Scopes\UserScope;
use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    public function casts(): array
    {
        return [
            'is_paid' => 'boolean',
        ];
    }

    protected array $cacheableAttributes = [
        'order_date',
        'deferred_date',
        'customer_full_name',
        'customer_sector_name',
        'payment_status_label',
    ];

    public function __get($key)
    {
        if (in_array($key, $this->cacheableAttributes)) {
            $cacheKey = 'order_' . $this->id . '_' . $key;
            return Cache::remember($cacheKey, $this->cacheLifetime, function () use ($key) {
                return $this->getAttributeValue($key);
            });
        }
        return parent::__get($key);
    }

    public function getOrderDateAttribute(): string
    {
        return Carbon::parse($this->attributes['order_date'])->isoFormat('L');
    }

    public function getDeferredDateAttribute(): ?string
    {
        if ($this->attributes['deferred_date'] === null) {
            return null;
        }
        return Carbon::parse($this->attributes['deferred_date'])->isoFormat('L');
    }

    public function getCustomerFullNameAttribute(): string
    {
        return $this->customer->full_name;
    }

    public function getCustomerSectorNameAttribute(): string
    {
        return $this->customer->sector_name;
    }

    public function getPaymentStatusLabelAttribute()
    {
        return trans('orders.payment_status.' . $this->payment_status);
    }

    public function getPaymentStatusAttribute()
    {
        if (!$this->is_paid
            && $this->deferred_date > now())
        {
            return 'not_paid';
        }

        if (!$this->is_paid && !($this->deferred_date > now())) {
            return 'pending';
        }

        return $this->is_paid ? 'paid' : 'not_paid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderedProducts(): HasMany
    {
        return $this->hasMany(OrderedProduct::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}
