<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id','total','status','payment_method','transaction_id'
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function recalcTotal(): void
    {
        $sum = $this->items()->get()->sum(fn ($i) => $i->price * $i->quantity);
        $this->total = $sum;
        $this->save();
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
