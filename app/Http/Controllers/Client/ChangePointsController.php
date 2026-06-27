<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChangePoint;
use App\Models\Gift;
use App\Models\User;
use Carbon\Carbon;
use App\Models\UserGift;
use Illuminate\Support\Facades\Auth;

class ChangePointsController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['client_module_active' => 'changePoints']);
            return $next($request);
        });
    }
    function index()
    {
        $listGifts = Gift::all();
        return view('client.pages.minigame', compact('listGifts'));
    }
    function handle(Request $request)
    {
        $request->validate(
            [
                'amount' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống!',
            ],
            [
                'amount' => 'Khối lượng phế thải',
            ]
        );
        if (session('clientUserID')) {
            $amount = intval($request->input('amount'));
            $total = $amount * 150;
            ChangePoint::create([
                'user_id' => Auth::id(),
                'amount' => $request->input('amount'),
            ]);
            return redirect()->route('client.changePoints')->with('status', "Chúc mừng bạn đã đăng kí đổi điểm thành công! Với $amount kg phế liệu bạn sẽ đổi được $total điểm. Hãy mang phế liệu ra TQStore để nhận phần thưởng ngay.");
        } else {
            return redirect()->route('client.changePoints')->with(['status' => "Bạn cần đăng nhập trước khi đăng kí đổi quà!", 'color' => 'alert-danger']);
        }
    }

    function changeGift(Request $request)
    {
        if (Auth::check()) {
            $giftId = $request->input('id');
            $user = Auth::user();
            $pointOld = $user->points;
            $gift = Gift::find($giftId);
            $price = intval($gift->points);
            if ($pointOld > $price) {
                $currentDateTime = Carbon::now();
                $codeGift = 'TQ#' . $currentDateTime->format('dHis');
                $points = $pointOld - $price;
                $thumb = $gift->thumb;
                $user->update([
                    'points' => $points,
                ]);
                $data = array(
                    'thumb' => $thumb,
                    'codeGift' => $codeGift,
                    'pointOld' => $pointOld,
                    'price' => $price,
                    'pointsCurrent' => $points,
                );
                $user->gifts()->attach($gift, ['codeGift' => $codeGift]);
                echo json_encode($data);
            } else {
                toastr()->error('Bạn chưa đủ Points để đổi phần thưởng này!');
                $data = array(
                    'flagError' => true,
                );
                echo json_encode($data);
            }
        } else {
            toastr()->error('Bạn cần đăng nhập trước khi đổi phần thưởng này!');
            $data = array(
                'flagLogin' => false,
            );
            echo json_encode($data);
        }
    }
}
