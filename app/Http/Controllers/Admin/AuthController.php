<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function handle(Request $request)
    {
        $credentials = $request->validate(
            [
                'username' => ['required', 'string', 'min:6'],
                'password' => ['required', 'string', 'min:6'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'min'      => ':attribute có độ dài ít nhất :min ký tự!',
            ],
            [
                'username' => 'Tên người dùng',
                'password' => 'Mật khẩu',
            ]
        );

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user->isAdmin) {
                Auth::logout();
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Bạn không có quyền truy cập!'], 403);
                }
                return redirect()->back()->withErrors([
                    'password' => 'Bạn không có quyền truy cập!'
                ]);
            }

            $token = $user->createToken('admin-token')->plainTextToken;

            if ($request->expectsJson()) {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user
                ]);
            }

            return redirect()->route('admin.order.show')->cookie('api_token', $token, 1440); // 24 hours
        }

        return redirect()->back()->withErrors([
            'password' => 'Tài khoản hoặc mật khẩu không chính xác!'
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('sanctum')->check()) {
            $token = $request->user()->currentAccessToken();
            if ($token && method_exists($token, 'delete')) {
                $token->delete();
            }
        }
        
        Auth::logout();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out']);
        }

        return redirect()->route('login')->withoutCookie('api_token');
    }
}