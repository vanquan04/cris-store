<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGift extends Model
{
    protected $table = 'user_gift';
    protected $fillable = [
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Xác định mối quan hệ giữa UserGift và Gift
    public function gifts()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }
}
