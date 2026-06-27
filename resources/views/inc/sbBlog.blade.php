<div class="fl-left">
    <div id="bestseller" class="mb-3">
        <div class="title mb-1">
            <b>
                <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7601/7601323.png" alt="" width="30">
                </div>
                <p class="bestseller-title">TOP BÁN CHẠY</p>
            </b>
        </div>
        <div class="item mb-3">
            <ul>
                @foreach ($bestseller as $item)
                <li class="d-flex">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset($item->thumb_main) }}" alt="error">
                        </div>
                        <div class="col-md-8">
                            <div class="name-product">
                                <p><a href="">{{ $item->name }}</a></p>
                                <div class="price">
                                    <div class="new-price">
                                        {{ number_format($item->new_price, 0, '.', '.') . 'đ' }}
                                    </div>
                                    <small>{{$item->purchases}} sản phẩm đã được bán</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="banner" class="d-none d-md-block">
                @empty(!$banners)
                @foreach ($banners as $banner)
                <a href="{{ $banner->link }}"><img src="{{ asset($banner->thumb_banner) }}" alt="error"
                        class="my-3"></a>
                @endforeach
                @endempty
            </div>
        </div>
    </div>
</div>