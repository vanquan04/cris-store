<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionSubscriber extends Model
{
    protected $table = 'promotion_subscribers';
    protected $fillable = [
        'name', 'email', 'phone', 'request_type', 'support_content', 'status', 'user_id', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
