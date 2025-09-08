<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportComment extends Model
{
    use HasFactory;
    protected $fillable = ['support_request_id','admin_id','body'];

    public function supportRequest() {
        return $this->belongsTo(SupportRequest::class);
    }

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
