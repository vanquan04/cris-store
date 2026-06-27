<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'discount_percent', 'start_date', 'end_date', 'creator', 'status'
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Cat_product', 'promotion_category', 'promotion_id', 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'promotion_product', 'promotion_id', 'product_id');
    }
}
