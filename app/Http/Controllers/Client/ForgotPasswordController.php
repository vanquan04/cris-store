<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Jobs\SendRawEmailJob;

class ForgotPasswordController extends Controller
{
    function showForm()
    {
        return view('client.user.forgot-password');
    }

    function submit(Request $request)
    {
        $request->validate([
            'email_or_phone' => ['required', 'string'],
        ], [
            'email_or_phone.required' => 'Email hoặc số điện thoại không được để trống!',
        ]);

        $user = User::where('email', $request->email_or_phone)
            ->orWhere('phone', $request->email_or_phone)
            ->first();

        if (!$user) {
            return redirect()->back()->withInput()->withErrors([
                'email_or_phone' => 'Email hoặc Số điện thoại không tồn tại trên hệ thống!'
            ]);
        }

        // Generate new password
        $newPassword = Str::random(8);
        $user->password = bcrypt($newPassword);
        $user->save();

        if ($user->email) {
            $content = "Xin chào {$user->name},\n\nMật khẩu mới của bạn là: {$newPassword}\n\nVui lòng đăng nhập và đổi mật khẩu ngay.\n\nTrân trọng,\nCRIS Store";
            SendRawEmailJob::dispatch($content, $user->email, $user->name, 'Mật khẩu mới từ CRIS Store');
        }

        return redirect()->route('client.login')->with([
            'status' => 'Mật khẩu mới đã được gửi qua email! Vui lòng kiểm tra hộp thư.'
        ]);
    }
}
