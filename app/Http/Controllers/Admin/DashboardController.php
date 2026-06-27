<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }
    function dashboard(Request $request)
    {
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        $orderConfirm = Order::where('progress', 0)->count();
        $orderSuccess = Order::where('progress', 2)->count();
        $orderCancel = Order::where('progress', 3)->count();
        $total = 0;
        foreach ($orders as $value) {
            if ($value['progress'] == 2) {
                $total += $value['total'];
            }
        };
        return view('admin.dashboard', compact('orders', 'orderSuccess', 'orderCancel', 'orderConfirm', 'total'));
    }

    function detail(Order $order)
    {
        // return $order;
        // return json_decode($order->product, true);
        $method_pay = $order->method_pay == 0 ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán online qua VNPAY';
        $total = number_format($order->total, 0, '', '.') . ' VNĐ';
        $note = $order->note == '' ? 'Không có ghi chú nào!' : $order->note;
        $data = array(
            'id' => $order->id,
            'fullname' => $order->fullname,
            'address' => $order->address,
            'phone' => $order->phone,
            'note' => $note,
            'email' => $order->email,
            'amount' => $order->amount,
            'total' => $total,
            'method_pay' => $method_pay,
            'code_bill' => $order->code_bill,
            'progress' => $order->progress,
            'product' => json_decode($order->product, true),
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        );
        echo json_encode($data);
    }

    function update(Request $request, Order $order)
    {
        $order->update([
            'progress' => $request->progress
        ]);
        toastr()->success("Cập nhật hóa đơn thành công!");
        return redirect()->route('admin.order.show');
    }

    function delete(Order $order)
    {
        $order->delete();
        toastr()->success('Đã xóa hóa đơn!');
        return redirect()->route('admin.order.show');
    }
}
