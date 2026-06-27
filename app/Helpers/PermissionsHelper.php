<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    public static function hasPermission($permissions)
    {
        $user = Auth::user();
        if (!$user) return false;

        foreach ($user->roles as $role) {
            foreach ($permissions as $permission) {
                if ($role->permissions()->where('slug', $permission)->count() > 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
