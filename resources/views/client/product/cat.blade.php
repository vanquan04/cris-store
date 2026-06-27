@extends('layouts.client')
@section('content')
<section id="myContent">
    <div class="container">
        <div class="col-md-12">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('home') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">{{ $cat_name == '' ? '' : $cat_name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 sidebar d-none d-md-block">
                @include('inc.sbCatProduct')
            </div>
            <div class="col-md-9">
                <div id="wp-cat-product">
                    <div class="title-filter d-flex justify-content-between">
                        <p class="title">{{ $cat_name == '' ? '' : $cat_name }}</p>
                        <div class="col-md-4 float-end">
                            <form id="wp-arrange" class="d-flex" method="GET" action="{{ url()->current() }}">
                                <select name="sort" id="arrange" class="form-select">
                                    <option value="">Sắp xếp</option>
                                    <option value="1" {{ request()->input('sort') === '1' ? 'selected' : '' }}>Giá cao xuống thấp</option>
                                    <option value="2" {{ request()->input('sort') === '2' ? 'selected' : '' }}>Giá thấp lên cao</option>
                                </select>
                                @foreach ((array) request()->input('size', []) as $size)
                                    <input type="hidden" name="size[]" value="{{ $size }}">
                                @endforeach
                                @foreach ((array) request()->input('field_type', []) as $fieldType)
                                    <input type="hidden" name="field_type[]" value="{{ $fieldType }}">
                                @endforeach
                                @foreach ((array) request()->input('color', []) as $colorId)
                                    <input type="hidden" name="color[]" value="{{ $colorId }}">
                                @endforeach
                                @if (request()->input('price_range'))
                                    <input type="hidden" name="price_range" value="{{ request()->input('price_range') }}">
                                @endif
                                <input type="submit" value="Lọc" class="btn btn-secondary ms-1">
                            </form>
                            <p class="py-2 float-end">Hiển thị {{ $products->total() }} trên tổng {{ $qtyProduct }}
                                sản phẩm</p>
                        </div>
                    </div>
                    <div class="wp-list-product">
                        <ul id="listProduct">
                            @foreach ($products as $product)
                            <li class="item">
                                <div class="thumb-product">
                                    <a href="{{ url('san-pham' . '/' . $product->slug) }}"><img
                                            src="{{ asset($product->thumb_main) }}" alt=""></a>
                                </div>
                                <div class="view&code d-flex justify-content-between mb-2">
                                    <div class="code">
                                        Mã SP <span>{{ $product->code }}</span>
                                    </div>
                                    <div class="view d-flex">
                                        <div class="icon"><i class="fas fa-eye"></i></div>
                                        {{ $product->views }}
                                    </div>
                                </div>
                                <div class="name-product">
                                    <a href="{{ url('san-pham' . '/' . $product->slug) }}">{{ Str::limit($product->name,
                                        $limit = 35, $end = '...') }}</a>
                                </div>
                                <div class="price">
                                    <div class="new-price d-inline-block">
                                        {{ number_format($product->new_price, 0, '.', '.') . 'đ' }}</div>
                                    @if ($product->discount != 0)
                                    <small class="old-price d-inline-block">{{ number_format($product->old_price, 0,
                                        '.', '.') . 'đ' }}</small>
                                    @endif
                                </div>
                                <div class="action mt-2 d-flex justify-content-between">
                                    <a data-id="{{$product->id}}" title=""
                                        class="btn btn-style add-cart add-cart-ajax fl-left"><span>Thêm
                                            giỏ
                                            hàng</span></a>
                                    <a href="" title="" class="btn btn-style buy-now fl-right"><span>Mua
                                            ngay</span></a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="section" id="paging-wp">
                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                {{ $products->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection