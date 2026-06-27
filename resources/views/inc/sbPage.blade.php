<div class="fl-left">
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0"
        nonce="67vbHzoI"></script>
    <div class="row">
        <div class="wp-fanpage mb-3">
            <div class="fb-page d-block" data-href="https://www.facebook.com/khoacntteaut" data-tabs="timeline"
                data-width="" data-height="" data-small-header="true" data-adapt-container-width="true"
                data-hide-cover="false" data-show-facepile="false">
                <blockquote cite="https://www.facebook.com/khoacntteaut" class="fb-xfbml-parse-ignore"><a
                        href="https://www.facebook.com/khoacntteaut">Khoa Công nghệ Thông tin - Trường ĐH Công nghệ Đông
                        Á</a></blockquote>
            </div>
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