<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];
    protected static function booted()
    {
        static::deleting(function ($category) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
