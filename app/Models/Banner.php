<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'link', 'thumb_banner', 'creator', 'sort', 'status'
    ];
    public function Users()
    {
        return $this->belongsTo('App\Models\User', 'creator');
    }
}
