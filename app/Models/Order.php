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

    protected $appends = [
        'is_paid',
    ];

    public function getIsPaidAttribute()
    {
        return $this->paid_at !== null;
    }

    public function getOrderDateAttribute(): string
    {
        return Carbon::parse($this->attributes['order_date'])->isoFormat('L');
    }

    public function getPaidAtAttribute(): ?string
    {
        if ($this->attributes['paid_at'] === null) {
            return null;
        }
        return Carbon::parse($this->attributes['paid_at'])->isoFormat('L');
    }

    public function getDeferredDateAttribute(): ?string
    {
        if ($this->attributes['deferred_date'] === null) {
            return null;
        }
        return Carbon::parse($this->attributes['deferred_date'])->isoFormat('L');
    }

    public function getPaymentMethodLabelAttribute()
    {
        return trans('orders.payment_methods.' . $this->payment_method);
    }

    public function getPaymentStatusLabelAttribute()
    {
        return trans('orders.payment_status.' . $this->payment_status);
    }

    public function getPaymentStatusAttribute()
    {
        $today = now()->format('Y-m-d');
        $deferredDate = $this->attributes['deferred_date'];
        if (!$this->is_paid) {
            if ($this->deferred_date !== null && $deferredDate> $today) {
                return 'pending';
            }
            return 'unpaid';
        }
        return 'paid';
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

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}
