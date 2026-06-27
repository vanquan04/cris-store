<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['client_module_active' => 'feedback']);
            return $next($request);
        });
    }
    function index()
    {
        $banners = Banner::orderBy('sort', 'asc')->get();
        $bestseller = Product::orderBy('purchases', 'desc')->take(4)->get();
        $feedbacks = Feedback::orderBy('id', 'desc')->get();
        $averageStar = number_format(Feedback::avg('star'), 1);
        return view('client.pages.feedback', compact('banners', 'bestseller', 'feedbacks', 'averageStar'));
    }
    function add(Request $request)
    {
        if (Auth::check()) {
            $content =  $request->input('content') ? $request->input('content') : 'Không có lời đánh giá.';
            $feedback = Feedback::create([
                'user_id' => Auth::id(),
                'content' => $content,
                'star' =>  $request->input('star'),
            ]);
            $user = Auth::user();
            $data = array(
                'fullname' => $user->name,
                'content' => $content,
                'star' =>  $request->input('star'),
                'created_at' => $feedback->created_at->format('d/m/Y | H:i'),
            );
            echo json_encode($data);
        } else {
            toastr()->error('Bạn cần đăng nhập trước khi thực hiện chức năng này!');
            $data = array(
                'flagLogin' => false,
            );
            echo json_encode($data);
        }
    }
}
