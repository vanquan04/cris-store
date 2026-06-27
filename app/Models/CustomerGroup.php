<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $table = 'customer_groups';
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany('App\Models\User', 'group_id');
    }
}
