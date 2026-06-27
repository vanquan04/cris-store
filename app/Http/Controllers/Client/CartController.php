<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderSuccess;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Schema;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    function index()
    {
        return view('client.cart.list');
    }

    function add_ajax(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }

        $addResult = $this->addProductToCart($product, $request);
        if (!$addResult['success']) {
            return response()->json([
                'message' => $addResult['message'],
                'cartCount' => Cart::content()->count(),
            ], 422);
        }

        // return Cart::content();

        $data = array(
            'cartCount' => Cart::content()->count(),
            'list_cart' => Cart::content()
        );
        echo json_encode($data);
    }
    function add(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back();
        }

        $addResult = $this->addProductToCart($product, $request);
        if (!$addResult['success']) {
            toastr()->error($addResult['message']);
            return redirect()->back();
        }

        // return Cart::content();

        $data = array(
            'cartCount' => Cart::content()->count(),
            'list_cart' => Cart::content()
        );
        return redirect()->route('client.cart.show');
    }

    function update_ajax(Request $request)
    {
        $rowId = $request->input('rowId');
        $qty = $request->input('qty');

        Cart::update($rowId, $qty);
        $sub_total = Cart::get($rowId)->subtotal();
        $total = Cart::total();
        $data = array(
            'sub_total' => $sub_total . 'đ',
            'total' => $total . 'đ'
        );
        echo json_encode($data);
    }

    function delete($rowId)
    {
        Cart::remove($rowId);
        toastr()->success('Đã xóa sản phẩm khỏi giỏ hàng!');
        return redirect()->route('client.cart.show');
    }

    function destroy()
    {
        Cart::destroy();
        toastr()->success('Đã xóa bỏ toàn bộ giỏ hàng!');
        return redirect()->route('client.cart.show');
    }

    function handleBuyNow(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back();
        }

        $addResult = $this->addProductToCart($product, $request);
        if (!$addResult['success']) {
            toastr()->error($addResult['message']);
            return redirect()->back();
        }

        $fullname = Session::get('fullname', old('fullname', ''));
        $email = Session::get('email', old('email', ''));
        $phone = Session::get('phone', old('phone', ''));

        return view('client.cart.checkout', compact('fullname', 'email', 'phone'));
    }

    protected function addProductToCart(Product $product, Request $request)
    {
        $qty = (int) ($request->input('num-order') ? $request->input('num-order') : 1);
        if ($qty <= 0) {
            $qty = 1;
        }

        $optionId = $request->input('selected_option_id');
        $colorId = $request->input('selected_color_id');
        $price = (float) $product->new_price;
        $optionLabel = null;
        $stock = (int) $product->amount;
        $thumbMain = $product->thumb_main;

        $promo = $product->getActivePromotion();

        if (Schema::hasTable('product_variants') && !empty($optionId) && !empty($colorId)) {
            $variant = $product->variants()
                ->with(['color', 'config'])
                ->where('color_id', $colorId)
                ->where('config_id', $optionId)
                ->first();

            if (!$variant) {
                return [
                    'success' => false,
                    'message' => 'Biến thể màu/size không tồn tại.',
                ];
            }

            $basePrice = (float) $variant->price;
            $discount = (int) $variant->discount;
            if ($promo && $promo->discount_percent > $discount) {
                $discount = $promo->discount_percent;
            }
            
            if ($discount > 0) {
                $price = round($basePrice * (1 - $discount / 100));
            } else {
                $price = $basePrice;
            }
            $stock = (int) $variant->stock;
            $colorName = optional($variant->color)->name;
            $sizeName = optional($variant->config)->memory ?: optional($variant->config)->name;
            $optionLabel = trim(($colorName ? $colorName . ' - ' : '') . $sizeName);

            if (Schema::hasTable('product_images')) {
                $colorMainImage = ProductImage::where('product_id', $product->id)
                    ->where('color_id', $colorId)
                    ->whereNull('config_id')
                    ->orderByDesc('is_main')
                    ->orderBy('display_order')
                    ->value('image_path');
                if (!empty($colorMainImage)) {
                    $thumbMain = $colorMainImage;
                }
            }
        } elseif (!empty($optionId)) {
            $configMatch = $product->configs->find($optionId);
            if ($configMatch && !empty($configMatch->pivot->price)) {
                $basePrice = (float) $configMatch->pivot->price;
                $discount = 0;
                if ($promo && $promo->discount_percent > 0) {
                    $discount = $promo->discount_percent;
                }
                if ($discount > 0) {
                    $price = round($basePrice * (1 - $discount / 100));
                } else {
                    $price = $basePrice;
                }
                $optionLabel = $configMatch->memory ?: $configMatch->name;
            }
        }

        if ($stock <= 0) {
            return [
                'success' => false,
                'message' => 'Biến thể đã hết hàng.',
            ];
        }

        if ($qty > $stock) {
            return [
                'success' => false,
                'message' => 'Số lượng vượt quá tồn kho biến thể.',
            ];
        }

        $options = [
            'thumb_main' => $thumbMain,
            'slug' => $product->slug,
            'code' => $product->code,
            'color_id' => $colorId,
            'config_id' => $optionId,
            'field_type' => $product->field_type,
        ];

        if (!empty($optionLabel)) {
            $options['option'] = $optionLabel;
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $price,
            'options' => $options,
        ]);

        return [
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng.',
        ];
    }
    function checkout(Request $request)
    {
        $fullname = Session::get('fullname', old('fullname', ''));
        $email = Session::get('email', old('email', ''));
        $phone = Session::get('phone', old('phone', ''));

        return view('client.cart.checkout', compact('fullname', 'email', 'phone'));
    }

    function checkoutHandle(Request $request)
    {
        $request->validate(
            [
                'fullname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'city' => ['required'],
                'district' => ['required'],
                'ward' => ['required'],
                'phone' => ['required', 'numeric'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'email' => 'Đây phải là một email!',
                'phone' => 'Hãy nhập vào là số điện thoại!'
            ],
            [
                'fullname' => 'Họ tên',
                'email' => 'Email',
                'address' => 'Địa chỉ',
                'phone' => 'Số điện thoại',
                'city' => 'Tỉnh,thành phố',
                'district' => 'Quận,huyện',
                'ward' => 'Phường,xã',
            ]
        );

        foreach (Cart::content() as $cartItem) {
            $product = Product::find($cartItem->id);
            if (!$product) {
                toastr()->error('Có sản phẩm không tồn tại trong giỏ hàng.');
                return redirect()->back();
            }

            $colorId = optional($cartItem->options)->color_id;
            $configId = optional($cartItem->options)->config_id;
            $qty = (int) $cartItem->qty;

            if (Schema::hasTable('product_variants') && !empty($colorId) && !empty($configId)) {
                $variant = ProductVariant::where('product_id', $product->id)
                    ->where('color_id', $colorId)
                    ->where('config_id', $configId)
                    ->first();

                if (!$variant || (int) $variant->stock < $qty) {
                    toastr()->error('Biến thể ' . $cartItem->name . ' không đủ tồn kho.');
                    return redirect()->route('client.cart.show');
                }
            } else {
                if ((int) $product->amount < $qty) {
                    toastr()->error('Sản phẩm ' . $cartItem->name . ' không đủ tồn kho.');
                    return redirect()->route('client.cart.show');
                }
            }
        }

        $currentDateTime = Carbon::now();
        $code_bill = 'bill-' . $currentDateTime->format('dHis');
        $cart_json = Cart::content();
        $total_cart = $this->calculateCartTotal();
        $cart_qty = Cart::count();
        $house_number = $request->input('house_number') ? " - " . $request->input('house_number') : "";
        $address = $request->get('ward_label') . ' - ' . $request->get('district_label') . ' - ' . $request->get('city_label') . $house_number;
        $data = array(
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'address' => $address,
            'phone' => $request->input('phone'),
            'method_pay' => $request->input('payment-method'),
            'note' => $request->input('note'),
            'product' => $cart_json,
            'code_bill' => $code_bill,
            'total' => $total_cart,
            'amount' => $cart_qty,
            'user_id' => Auth::id()
        );
        // Build product list for mail — collected before cart is destroyed
        $mailProducts = [];
        foreach (Cart::content() as $cartItem) {
            $colorLabel = '';
            $sizeLabel  = '';
            if (!empty($cartItem->options->color_id)) {
                $colorModel = \App\Models\Color::find($cartItem->options->color_id);
                if ($colorModel) {
                    $colorLabel = $colorModel->name;
                }
            }
            if (!empty($cartItem->options->option)) {
                $sizeLabel = $cartItem->options->option;
            }
            $mailProducts[] = [
                'name'     => $cartItem->name,
                'qty'      => $cartItem->qty,
                'price'    => $this->toMoneyInt($cartItem->price),
                'subtotal' => $this->toMoneyInt($cartItem->price) * (int) $cartItem->qty,
                'color'    => $colorLabel,
                'size'     => $sizeLabel,
                'thumb'    => optional($cartItem->options)->thumb_main ?? '',
                'field_type' => optional($cartItem->options)->field_type ?? '',
            ];
        }

        $dataSendMail = [
            'code_bill' => $code_bill,
            'fullname'  => $request->input('fullname'),
            'address'   => $address,
            'phone'     => $request->input('phone'),
            'time'      => $currentDateTime->format('d/m/Y | H:i'),
            'email'     => $request->input('email'),
            'products'  => $mailProducts,
            'total'     => $total_cart,
        ];

        if ($request->input('payment-method') == 0) {
            Order::create($data);
            $this->sendCheckoutMail($request->input('email'), $code_bill, $dataSendMail);
            $this->decreaseStockFromCurrentCart();
            Cart::destroy();
            Session::forget('vnp_pending_order');

            Session::put('fullname', $request->input('fullname'), 60 * 24 * 7);
            Session::put('email', $request->input('email'), 60 * 24 * 7);
            Session::put('phone', $request->input('phone'), 60 * 24 * 7);

            return redirect()->route('client.cart.success', $code_bill);
        } else {
            Session::put('vnp_pending_order', [
                'order_data' => $data,
                'mail_data' => $dataSendMail,
                'code_bill' => $code_bill,
            ]);

            $paymentUrl = $this->buildVnpayUrl($request, $code_bill, $total_cart);
            if (!$paymentUrl) {
                toastr()->error('Thiếu cấu hình VNPAY, vui lòng kiểm tra lại file .env.');
                return redirect()->route('client.cart.checkout');
            }

            return redirect()->away($paymentUrl);
        }
    }

    public function vnpayReturn(Request $request)
    {
        Log::info('VNPAY return payload', [
            'query' => $request->all(),
            'session_has_pending_order' => Session::has('vnp_pending_order'),
        ]);

        $pendingOrder = Session::get('vnp_pending_order');
        if (empty($pendingOrder)) {
            toastr()->error('Phiên thanh toán đã hết hạn. Vui lòng đặt hàng lại.');
            return redirect()->route('client.cart.checkout');
        }

        $vnpData = $request->all();
        $secureHash = $vnpData['vnp_SecureHash'] ?? '';
        $hashSecret = env('VNP_HASH_SECRET', '');

        if (empty($secureHash) || empty($hashSecret)) {
            toastr()->error('Không thể xác thực giao dịch VNPAY.');
            return redirect()->route('client.cart.checkout');
        }

        unset($vnpData['vnp_SecureHash'], $vnpData['vnp_SecureHashType']);
        $hashData = $this->buildVnpHashData($vnpData);
        $calculatedHash = hash_hmac('sha512', $hashData, $hashSecret);

        if (!hash_equals($calculatedHash, $secureHash)) {
            toastr()->error('Chữ ký thanh toán không hợp lệ.');
            return redirect()->route('client.cart.checkout');
        }

        $txnRef = $request->get('vnp_TxnRef');
        if ($txnRef !== ($pendingOrder['code_bill'] ?? null)) {
            toastr()->error('Mã giao dịch không khớp với đơn hàng đang xử lý.');
            return redirect()->route('client.cart.checkout');
        }

        $responseCode = $request->get('vnp_ResponseCode');
        $transactionStatus = $request->get('vnp_TransactionStatus');

        if ($responseCode !== '00' || $transactionStatus !== '00') {
            Log::warning('VNPAY payment not successful', [
                'vnp_ResponseCode' => $responseCode,
                'vnp_TransactionStatus' => $transactionStatus,
                'vnp_TxnRef' => $request->get('vnp_TxnRef'),
            ]);
            Session::forget('vnp_pending_order');
            toastr()->error('Thanh toán không thành công hoặc đã bị hủy.');
            return redirect()->route('client.cart.checkout');
        }

        $orderData = $pendingOrder['order_data'] ?? null;
        if (empty($orderData)) {
            toastr()->error('Không tìm thấy dữ liệu đơn hàng chờ thanh toán.');
            return redirect()->route('client.cart.checkout');
        }

        $order = Order::create($orderData);
        $mailData = $pendingOrder['mail_data'] ?? [];
        $this->sendCheckoutMail($order->email, $order->code_bill, $mailData);
        $this->decreaseStockFromCurrentCart();

        Session::put('fullname', $order->fullname, 60 * 24 * 7);
        Session::put('email', $order->email, 60 * 24 * 7);
        Session::put('phone', $order->phone, 60 * 24 * 7);

        Session::forget('vnp_pending_order');
        Cart::destroy();

        return redirect()->route('client.cart.success', $order->code_bill);
    }

    private function sendCheckoutMail($email, $codeBill, array $dataSendMail)
    {
        try {
            Mail::to($email)->send(new OrderSuccess($dataSendMail));
        } catch (\Throwable $e) {
            // Do not block checkout when mail server credentials/config are invalid.
            Log::warning('Checkout mail send failed', [
                'code_bill' => $codeBill,
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function calculateCartTotal()
    {
        $total = 0;
        foreach (Cart::content() as $cartItem) {
            $price = $this->toMoneyInt($cartItem->price);
            $total += $price * (int) $cartItem->qty;
        }

        return $total;
    }

    private function toMoneyInt($value)
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_float($value)) {
            return (int) round($value);
        }

        $raw = trim((string) $value);
        if ($raw === '') {
            return 0;
        }

        // Keep only digits and decimal separators to parse both 1,234,567.00 and 1.234.567,00.
        $normalized = preg_replace('/[^0-9,\.]/', '', $raw);
        if ($normalized === '') {
            return 0;
        }

        $lastComma = strrpos($normalized, ',');
        $lastDot = strrpos($normalized, '.');

        if ($lastComma !== false && $lastDot !== false) {
            if ($lastComma > $lastDot) {
                $normalized = str_replace('.', '', $normalized);
                $normalized = str_replace(',', '.', $normalized);
            } else {
                $normalized = str_replace(',', '', $normalized);
            }
        } elseif ($lastComma !== false) {
            $normalized = str_replace('.', '', $normalized);
            $normalized = str_replace(',', '.', $normalized);
        } else {
            $normalized = str_replace(',', '', $normalized);
        }

        return (int) round((float) $normalized);
    }

    private function decreaseStockFromCurrentCart()
    {
        foreach (Cart::content() as $cartItem) {
            $product = Product::find($cartItem->id);
            if (!$product) {
                continue;
            }

            $qty = (int) $cartItem->qty;
            $colorId = optional($cartItem->options)->color_id;
            $configId = optional($cartItem->options)->config_id;

            if (Schema::hasTable('product_variants') && !empty($colorId) && !empty($configId)) {
                $variant = ProductVariant::where('product_id', $product->id)
                    ->where('color_id', $colorId)
                    ->where('config_id', $configId)
                    ->first();

                if ($variant) {
                    $variant->stock = max(0, (int) $variant->stock - $qty);
                    $variant->save();
                }
            }

            if (Schema::hasTable('product_variants')) {
                $product->amount = max(0, (int) $product->variants()->sum('stock'));
            }
            $product->save();
        }
    }

    private function buildVnpayUrl(Request $request, $codeBill, $totalCart)
    {
        $vnpUrl = env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $vnpReturnurl = route('client.cart.vnpayReturn');
        $vnpTmnCode = env('VNP_TMN_CODE');
        $vnpHashSecret = env('VNP_HASH_SECRET');
        $ipAddress = $this->resolveVnpIpAddress($request);

        if (empty($vnpUrl) || empty($vnpTmnCode) || empty($vnpHashSecret)) {
            return null;
        }

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnpTmnCode,
            'vnp_Amount' => $totalCart * 100,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_ExpireDate' => date('YmdHis', strtotime('+15 minutes')),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $ipAddress,
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Thanh toan don hang ' . $codeBill,
            'vnp_OrderType' => 'billpayment',
            'vnp_ReturnUrl' => $vnpReturnurl,
            'vnp_TxnRef' => $codeBill,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $this->buildVnpHashData($inputData), $vnpHashSecret);

        Log::info('VNPAY create payment url', [
            'vnp_TxnRef' => $codeBill,
            'vnp_Amount' => $inputData['vnp_Amount'],
            'vnp_IpAddr' => $inputData['vnp_IpAddr'],
            'vnp_ReturnUrl' => $vnpReturnurl,
        ]);

        return $vnpUrl . '?' . $query . '&vnp_SecureHashType=SHA512&vnp_SecureHash=' . $secureHash;
    }

    private function resolveVnpIpAddress(Request $request)
    {
        $ip = $request->ip();
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $ip;
        }

        return '127.0.0.1';
    }

    private function buildVnpHashData(array $inputData)
    {
        ksort($inputData);
        $hashData = '';
        $isFirst = true;

        foreach ($inputData as $key => $value) {
            if (!$isFirst) {
                $hashData .= '&';
            }

            $hashData .= urlencode($key) . '=' . urlencode($value);
            $isFirst = false;
        }

        return $hashData;
    }

    function success($codeBill)
    {
        $order = Order::where('code_bill', $codeBill)->first();
        if (!$order) {
            abort(404);
        }
        $listProductOrder = json_decode($order->product);
        return view('client.cart.success', compact('order', 'listProductOrder'));
    }

    function myOrder()
    {
        if (!Auth::check()) {
            toastr()->warning('Vui lòng đăng nhập để xem đơn hàng.');
            return redirect()->route('client.login');
        }

        $orders = Order::where('user_id', Auth::id())->latest()->get(); // Lọc đơn hàng theo người dùng
        return view('client.cart.myOrder', compact('orders'));
    }

    public function cancelOrderByUser(Request $request, $id)
    {
        if (!Auth::check()) {
            toastr()->warning('Vui lòng đăng nhập để thao tác đơn hàng.');
            return redirect()->route('client.login');
        }

        $request->validate(
            [
                'cancel_reason' => ['required', 'string', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => ':attribute phải là chuỗi ký tự.',
                'max' => ':attribute không được vượt quá :max ký tự.',
            ],
            [
                'cancel_reason' => 'Lý do hủy',
            ]
        );

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            toastr()->error('Không tìm thấy đơn hàng để hủy.');
            return redirect()->route('client.cart.myOrder');
        }

        if ((int) $order->progress !== 0) {
            toastr()->warning('Chỉ được hủy đơn khi đang ở trạng thái Chờ xác nhận.');
            return redirect()->back();
        }

        $reason = trim((string) $request->input('cancel_reason'));
        $notePrefix = '[Khách hủy đơn] Lý do: ';

        $order->progress = 3;
        $order->note = $order->note
            ? ($order->note . ' | ' . $notePrefix . $reason)
            : ($notePrefix . $reason);
        $order->save();

        toastr()->success('Hủy đơn hàng thành công!');
        return redirect()->route('client.cart.myOrder');
    }

    public function detailOrder($code_bill)
    {
        if (!Auth::check()) {
            toastr()->warning('Vui lòng đăng nhập để xem chi tiết đơn hàng.');
            return redirect()->route('client.login');
        }

        $order = Order::where('id', $code_bill)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $method_pay = $order->method_pay == 0 ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán online qua VNPAY';
        $total = number_format($order->total, 0, '', '.') . ' VNĐ';
        $note = $order->note == '' ? 'Không có ghi chú nào!' : $order->note;

        $data = [
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
        ];

        return view('client.cart.detailOrder', compact('data'));
    }

}
