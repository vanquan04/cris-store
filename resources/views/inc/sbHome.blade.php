<div class="fl-left">
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục giày</h3>
        </div>
        <div class="secion-detail">
            {!!$render_menu!!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="banner" class="d-none d-md-block mt-3">
                @empty(!$banners)
                @foreach ($banners as $banner)
                <a href="{{$banner->link}}"><img src="{{asset($banner->thumb_banner)}}" alt="error" class="mt-0"></a>
                @endforeach
                @endempty
            </div>
        </div>
    </div>
</div>