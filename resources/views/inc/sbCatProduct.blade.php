<div class="fl-left">
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục giày</h3>
        </div>
        <div class="secion-detail">
            {!! $render_menu !!}
        </div>
    </div>
    <div class="section my-2" id="filter-product-wp">
        <div class="section-head">
            <h3 class="section-title">Bộ lọc</h3>
        </div>
        <div class="section-detail">
            <form method="GET" action="{{ request()->routeIs('home') ? route('client.product.show') : url()->current() }}">
                <div id="filter-size" class="mb-3">
                    <div class="fw-bold">Size giày</div>
                    @if (!empty($sizes) && $sizes->count() > 0)
                        @foreach ($sizes as $size)
                        @php $sizeId = 'size-' . Str::slug($size); @endphp
                        <div class="form-group d-flex">
                            <input type="checkbox" name="size[]" id="{{ $sizeId }}" value="{{ $size }}"
                                {{ in_array($size, (array) request()->input('size', [])) ? 'checked' : '' }}>
                            <label for="{{ $sizeId }}">{{ $size }}</label>
                        </div>
                        @endforeach
                    @else
                        <small class="text-muted">Đang cập nhật</small>
                    @endif
                </div>

                <div id="filter-field" class="mb-3">
                    <div class="fw-bold">Loại sân</div>
                    @if (!empty($fieldTypes) && $fieldTypes->count() > 0)
                        @foreach ($fieldTypes as $fieldType)
                        @php $fieldTypeId = 'field-' . Str::slug($fieldType); @endphp
                        <div class="form-group d-flex">
                            <input type="checkbox" name="field_type[]" id="{{ $fieldTypeId }}" value="{{ $fieldType }}"
                                {{ in_array($fieldType, (array) request()->input('field_type', [])) ? 'checked' : '' }}>
                            <label for="{{ $fieldTypeId }}">{{ $fieldType }}</label>
                        </div>
                        @endforeach
                    @else
                        <small class="text-muted">Đang cập nhật</small>
                    @endif
                </div>

                <div id="filter-color" class="mb-3">
                    <div class="fw-bold">Màu sắc</div>
                    @if (!empty($colors) && $colors->count() > 0)
                        @foreach ($colors as $color)
                        <div class="form-group d-flex">
                            <input type="checkbox" name="color[]" id="color-{{ $color->id }}" value="{{ $color->id }}"
                                {{ in_array($color->id, (array) request()->input('color', [])) ? 'checked' : '' }}>
                            <label for="color-{{ $color->id }}">{{ $color->name }}</label>
                        </div>
                        @endforeach
                    @else
                        <small class="text-muted">Đang cập nhật</small>
                    @endif
                </div>

                <div id="filter-price" class="mb-3">
                    <div class="fw-bold">Giá</div>
                    <div class="form-group d-flex">
                        <input type="radio" name="price_range" id="price-0-500000" value="0-500000"
                            {{ request()->input('price_range') === '0-500000' ? 'checked' : '' }}>
                        <label for="price-0-500000">Dưới 500.000đ</label>
                    </div>
                    <div class="form-group d-flex">
                        <input type="radio" name="price_range" id="price-500000-1000000" value="500000-1000000"
                            {{ request()->input('price_range') === '500000-1000000' ? 'checked' : '' }}>
                        <label for="price-500000-1000000">500.000đ - 1.000.000đ</label>
                    </div>
                    <div class="form-group d-flex">
                        <input type="radio" name="price_range" id="price-1000000-5000000" value="1000000-5000000"
                            {{ request()->input('price_range') === '1000000-5000000' ? 'checked' : '' }}>
                        <label for="price-1000000-5000000">1.000.000đ - 5.000.000đ</label>
                    </div>
                    <div class="form-group d-flex">
                        <input type="radio" name="price_range" id="price-5000000-10000000" value="5000000-10000000"
                            {{ request()->input('price_range') === '5000000-10000000' ? 'checked' : '' }}>
                        <label for="price-5000000-10000000">5.000.000đ - 10.000.000đ</label>
                    </div>
                    <div class="form-group d-flex">
                        <input type="radio" name="price_range" id="price-10000000-plus" value="10000000+"
                            {{ request()->input('price_range') === '10000000+' ? 'checked' : '' }}>
                        <label for="price-10000000-plus">Trên 10.000.000đ</label>
                    </div>
                </div>

                @if (request()->input('sort'))
                    <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                @endif

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-secondary">Lọc</button>
                    <a class="btn btn-light" href="{{ url()->current() }}">Xóa lọc</a>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="banner" class="d-none d-md-block mt-3">
                @empty(!$banners)
                @foreach ($banners as $banner)
                <a href="{{ $banner->link }}"><img src="{{ asset($banner->thumb_banner) }}" alt="error"
                        class="mt-0"></a>
                @endforeach
                @endempty
            </div>
        </div>
    </div>
</div>