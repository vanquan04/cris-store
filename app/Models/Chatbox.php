<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatbox extends Model
{
        protected $fillable = [
        'name', 'slug', 'code', 'status', 'creator'
    ];
}
