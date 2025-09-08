<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','message','image_path','status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments() {
    return $this->hasMany(\App\Models\SupportComment::class)->latest();
}
}
