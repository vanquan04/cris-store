<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color_id',
        'config_id',
        'price',
        'stock',
        'discount',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\\Product');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\\Color');
    }

    public function config()
    {
        return $this->belongsTo('App\Models\\Config');
    }
}
