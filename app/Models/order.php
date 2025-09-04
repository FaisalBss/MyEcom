<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'total_amount',
        'payment_method',
        'transaction_id',
    ];

    protected $casts = [
        'total'        => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function items(): HasMany { return $this->hasMany(OrderItem::class); }

    public function recalcTotal(): void
    {
        $sum = $this->items()->get()->sum(fn ($i) => $i->price * $i->quantity);
        $col = Schema::hasColumn('orders','total') ? 'total' : 'total_amount';
        $this->{$col} = $sum;
        $this->save();
    }

    public function scopeStatus($q, string $status) { return $q->where('status', $status); }
}
