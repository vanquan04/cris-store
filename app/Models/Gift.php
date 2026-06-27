<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'thumb', 'points'
    ];

    function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_gift');
    }
}
