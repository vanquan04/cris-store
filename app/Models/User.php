<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'isAdmin', 'points', 'phone', 'address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function group()
    {
        return $this->belongsTo('App\Models\CustomerGroup', 'group_id');
    }

    function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role');
    }

    function gifts()
    {
        return $this->belongsToMany('App\Models\Gift', 'user_gift');
    }

    function supportRequests()
    {
        return $this->hasMany('App\Models\PromotionSubscriber', 'user_id');
    }

    function hasPermission($permission)
    {
        if ($this->isAdmin == 1) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role->permissions()->where('slug', $permission)->count() > 0) {
                return true;
            }
        }
        return false;
    }
}
