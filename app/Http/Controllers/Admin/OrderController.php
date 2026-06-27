<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ChangePoint;
use App\Models\User;
use App\Models\UserGift;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderStatusUpdated;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }

public function index(Request $request)
{
    $query = Order::orderBy('id', 'desc');

    // 👉 Nếu có keyword thì mới search
    if ($request->filled('q')) {
        $q = trim($request->q);
        $query->where(function ($sub) use ($q) {
            $sub->where('code_bill', 'like', "%{$q}%")
                ->orWhere('fullname', 'like', "%{$q}%")
                ->orWhere('phone', 'like', "%{$q}%");
        });
    }

    // 👉 Lọc theo khoảng thời gian
    if ($request->filled('date_from')) {
        $dateFrom = \Carbon\Carbon::parse($request->date_from)->startOfDay();
        $query->where('created_at', '>=', $dateFrom);
    }
    if ($request->filled('date_to')) {
        $dateTo = \Carbon\Carbon::parse($request->date_to)->endOfDay();
        $query->where('created_at', '<=', $dateTo);
    }

    $orders = $query->paginate(10)->appends($request->query());

    // ====== KPI ======
    $orderConfirm = Order::where('progress', 0)->count();
    $orderSuccess = Order::where('progress', 2)->count();
    $orderCancel  = Order::where('progress', 3)->count();

    // chỉ tính doanh thu đơn thành công
    $total = Order::where('progress', 2)->sum('total');

    // ====== BAR CHART: số đơn theo 7 ngày gần nhất ======
    $start = Carbon::now()->subDays(6)->startOfDay();
    $end   = Carbon::now()->endOfDay();

    $rows = Order::selectRaw('DATE(created_at) as d, COUNT(*) as c')
        ->whereBetween('created_at', [$start, $end])
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('d', 'asc')
        ->get()
        ->keyBy('d');

    $barLabels = [];
    $barData   = [];

    for ($i = 6; $i >= 0; $i--) {
        $day = Carbon::now()->subDays($i)->toDateString(); // YYYY-MM-DD
        $barLabels[] = Carbon::parse($day)->format('d/m');
        $barData[]   = (int) ($rows[$day]->c ?? 0);
    }

    // ====== DOUGHNUT CHART: thống kê trạng thái ======
    $statusLabels = ['Thành công', 'Đang giao', 'Đã xác nhận', 'Chờ xác nhận', 'Đã hủy'];
    $statusData = [
        Order::where('progress', 2)->count(),
        Order::where('progress', 1)->count(),
        Order::where('progress', 4)->count(),
        Order::where('progress', 0)->count(),
        Order::where('progress', 3)->count(),
    ];

    return view('admin.order.list', compact(
        'orders',
        'orderSuccess',
        'orderCancel',
        'orderConfirm',
        'total',
        'barLabels',
        'barData',
        'statusLabels',
        'statusData'
    ));
}


    function detail(Order $order)
    {
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
        $previousProgress = $order->progress;
        $nextProgress = (int) $request->progress;

        if ($nextProgress === 2 && $previousProgress !== 2) {
            $items = json_decode($order->product, true) ?? [];
            foreach ($items as $item) {
                if (!isset($item['id'], $item['qty'])) {
                    continue;
                }
                $product = Product::find($item['id']);
                if (!$product) {
                    continue;
                }
                $product->increment('purchases');
                $product->decrement('amount', (int) $item['qty']);
            }
        }

        $order->update([
            'progress' => $nextProgress
        ]);

        if ($nextProgress !== $previousProgress && !empty($order->email)) {
            $statusLabels = [
                0 => 'Chờ xác nhận',
                1 => 'Đang giao hàng',
                2 => 'Giao hàng thành công',
                3 => 'Đã hủy',
                4 => 'Đã xác nhận'
            ];
            
            $statusText = $statusLabels[$nextProgress] ?? 'Đang xử lý';
        
            $mailProducts = [];
            $items = json_decode($order->product, true) ?? [];
            foreach ($items as $item) {
                // Determine price (handle both int and string cases safely)
                $price = 0;
                if (isset($item['price'])) {
                    if (is_numeric($item['price'])) {
                        $price = (int) $item['price'];
                    } else {
                        $normalized = preg_replace('/[^0-9]/', '', $item['price']);
                        $price = (int) $normalized;
                    }
                }
                $qty = (int) ($item['qty'] ?? 0);

                $mailProducts[] = [
                    'name' => $item['name'] ?? '',
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $price * $qty,
                    'size' => $item['options']['option'] ?? '',
                    'field_type' => $item['options']['field_type'] ?? ''
                ];
            }
        
            $dataSendMail = [
                'code_bill' => $order->code_bill,
                'fullname'  => $order->fullname,
                'address'   => $order->address,
                'phone'     => $order->phone,
                'time'      => Carbon::now()->format('d/m/Y | H:i'),
                'email'     => $order->email,
                'products'  => $mailProducts,
                'total'     => $order->total,
                'status'    => $statusText
            ];
        
            try {
                Mail::to($order->email)->send(new OrderStatusUpdated($dataSendMail));
            } catch (\Throwable $e) {
                Log::warning('Order update mail send failed: ' . $e->getMessage());
            }
        }

        toastr()->success("Cập nhật hóa đơn thành công!");
        return redirect()->route('admin.order.show');
    }

    function delete(Order $order)
    {
        $order->delete();
        toastr()->success('Đã xóa hóa đơn!');
        return redirect()->route('admin.order.show');
    }

    public function report(Request $request)
    {
        $start = \Carbon\Carbon::now()->subDays(6)->startOfDay();
        $end   = \Carbon\Carbon::now()->endOfDay();

        if ($request->filled('date_from')) {
            $start = \Carbon\Carbon::parse($request->date_from)->startOfDay();
        }
        if ($request->filled('date_to')) {
            $end = \Carbon\Carbon::parse($request->date_to)->endOfDay();
        }

        // --- QUERY BASE ---
        $baseQuery = function($progress = null) use ($start, $end) {
            $q = Order::whereBetween('created_at', [$start, $end]);
            if ($progress !== null) {
                $q->where('progress', $progress);
            }
            return $q;
        };

        $orderConfirm = $baseQuery(0)->count();
        $orderSuccess = $baseQuery(2)->count();
        $orderCancel  = $baseQuery(3)->count();
        $total = $baseQuery(2)->sum('total');

        $rows = Order::selectRaw('DATE(created_at) as d, COUNT(*) as c, SUM(CASE WHEN progress = 2 THEN total ELSE 0 END) as revenue')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy('d', 'asc')
            ->get()
            ->keyBy('d');

        $barLabels = [];
        $barData   = [];
        $revenueData = [];

        // Tránh loop quá nhiều ngày làm lag biểu đồ (tối đa hiển thị 90 ngày trên biểu đồ nếu chọn quá dài)
        $diffDays = $start->diffInDays($end);
        $chartStart = clone $start;
        if ($diffDays > 90) {
            $chartStart = (clone $end)->subDays(90);
        }

        $current = clone $chartStart;
        while ($current <= $end) {
            $day = $current->toDateString();
            $barLabels[] = $current->format('d/m/Y');
            $barData[]   = (int) ($rows[$day]->c ?? 0);
            $revenueData[] = (int) ($rows[$day]->revenue ?? 0);
            $current->addDay();
        }

        $statusLabels = ['Thành công', 'Đang giao', 'Đã xác nhận', 'Chờ xác nhận', 'Đã hủy'];
        $statusData = [
            $baseQuery(2)->count(),
            $baseQuery(1)->count(),
            $baseQuery(4)->count(),
            $baseQuery(0)->count(),
            $baseQuery(3)->count(),
        ];

        return view('admin.order.report', compact(
            'orderSuccess',
            'orderCancel',
            'orderConfirm',
            'total',
            'barLabels',
            'barData',
            'revenueData',
            'statusLabels',
            'statusData'
        ));
    }

    function changePoints()
    {
        $listChange = ChangePoint::orderBy('id', 'desc')->get();
        return view('admin.order.changePoints', compact('listChange'));
    }

    function changePoints_delete(ChangePoint $changePoint)
    {
        $changePoint->delete();
        toastr()->success('Đã xóa yêu cầu!');
        return redirect()->route('admin.order.changePoints');
    }

    function changePoints_checkSuccess(ChangePoint $changePoint)
    {
        // return $changePoint;
        if (!$changePoint->status) {
            $amount = intval($changePoint->amount);
            $total = $amount * 150;
            $user =  User::find($changePoint->user_id);
            $pointsCurrent = $user->points + $total;
            // return $pointsCurrent;
            $changePoint->update([
                'status' => 1,
            ]);
            $user->update([
                'points' => $pointsCurrent,
            ]);
            toastr()->success('Đã xác minh yêu cầu!');
            return redirect()->route('admin.order.changePoints');
        } else {
            toastr()->info('Yêu cầu đã được xác minh! Không thể xác minh lần 2!');
            return redirect()->route('admin.order.changePoints');
        };
    }

    function changeGifts()
    {
        $listChangeGift = UserGift::orderBy('id', 'desc')->with(['users', 'gifts'])->get();
        // return $listChangeGift;
        return view('admin.order.changeGifts', compact('listChangeGift'));
    }

    function changeGifts_delete(UserGift $userGift)
    {
        $userGift->delete();
        toastr()->success('Đã xóa yêu cầu!');
        return redirect()->route('admin.order.changeGifts');
    }

    function changeGifts_checkSuccess(UserGift $userGift)
    {
        // return $changePoint;
        if (!$userGift->status) {
            $userGift->update([
                'status' => true,
            ]);
            toastr()->success('Đã xác minh yêu cầu!');
            return redirect()->route('admin.order.changeGifts');
        } else {
            toastr()->info('Yêu cầu đã được xác minh! Không thể xác minh lần 2!');
            return redirect()->route('admin.order.changeGifts');
        };
    }

    public function export(Request $request)
    {
        $q = trim($request->get('q', ''));
        $dateFrom = trim($request->get('date_from', ''));
        $dateTo = trim($request->get('date_to', ''));

        return Excel::download(new OrdersExport($q, $dateFrom, $dateTo), 'orders_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
