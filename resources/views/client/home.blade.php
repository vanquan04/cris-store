@extends('layouts.client')
@section('content')
<section id="myContent">
    <style>
        .support-cta-wrap {
            margin: 10px 0 0;
        }

        .support-cta-card {
            background: linear-gradient(135deg, #1f4b78, #2b5480 55%, #356a9f);
            border-radius: 22px;
            padding: 24px 28px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
            color: #ff0b0b;
        }

        .support-cta-icon {
            width: 96px;
            height: 96px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.12);
            color: #ffb020;
            font-size: 56px;
        }

        .support-cta-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #ff0000;
        }

        .support-cta-desc {
            margin-bottom: 16px;
            color: rgba(255, 0, 0, 0.9);
            font-size: 15px;
            line-height: 1.6;
        }

        .support-cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #ff8b1f, #e36414);
            color: #ff0000 !important;
            border: none;
            border-radius: 999px;
            padding: 12px 20px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 12px 24px rgba(227, 100, 20, 0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .support-cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(227, 100, 20, 0.3);
            color: #ff0000 !important;
        }

        @media (max-width: 767px) {
            .support-cta-card {
                padding: 20px;
                text-align: center;
            }

            .support-cta-icon {
                margin: 0 auto 16px;
            }

            .support-cta-title {
                font-size: 22px;
            }
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-12 d-md-none my-3">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Nhập từ khóa bạn muốn tìm?"
                        aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row my-3 ">
            <div class="col-md-3 sidebar d-none d-xl-block">
                @include('inc.sbCatProduct')
                <div class="row">
                    <div class="col-md-12">
                        <div id="banner" class="d-none d-md-block mt-3">
                            @empty(!$banners)
                            @foreach ($banners as $banner)
                            <a href="{{$banner->link}}"><img src="{{asset($banner->thumb_banner)}}" alt="error" class="mt-0 w-100 mb-3 rounded shadow-sm"></a>
                            @endforeach
                            @endempty
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-9">
                <div class="row">
                    <div class="col-md-9">
                        <style>
                            #slider .carousel-item img {
                                width: 100%;
                            }
                        </style>
                        <div id="slider" class="w-100">
                            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach ($sliders as $key => $slider)
                                    <button type="button" data-bs-target="#carouselExampleCaptions"
                                        data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"
                                        aria-current="true" aria-label="Slide {{ $key }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    @foreach ($sliders as $key => $slider)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" data-bs-interval="3500">
                                        <a href="{{ $slider->link }}"> <img src="{{ asset($slider->thumb_slider) }}"
                                                height="400" class="d-block w-100" alt=""></a>
                                    </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-none d-md-block">
                        <div id="banner-slider">
                            <div class="row">
                                <img src="https://th.bing.com/th/id/OIP.avgNKhp7SAfp8b4cmyzUFgHaEo?w=193&h=120&c=7&r=0&o=7&dpr=1.6&pid=1.7&rm=3"
                                    alt="" class="banner-image">
                            </div>
                            <div class="row">
                                <img src="https://tse2.mm.bing.net/th/id/OIP.kNnr8zZpla4GvgfstGQxEQHaHa?rs=1&pid=ImgDetMain&o=7&rm=3"
                                    alt="" class="banner-image">
                            </div>
                            <div class="row">
                                <img src="https://vtcc.vn/wp-content/uploads/2023/11/20220103_Ms04B06IGIAR4APa1DWmXszy.jpg"
                                    alt="" class="banner-image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div id="service" class="">
                            <ul class="list-flag d-md-flex justify-content-around">
                                <div class="row">
                                    <li class="flag-item text-center">
                                        <div class="icon"><img src="{{ asset('client/images/icon-1.png') }}" alt="">
                                        </div>
                                        <div class="text-desc">
                                            <b>Miễn phí vận chuyển</b>
                                            <p>Giao hàng toàn quốc</p>
                                        </div>
                                    </li>
                                </div>
                                <div class="row">
                                    <li class="flag-item text-center">
                                        <div class="icon"><img src="{{ asset('client/images/icon-2.png') }}" alt="">
                                        </div>
                                        <div class="text-desc">
                                            <b>Tư vấn 24/7</b>
                                            <p>Gọi điện mọi lúc, mọi nơi</p>
                                        </div>
                                    </li>
                                </div>
                                <div class="row">
                                    <li class="flag-item text-center">
                                        <div class="icon"><img src="{{ asset('client/images/icon-3.png') }}" alt="">
                                        </div>
                                        <div class="text-desc">
                                            <b>Tiết kiệm hơn</b>
                                            <p>Với nhiều ưu đãi lớn</p>
                                        </div>
                                    </li>
                                </div>
                                <div class="row">
                                    <li class="flag-item text-center">
                                        <div class="icon"><img src="{{ asset('client/images/icon-4.png') }}" alt="">
                                        </div>
                                        <div class="text-desc">
                                            <b>Thanh toán nhanh</b>
                                            <p>Hỗ trợ thanh toán online</p>
                                        </div>
                                    </li>
                                </div>
                                <div class="row">
                                    <li class="flag-item text-center">
                                        <div class="icon"><img src="{{ asset('client/images/icon-5.png') }}" alt="">
                                        </div>
                                        <div class="text-desc">
                                            <b>Đặt hàng online</b>
                                            <p>Thao tác đơn giản</p>
                                        </div>
                                    </li>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" id="row-2">
                    <div class="col-md-8">
                        @if ($featured_products->count() > 0)
                        <section id="featured-products">
                            <div class="title">
                                <img src="{{ asset('client/images/FeaturedProducts.webp') }}" alt="" class="featured-title-image">
                                <b class="featured-products-title">SẢN PHẨM NỔI BẬT</b>
                                <script>
                                    var object = document.querySelector('.featured-products-title')
                                        setInterval(function() {
                                            object.classList.toggle('warning')
                                        }, 300)
                                </script>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselDiscount"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon d-none" aria-hidden="true"></span>
                                    <i class="fas fa-chevron-left"></i>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselDiscount"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon d-none" aria-hidden="true"></span>
                                    <i class="fas fa-chevron-right"></i>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div class="show-discount mt-1">
                                <div id="carouselDiscount" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($featured_products as $key => $featured_product)
                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}"
                                            data-bs-interval="10000">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="{{ route('client.product.detail', $featured_product->slug) }}" class="position-relative d-block">
                                                        @php
                                                            $active_promo = $featured_product->getActivePromotion();
                                                        @endphp
                                                        
                                                        @if($featured_product->discount > 0)
                                                        <div class="position-absolute badge badge-danger shadow-sm" style="top: 10px; right: 10px; font-size: 13px; z-index: 10; padding: 5px 8px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 6px;">
                                                            -{{ $featured_product->discount }}%
                                                        </div>
                                                        @endif
                                                        <img src="{{ $featured_product->thumb_main ? asset($featured_product->thumb_main) : asset('client/images/icon-5.png') }}" alt=""
                                                            class="rounded w-100 featured-product-image">
                                                    </a>
                                                    
                                                    @if($active_promo && $active_promo->end_date)
                                                    <div class="promo-countdown mt-2 text-danger font-weight-bold" data-end="{{ $active_promo->end_date }}" style="background: #fff5f5; padding: 6px 10px; border-radius: 6px; font-size: 13px; border: 1px dashed #fca5a5;">
                                                        <i class="fas fa-stopwatch"></i> Kết thúc sau: <span class="countdown-timer text-dark"></span>
                                                    </div>
                                                    @endif
                                                    <div class="name-product">
                                                        <h3>{{ $featured_product->name }}
                                                        </h3>
                                                    </div>
                                                    <div class="price">
                                                        <div class="new-price text-danger d-inline-block">
                                                            {{ number_format($featured_product->new_price, 0, '.', '.')
                                                            . 'đ' }}
                                                        </div>
                                                        <small class="old-price d-inline-block"><del>{{
                                                                number_format($featured_product->old_price, 0, '.', '.')
                                                                . 'đ' }}</del></small>
                                                    </div>
                                                    <div class="sold">
                                                        <p class="d-inline-block text-white">
                                                            {{ $featured_product->purchases }} sản phẩm đã
                                                            được
                                                            bán</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 discount-right">
                                                    <div class="benefit">
                                                        <div class="benefit-item my-3">
                                                            <div class="icon d-inline-block"><i
                                                                    class="fas fa-check-circle"></i></div>
                                                            <b>Miễn phí vận chuyển</b>
                                                        </div>
                                                        <div class="benefit-item my-3">
                                                            <span class="icon d-inline-block"><i
                                                                    class="fas fa-check-circle"></i></span>
                                                            <b class="d-inline-block">Đổi trả dễ dàng</b>
                                                        </div>
                                                        <div class="benefit-item my-3">
                                                            <span class="icon d-inline-block"><i
                                                                    class="fas fa-check-circle"></i></span>
                                                        </div>
                                                    </div>
                                                    @if($featured_product->desc_quick)
                                                    <div class="quick-desc mt-3 pt-3 border-top" style="color: #4b5563; font-size: 14px; line-height: 1.6;">
                                                        {!! $featured_product->desc_quick !!}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                        @endif
                    </div>
                    <div class="col-md-4 d-none d-md-block">
                        <div id="bestseller">
                            <div class="title">
                                <b>
                                    <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7601/7601323.png"
                                            alt="" width="30">
                                    </div>
                                    <p class="bestseller-title">TOP BÁN CHẠY</p>
                                </b>
                            </div>
                            <div class="item mt-1">
                                <ul>
                                    @foreach ($bestseller as $item)
                                    <li class="d-flex">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="{{ route('client.product.detail', $item->slug) }}"><img
                                                        src="{{ asset($item->thumb_main) }}" alt="error"></a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="name-product">
                                                    <p><a href="{{ route('client.product.detail', $item->slug) }}">{{
                                                            $item->name }}</a></p>
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
                    </div>
                </div>
                @empty(!$groupedProducts)
                @foreach ($groupedProducts as $k => $v)
                <div class="row mt-3">
                    <section id="list-product">
                        <div class="category mt-3">
                            <div class="title">
                                <p>{{ $k }}</p>
                            </div>
                            <ul>
                                @foreach ($v as $item)
                                <li class="item">
                                    <div class="thumb-product">
                                        <a href="{{ route('client.product.detail', $item->slug) }}"><img
                                                src="{{ asset($item->thumb_main) }}" alt=""></a>
                                    </div>
                                    <div class="view&code d-flex justify-content-between mb-2">
                                        <div class="code">
                                            Mã SP <span>{{ $item->code }}</span>
                                        </div>
                                        <div class="view d-flex">
                                            <div class="icon"><i class="fas fa-eye"></i></div>
                                            {{ $item->views }}
                                        </div>
                                    </div>
                                    <div class="name-product">
                                        <a href="{{ route('client.product.detail', $item->slug) }}">{{
                                            Str::limit($item->name, $limit = 35, $end = '...') }}</a>
                                    </div>
                                    <div class="price">
                                        <div class="new-price d-inline-block">
                                            {{ number_format($item->new_price, 0, '.', '.') . 'đ' }}</div>
                                        @if ($item->discount != 0)
                                        <small class="old-price d-inline-block">{{ number_format($item->old_price, 0,
                                            '.', '.') . 'đ' }}</small>
                                        @endif
                                    </div>
                                    <div class="action mt-2 d-flex justify-content-between">
                                        <a data-id="{{$item->id}}" title=""
                                            class="btn btn-style add-cart add-cart-ajax fl-left"><span>Thêm
                                                giỏ
                                                hàng</span></a>
                                        <a href="{{ route('client.buynow', $item->slug) }}" title=""
                                            class="btn btn-style buy-now fl-right"><span>Mua
                                                ngay</span></a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                </div>
                @endforeach
                @endempty
            </div>
        </div>
        <section id="new-post" class="d-none d-md-block">
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <img src="{{ asset('client/images/FeaturedProducts.webp') }}" alt="">
                        <b>BÀI VIẾT MỚI NHẤT</b>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 my-3">
                    <div class="cat1">
                        <div class="row py-2">
                            @foreach ($listPostEnvironment as $post)
                            <div class="col-6">
                                <div class="thumb-post">
                                    <a href="{{ route('client.blog.detail',$post->slug) }}"><img
                                            src="{{ asset($post->thumb_main) }}" alt="err"></a>
                                </div>
                                <p class="content-demo">
                                    <a href="{{ route('client.blog.detail',$post->slug) }}"> {{ Str::limit($post->name,
                                        $limit = 60, $end = '...') }}</a>
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-5 my-3">
                    <div class="cat2">
                        @foreach ($listPost as $post)
                        <div class="row py-1">
                            <div class="col-5">
                                <div class="thumb-post">
                                    <a href="{{ route('client.blog.detail',$post->slug) }}"><img
                                            src="{{ asset($post->thumb_main) }}" alt=""></a>
                                </div>
                            </div>
                            <div class="col-7">
                                <p class="namePost">
                                    <a href="{{ route('client.blog.detail',$post->slug) }}">{{ Str::limit($post->name,
                                        $limit = 60, $end = '...') }}</a>
                                </p>
                                <div class="cat-name">
                                    <p>{{ $post->Cat_blog->name }}</p>
                                </div>
                                <p class="content-demo">
                                    {{ Str::limit($post->content_demo, $limit = 160, $end = '...') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <div id="wp-subscriber" class="support-cta-wrap">
            <div class="col-md-12">
                <div class="support-cta-card">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-lg-2">
                            <div class="support-cta-icon">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                        </div>
                        <div class="col-md-10 col-lg-10 mt-3 mt-md-0">
                            <div class="support-cta-title">Bạn cần cửa hàng hỗ trợ?</div>
                            <p class="support-cta-desc">Gửi yêu cầu đổi trả, khiếu nại hoặc cần tư vấn để được đội ngũ CRIS Store hỗ trợ nhanh chóng, rõ ràng và thuận tiện hơn.</p>
                            <a href="{{ route('client.support.index') }}" class="support-cta-button">
                                <i class="fas fa-headset"></i>
                                Gửi yêu cầu hỗ trợ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const countdowns = document.querySelectorAll('.promo-countdown');
    countdowns.forEach(el => {
        const endDateStr = el.getAttribute('data-end');
        if (!endDateStr) return;
        
        // Add 23:59:59 to end_date to count down to the end of the day
        const endDate = new Date(endDateStr + 'T23:59:59').getTime();
        const timerSpan = el.querySelector('.countdown-timer');
        
        const updateTimer = () => {
            const now = new Date().getTime();
            const distance = endDate - now;
            
            if (distance < 0) {
                timerSpan.innerHTML = "Đã kết thúc";
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            let timeStr = "";
            if (days > 0) timeStr += `${days} ngày `;
            timeStr += `${hours} giờ ${minutes} phút ${seconds} giây`;
            
            timerSpan.innerHTML = timeStr;
        };
        
        updateTimer();
        setInterval(updateTimer, 1000);
    });
});
</script>
@endsection