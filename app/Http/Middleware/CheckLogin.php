<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = null;

        // 1. Check Authorization Header
        if ($request->hasHeader('Authorization')) {
            $header = $request->header('Authorization');
            if (preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
                $token = $matches[1];
            }
        }

        // 2. Check 'api_token' Cookie if no token in header
        if (!$token) {
            $token = $request->cookie('api_token');
        }

        // 3. If token found, set it in the header for Sanctum to process
        if ($token) {
            $token = is_array($token) ? reset($token) : $token;
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        // Try to authenticate using sanctum guard
        if (!Auth::guard('sanctum')->check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::guard('sanctum')->user();
        if (!$user->isAdmin) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            return redirect()->route('login')->withErrors(['password' => 'Bạn không có quyền truy cập trang quản trị!']);
        }

        Auth::setUser($user);

        return $next($request);
    }
}
