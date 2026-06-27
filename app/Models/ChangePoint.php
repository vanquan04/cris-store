<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangePoint extends Model
{
    protected $table = 'changepoints';
    protected $fillable = [
        'user_id', 'amount', 'status'
    ];

    public function Users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
