<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionSlug)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission($permissionSlug)) {
            abort(401);
        }

        return $next($request);
    }
}
