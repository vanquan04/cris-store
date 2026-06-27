<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;

    protected $table = 'feedback';
    protected $fillable = [
        'user_id', 'star', 'content'
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
