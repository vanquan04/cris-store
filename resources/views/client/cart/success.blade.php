@extends('layouts.client')

@section('content')

@php
    // Tính thời gian giao hàng dự kiến (thêm 3 ngày)
    $deliveryDate = date('d/m/Y', strtotime($order->created_at . ' +3 days'));
@endphp

<style>
    #wrapper {
        max-width: 1200px;
        margin: auto;
        line-height: 25px;
        color: black
    }

    #wp-info .option {
        display: inline-block;
        color: #1225f5;
        margin: 0px 10px;
        font-weight: 700;
    }

    #order_success .title {
        font-size: 30px;
        font-weight: 500;
    }

    .icon {
        text-align: center;
    }

    .icon img {
        max-width: 100px;
        height: auto;
        display: inline-block;
        margin-top: 20px;
    }

    #wp-info {
        background: white;
        border-radius: 1rem;
    }

    a.product_thumb img {
        max-width: 70px;
        height: auto;
        vertical-align: middle;
        border-radius: 5px;
    }

    #info_buy table thead tr th {
        text-align: center;
    }

    #info_buy table tbody td {
        align-items: center;
        text-align: center;
        line-height: 60px;
        vertical-align: middle
    }

    #info_buy table tbody td a {
        align-items: center;
        text-align: center;
        line-height: 60px;
        color: rgb(0, 128, 255);
        font-weight: 500;
    }
</style>
<div id="wrapper">
    <div id="order_success">
        <div class="icon"><img src="https://sablanca.vn/Images/icon/tick-iconblue.png" alt="Lỗi"></div>
        <h3 class="text-center my-2 title">Đặt hàng thành công</h3>
    </div>
    <div id="wp-info" class="p-3 mb-5">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div id="info-guest">
                        <p>Xin chào <b>{{ $order->fullname }}</b></p>
                        <p>Chúc mừng bạn đã đặt hàng thành công sản phẩm của <b>Cris Store</b></p>
                        <b class="py-2 d-block">Thông tin người mua:</b>
                        <div class="fullname">Người nhận: &emsp; &emsp; <b>{{ $order->fullname }}</b></div>
                        <div class="tel">Điện thoại: &emsp; &emsp; &emsp; <b>{{ $order->phone }}</b></div>
                        <div class="address">Địa chỉ: &emsp; &emsp; &emsp; <b>{{ $order->address }}</b></div>
                        <div class="note">Email: &emsp; &emsp;<b>{{ $order->email }}</b></div>
                        <div class="time">Thời gian: &emsp; &emsp;<b>{{ $order->created_at->format('d/m/Y | g:i A') }}</b></div>
                        @empty(!$order->note)
                        <div class="note">Chú thích: &emsp; &emsp;<b>{{ $order->note }}</b></div>
                        @endempty
                        <div class="time">
                            <span class="text-success">Thời gian giao hàng dự kiến</span>: 
                            <b>{{ $deliveryDate }}</b>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-light h-100">
                        @php
                            $paymentMethodLabel = (int) $order->method_pay === 1
                                ? 'Thanh toán online qua VNPAY'
                                : 'Thanh toán khi nhận hàng (COD)';
                            $paymentStatusLabel = (int) $order->method_pay === 1
                                ? 'Đã thanh toán online'
                                : 'Chưa thanh toán - thu tiền khi giao hàng';
                            $total = 0;
                            foreach ($listProductOrder as $ProductOrder) {
                                $total += $ProductOrder->subtotal;
                            }
                        @endphp

                        <h5 class="mb-3">Thông tin thanh toán</h5>
                        <div class="mb-2"><b>Phương thức:</b> <span class="text-primary">{{ $paymentMethodLabel }}</span></div>
                        <div class="mb-2"><b>Trạng thái:</b> <span class="text-success">{{ $paymentStatusLabel }}</span></div>
                        <div class="mb-2"><b>Mã đơn hàng:</b> <span>{{ $order->code_bill }}</span></div>
                        <div class="mb-2"><b>Tổng tiền:</b> <span>{{ number_format($total, 0, '.', '.') . ' VNĐ' }}</span></div>

                        @if ((int) $order->method_pay === 1)
                            <div class="alert alert-success mt-3 mb-0">
                                Giao dịch online đã được ghi nhận thành công.
                            </div>
                        @else
                            <div class="alert alert-warning mt-3 mb-0">
                                Đơn hàng COD: bạn sẽ thanh toán khi nhận hàng.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="info_buy">
            <b class="py-2 d-block">Chi tiết đơn hàng</b>
            <table class="table table-bordered table-striped d-none d-md-table">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá tiền</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                @php
                $i = 0;
                $total = 0;
                @endphp
                @foreach ($listProductOrder as $ProductOrder)
                @php
                $total += $ProductOrder->subtotal;
                @endphp
                <tbody>
                    <td>{{ ++$i }}</td>
                    <td><a href="" class="product_thumb"><img src="{{ asset($ProductOrder->options->thumb_main) }}" alt="error"></a></td>
                    <td>
                        <a href="" class="text-center">
                            {{ Str::limit($ProductOrder->name, $limit = 30, $end = '...') }}
                            @isset($ProductOrder->options->field_type)
                            <div class="option text-muted" style="font-size: 13px;">Đinh: {{ str_replace('Đinh ', '', $ProductOrder->options->field_type) }}</div>
                            @endisset()
                            @isset($ProductOrder->options->option)
                            <div class="option text-muted" style="font-size: 13px;">Phân loại: {{ $ProductOrder->options->option }}</div>
                            @endisset()
                        </a>
                    </td>
                    <td>{{ number_format($ProductOrder->price, 0, '.', '.') . 'đ' }}</td>
                    <td>{{ $ProductOrder->qty }}</td>
                    <td class="text-danger fw-bold">{{ number_format($ProductOrder->subtotal, 0, '.', '.') . 'đ' }}</td>
                </tbody>
                @endforeach
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center fs-5 text-danger fw-bold">{{ number_format($total, 0, '.', '.') . 'đ' }}</th>
                    </tr>
                </tfoot>
            </table>
            <div id="wp-order-success" class="pb-3 d-md-none">
                <ul>
                    @foreach ($listProductOrder as $ProductOrder)
                    <li class="row">
                        <div class="col-5">
                            <a href="" title="" class="thumb">
                                <img src="{{ asset($ProductOrder->options->thumb_main) }}" alt="">
                            </a>
                        </div>
                        <div class="col-7 ps-0">
                            <a href="" title="" class="name-product">{{ Str::limit($ProductOrder->name, $limit = 30, $end = '...') }}</a>
                            <div class="d-flex justify-content-between">
                                <p class="text-danger">Số lượng: <b>{{ $ProductOrder->qty }}</b></p>
                                <div>
                                    @isset($ProductOrder->options->field_type)
                                    <div class="option text-muted" style="font-size: 12px; text-align:right;">Đinh: {{ str_replace('Đinh ', '', $ProductOrder->options->field_type) }}</div>
                                    @endisset()
                                    @isset($ProductOrder->options->option)
                                    <div class="option text-muted" style="font-size: 12px; text-align:right;">{{ $ProductOrder->options->option }}</div>
                                    @endisset()
                                </div>
                            </div>
                            {{ number_format($ProductOrder->price, 0, '.', '.') . 'đ' }}
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div id="wp-total-cart" class="text-end">
                    <p id="total-price" class="fl-right">Tổng giá: <span class=""><span>{{ number_format($ProductOrder->subtotal, 0, '.', '.') . 'đ' }}</span></span></p>
                </div>
            </div>
        </div>
        <hr>
        <b>Mọi thông tin đơn hàng đã được gửi trực tiếp vào email của bạn. Hãy kiểm tra để biết thêm chi tiết</b>
        <p>Cảm ơn bạn đã tin tưởng và giao dịch tại <b>Cris Store</b></p>
        <div class="buttom mt-3">
            <a href="{{ route('home') }}" class="btn btn-success d-none d-md-inline-block">Tiếp tục mua hàng</a>
            <a href="https://mail.google.com/mail/u/0/?tab=rm#inbox" target="blank" class="btn btn-danger">Check Email</a>
            <a class="btn btn-primary d-none d-md-inline-block" onclick="window.print()">In đơn hàng</a>
        </div>
    </div>
</div>
@endsection