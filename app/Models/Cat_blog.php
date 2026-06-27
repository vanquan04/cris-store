<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat_blog extends Model
{
    protected $fillable = [
        'name', 'slug', 'parent_id', 'creator', 'status'
    ];

    public function blog()
    {
        return $this->hasMany('App\Models\blog', '');
    }
}
