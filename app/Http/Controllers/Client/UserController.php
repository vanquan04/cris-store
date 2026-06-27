<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function register()
    {
        return view('client.user.register');
    }

    function registerHandle(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'min:4', 'max:50', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'regex:/^(0)[0-9]{9,10}$/'],
                'password' => [
                    'required',
                    'string',
                    'min:6',
                    'confirmed',
                ],
                'password_confirmation' => ['required', 'string', 'min:6']
            ],
            [
                'required' => ':attribute không được để trống!',
                'min' => ':attribute phải có ít nhất :min ký tự!',
                'max' => ':attribute chỉ được tối đa :max ký tự!',
                'confirmed' => 'Mật khẩu xác nhận không đúng!',
                'unique' => ':attribute đã tồn tại!',
                'email.email' => 'Email không hợp lệ!',
                'phone.regex' => 'Số điện thoại phải bắt đầu bằng 0 và có 10-11 số!',
            ],
            [
                'name' => 'Tên người dùng',
                'username' => 'Tài khoản',
                'email' => 'Email',
                'phone' => 'Số điện thoại',
                'password' => 'Mật khẩu',
                'password_confirmation' => 'Xác nhận mật khẩu'
            ]
        );

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'isAdmin' => 0,
        ]);

        return redirect()->route('client.login')->with('status', 'Đăng ký tài khoản thành công! Hãy đăng nhập ngay.');
    }

    function login()
    {
        if (Auth::guard('sanctum')->check()) {
            return redirect()->route('home');
        }
        return view('client.user.login');
    }

    function loginHandle(Request $request)
    {
        $credentials = $request->validate(
            [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ],
            [
                'required' => ':attribute không được để trống!',
            ],
            [
                'username' => 'Tên người dùng',
                'password' => 'Mật khẩu'
            ]
        );

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('user-token')->plainTextToken;

            if ($request->expectsJson()) {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user
                ]);
            }

            return redirect()->intended(route('home'))->cookie('api_token', $token, 1440);
        }

        return redirect()->back()->withErrors([
            'password' => 'Tài khoản hoặc mật khẩu không chính xác!'
        ])->withInput($request->only('username'));
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
        return redirect()->route('home')->withoutCookie('api_token');
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('client.login');
        }

        $user = Auth::user();
        return view('client.user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('client.login');
        }

        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'regex:/^(0)[0-9]{9,10}$/'],
            'address' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Tên không được để trống!',
            'email.required' => 'Email không được để trống!',
            'email.email' => 'Email không hợp lệ!',
            'email.unique' => 'Email đã được sử dụng!',
            'phone.regex' => 'Số điện thoại không hợp lệ!',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('status_profile', 'Cập nhật thông tin thành công!');
    }

    public function updatePassword(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('client.login');
        }

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed', 'different:current_password'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại!',
            'password.required' => 'Mật khẩu mới không được để trống!',
            'password.min' => 'Mật khẩu mới phải có ít nhất :min ký tự!',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp!',
            'password.different' => 'Mật khẩu mới phải khác mật khẩu hiện tại!',
            'password_confirmation.required' => 'Vui lòng nhập xác nhận mật khẩu!',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'Mật khẩu hiện tại không chính xác!'
            ])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('status_password', 'Đổi mật khẩu thành công!');
    }
}
