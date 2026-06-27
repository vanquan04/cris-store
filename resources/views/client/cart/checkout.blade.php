@extends('layouts.client')
@section('content')
<section id="myContent">
    <div class="container">
        <div class="col-md-12">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Form::open(['route' => 'client.cart.checkoutHandle', 'method' => 'POST', 'name' => 'form-checkout']) !!}
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="wp-info-customer mb-2">
                    <div class="title">
                        THÔNG TIN KHÁCH HÀNG
                    </div>
                    <div class="info-customer my-4">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('fullname', 'Họ tên', ['class' => 'my-2']) !!}
                                    {!! Form::text('fullname', $fullname, ['id' => 'fullname', 'class' =>
                                    'form-control']) !!}
                                    @error('fullname')
                                    <small class="text-danger my-2 d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('phone', 'Số điện thoại', ['class' => 'my-2']) !!}
                                    {!! Form::tel('phone', $phone, ['id' => 'phone', 'class' => 'form-control']) !!}
                                    @error('phone')
                                    <small class="text-danger my-2 d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {!! Form::label('email', 'Email', ['class' => 'my-2']) !!}
                                {!! Form::email('email', $email, ['id' => 'email', 'class' => 'form-control']) !!}
                                @error('email')
                                <small class="text-danger my-2 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('city', 'Tỉnh / Thành phố', ['class' => 'my-2']) !!}
                                    {!! Form::select('city', ['' => 'Chọn tỉnh thành'], '', [
                                    'class' => 'form-select form-control',
                                    'id' => 'city',
                                    ]) !!}

                                    {!! Form::hidden('city_label', '', ['id' => 'city_label']) !!}

                                    @error('city')
                                    <small class="text-danger my-2 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-12 col-md-6">
                                <!-- Đoạn mã HTML -->
                                <div class="form-group">
                                    {!! Form::label('district', 'Quận/Huyện', ['class' => 'my-2']) !!}
                                    {!! Form::select('district', ['' => 'Chọn quận huyện'], null, [
                                    'class' => 'form-select form-control',
                                    'id' => 'district',
                                    ]) !!}

                                    <!-- Input hidden để lưu label của option -->
                                    {!! Form::hidden('district_label', '', ['id' => 'district_label']) !!}

                                    @error('district')
                                    <small class="text-danger my-2 d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <!-- Đoạn mã HTML -->
                                <div class="form-group">
                                    {!! Form::label('ward', 'Phường/Xã', ['class' => 'my-2']) !!}
                                    {!! Form::select('ward', ['' => 'Chọn phường xã'], null, [
                                    'class' => 'form-select form-control',
                                    'id' => 'ward',
                                    ]) !!}

                                    <!-- Input hidden để lưu label của option -->
                                    {!! Form::hidden('ward_label', '', ['id' => 'ward_label']) !!}

                                    @error('ward')
                                    <small class="text-danger my-2 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('house_number', 'Số nhà', ['class' => 'my-2']) !!}
                                    {!! Form::text('house_number', old('house_number'), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 my-2">
                                {!! Form::label('note', 'Ghi chú', ['class' => 'my-2']) !!}
                                {!! Form::textarea('note', old('note'), ['class' => 'form-control', 'cols' => '30',
                                'rows' => '6']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>

            </div>
            <div class="col-12 col-md-6">
                <div class="wp-info-order mb-2">
                    <div class="title">
                        THÔNG TIN ĐƠN HÀNG
                    </div>
                    <div class="section-detail my-4 d-block">
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::Content() as $product)
                                <tr class="cart-item">
                                    <td class="product-name"><img src="{{ asset($product->options->thumb_main) }}"
                                            alt="">
                                        {{ Str::limit($product->name, $limit = 30, $end = '...') }}
                                        @if (optional($product->options)->option)
                                        <span class="badge bg-success text-white ml-2">{{ $product->options->option }}</span>
                                        @endif
                                        <b class="product-quantity fw-bold">x
                                            {{ $product->qty }}</b>
                                    </td>
                                    <td class="product-total">
                                        {{ number_format($product->total, '0', '', '.') . ' VNĐ' }}
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td class="text-black fw-bold">Tổng đơn hàng:</td>
                                    @php
                                        $totalRaw = str_replace(',', '', Cart::total());
                                        $totalFloat = floatval($totalRaw);
                                    @endphp
                                    <td><strong class="total-price text-danger">{{ number_format($totalFloat, 0, ',', '.') . ' VNĐ' }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="payment-checkout-wp">
                            <ul id="payment_methods">
                                <li>
                                    <input type="radio" id="payment-home" checked name="payment-method" value="0">
                                    <label for="payment-home">Thanh toán khi nhận hàng</label>
                                </li>
                                <li>
                                    <input type="radio" id="direct-payment" name="payment-method" value="1">
                                    <label for="direct-payment">Thanh toán bằng thẻ</label>
                                </li>
                            </ul>
                        </div>
                        <div class="place-order-wp">
                            <input type="submit" id="order-now" value="ĐẶT HÀNG" class="mb-4 p-3 px-4">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {!! Form::close() !!}

</section>
@endsection