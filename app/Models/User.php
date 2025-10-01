<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ✅ ثوابت الأدوار
    public const ROLE_USER  = 0;
    public const ROLE_ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 👈 خليها كذا بدون => 'boolean'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'role'              => 'integer', // 👈 نخليها integer بدل boolean
    ];

    // ======================
    // 🔹 Relations
    // ======================

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function shippingAddresses(): HasMany
    {
        return $this->hasMany(ShippingAddress::class);
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(ShippingAddress::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function defaultPaymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class)->where('is_default', true);
    }

    public function supportRequests(): HasMany
    {
        return $this->hasMany(SupportRequest::class);
    }

    // ======================
    // 🔹 Helpers
    // ======================

    public function getIsAdminAttribute(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
}
