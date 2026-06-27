<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'name', 'memory', 'price', 'status', 'creator'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_config')->withPivot('price');
    }
    public function Users()
    {
        return $this->belongsTo('App\Models\User', 'creator');
    }
}
