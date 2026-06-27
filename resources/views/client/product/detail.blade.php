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
                            <a href="" title="">Chi tiết sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 sidebar d-none d-md-block">
                @include('inc.sbHome')
            </div>
            <div class="col-md-9">
                <div id="wp-detail-product">
                    <div class="section-detail">
                        <div class="show-product">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="thumb_main">
                                        <img src="{{ asset($product->thumb_main) }}" alt="">
                                    </div>
                                    <div class="list_thumb mt-3">
                                        <div class="owl-carousel owl-theme">
                                            @forelse ($thumb_detail as $thumb)
                                            <div class="item">
                                                <img src="{{ asset($thumb) }}" alt="">
                                            </div>
                                            @empty
                                            <!-- No detail images -->
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="product_name">
                                        {{ $product->name }}
                                    </div>
                                    <div class="desc-quick fs-6 my-2">
                                        {!! $product->desc_quick !!}
                                    </div>
                                    <form action="{{ route('client.cart.add', $product->slug) }}" method="GET">
                                        @csrf
                                        @php
                                            $firstColor = !empty($productColors) && $productColors->count() > 0 ? $productColors->first() : null;
                                            $firstConfig = !empty($configs) && $configs->count() > 0 ? $configs->first() : null;
                                            $firstConfigId = $firstConfig ? $firstConfig->id : '';
                                            $initialPrice = $product->new_price;
                                            $initialOldPrice = $product->old_price;
                                            if ($firstColor && $firstConfig && !empty($variantData)) {
                                                $variant = collect($variantData)->where('color_id', $firstColor->id)->where('config_id', $firstConfigId)->first();
                                                if ($variant) {
                                                    $basePrice = $variant['price'];
                                                    if (isset($variant['discount']) && $variant['discount'] > 0) {
                                                        $initialPrice = round($basePrice * (1 - $variant['discount'] / 100));
                                                        $initialOldPrice = $basePrice;
                                                    } else {
                                                        $initialPrice = $basePrice;
                                                        $initialOldPrice = null;
                                                    }
                                                }
                                            } elseif ($firstConfig && !empty($firstConfig->pivot->price)) {
                                                $initialPrice = $firstConfig->pivot->price;
                                            }
                                        @endphp

                                        @if(!empty($product->field_type))
                                        <div class="font-weight-bold my-2 text-dark">Loại đinh: <span class="font-weight-normal">{{ $product->field_type }}</span></div>
                                        @endif
                                        @if(!empty($productColors) && $productColors->count() > 0)
                                        <div class="font-weight-bold my-2 text-dark">Màu:</div>
                                        <div class="color-buttons my-1">
                                            @foreach($productColors as $color)
                                            <button type="button" class="color-button btn-sm {{ $loop->first ? 'selected' : '' }}"
                                                data-color-id="{{ $color->id }}"
                                                data-color-name="{{ $color->name }}"
                                                style="border: 1px solid #ddd; background: {{ $color->code }}; color: #111; margin-right: 6px;">
                                                {{ $color->name }}
                                            </button>
                                            @endforeach
                                        </div>
                                        @endif

                                        @if(!empty($configs) && $configs->count() > 0)
                                        <div class="d-flex justify-content-between align-items-center my-2">
                                            <div class="font-weight-bold text-dark">Size:</div>
                                            <a href="{{ route('client.page.show', ['slug' => 'huong-dan-chon-size']) }}" target="_blank" style="text-decoration: underline; font-size: 14px; color: #007bff;">Hướng dẫn chọn size</a>
                                        </div>
                                        <div class="option-buttons my-1" id="size-options-wrap">
                                            @foreach ($configs as $value)
                                            @php
                                                $defaultOptionPrice = !empty($value->pivot->price) ? $value->pivot->price : $product->new_price;
                                            @endphp
                                            <button type="button" class="option-button btn-sm {{ $value->id == $firstConfigId ? 'selected' : '' }}"
                                                data-option-id="{{ $value->id }}"
                                                data-size-label="{{ $value->memory ?: $value->name }}"
                                                data-default-price="{{ (float) $defaultOptionPrice }}">
                                                {{ $value->memory ?: $value->name }}
                                            </button>
                                            @endforeach
                                        </div>
                                        @endif

                                        <input type="hidden" name="selected_option_id" id="selected_option_id" value="{{ $firstConfigId }}">
                                        <input type="hidden" name="selected_color_id" id="selected_color_id" value="{{ $firstColor ? $firstColor->id : '' }}">

                                        <div class="price price-product-detail">
                                            <p class="new-price text-danger d-inline-block">
                                                {{ number_format($initialPrice, 0, '.', '.') . ' VNĐ' }}</p>
                                            @if($initialOldPrice)
                                            <del class="old-price d-inline-block">{{ number_format($initialOldPrice, 0, '.', '.') . ' VNĐ' }}</del>
                                            @else
                                            <del class="old-price d-inline-block" style="display:none;"></del>
                                            @endif
                                        </div>
                                        <div id="variant-stock" class="text-muted mb-2"></div>
                                        <div id="num-order-wp">
                                            <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                            <input type="text" name="num-order" value="1" id="num-order">
                                            <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <button type="submit" class="add-cart btn btn-success text-white">Thêm giỏ
                                            hàng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wp-desc-detail mt-3">
                        <div class="title">
                            <p>MÔ TẢ SẢN PHẨM</p>
                        </div>
                        <div class="section-detail">
                            <div class="desc-detail-demo">
                                <div class="desc-detail">
                                    {!! htmlspecialchars_decode($product->desc_detail) !!}
                                </div>
                            </div>
                            <style>
                                .desc-detail-full img,
                                .desc-detail img {
                                    max-width: 100%;
                                }
                            </style>
                            <div class="desc-detail-full">
                                {!! $product->desc_detail !!}
                            </div>
                            <div class="btn-more-info">
                                <button class="view-mode">Xem thêm</button>
                            </div>
                        </div>
                    </div>
                    <div class="wp-same-category my-4">
                        <div class="title">
                            <p>CÙNG CHUYÊN MỤC</p>
                        </div>
                        <div class="list_product mt-3">
                            <ul class="owl-carousel same-category owl-theme">
                                @foreach ($categoryProducts as $categoryProduct)
                                <li class="item">
                                    <div class="thumb-product">
                                        <a href="{{route('client.product.detail',$categoryProduct->slug)}}"><img
                                                src="{{ asset($categoryProduct->thumb_main) }}" alt=""></a>
                                    </div>
                                    <div class="view&code d-flex justify-content-between mb-2">
                                        <div class="code">
                                            <span class="fw-normal">Mã SP</span> <span>{{$categoryProduct->code}}</span>
                                        </div>
                                        <div class="view d-flex">
                                            <div class="icon"><i class="fas fa-eye"></i></div>
                                            {{$categoryProduct->views}}
                                        </div>
                                    </div>
                                    <div class="name-product">
                                        <p>{{ Str::limit($categoryProduct->name, $limit = 35, $end = '...') }}
                                        </p>
                                    </div>
                                    <div class="price">
                                        <div class="new-price d-inline-block">
                                            {{ number_format($categoryProduct->new_price, 0, '.', '.') . 'đ' }}
                                        </div>
                                        @empty(!$categoryProduct->discount)
                                        <small class="old-price d-inline-block">{{
                                            number_format($categoryProduct->old_price, 0, '.', '.') . 'đ' }}</small>
                                        @endempty
                                    </div>
                                    <div class="action mt-2 d-flex justify-content-between">
                                        <a data-id="{{$categoryProduct->id}}" title=""
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
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

<style>
    /* Color button selected state */
    .color-button {
        transition: all 0.3s ease;
        opacity: 0.7;
        border: 2px solid transparent !important;
    }

    .color-button.selected {
        opacity: 1;
        border: 2px solid #333 !important;
        transform: scale(1.05);
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
        font-weight: bold;
    }

    /* Size button selected state */
    .option-button {
        transition: all 0.3s ease;
        opacity: 0.7;
        border: 2px solid transparent !important;
    }

    .option-button.selected {
        opacity: 1;
        border: 2px solid #28a745 !important;
        background-color: #28a745 !important;
        color: white !important;
        transform: scale(1.05);
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.3);
        font-weight: bold;
    }

    .option-button:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
</style>

<script>
    $(document).ready(function () {
        const variants = @json($variantData ?? []);
        const colorImages = @json($colorImages ?? []);
        const variantImages = @json($variantImages ?? []);
        const defaultImages = @json($thumb_detail ?? []);
        const productMainImage = "{{ asset($product->thumb_main) }}";
        const fallbackPrice = {{ (float) $product->new_price }};
        const hasVariantData = Array.isArray(variants) && variants.length > 0;

        function formatCurrency(value) {
            return Number(value || 0).toLocaleString('vi-VN') + ' VNĐ';
        }

        function getSelectedColorId() {
            return Number($('#selected_color_id').val() || 0);
        }

        function getSelectedConfigId() {
            return Number($('#selected_option_id').val() || 0);
        }

        function findVariant(colorId, configId) {
            return variants.find(v => Number(v.color_id) === Number(colorId) && Number(v.config_id) === Number(configId));
        }

        function updateCarouselImages(urls) {
            if (!urls || !urls.length) return;
            $('.thumb_main img').attr('src', urls[0]);
            let thumbsHtml = '';
            urls.forEach(function (url) {
                thumbsHtml += '<div class="item"><img src="' + url + '" alt=""></div>';
            });
            const $carousel = $('.list_thumb .owl-carousel');
            if ($carousel.hasClass('owl-loaded')) {
                $carousel.trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded owl-drag');
            }
            $carousel.html(thumbsHtml).addClass('owl-carousel');
            if (typeof $.fn.owlCarousel !== 'undefined') {
                $carousel.owlCarousel({
                    loop: false, margin: 10, dots: false, nav: true,
                    responsive: {
                        0: { items: 4, nav: true },
                        600: { items: 3, nav: false },
                        1000: { items: 4, nav: true }
                    }
                });
            }
            // Rebind thumbnail click to update main image
            $carousel.find('.item img').off('click.thumb').on('click.thumb', function () {
                const src = $(this).attr('src');
                $('.thumb_main img').css('opacity', 0);
                setTimeout(function () { $('.thumb_main img').attr('src', src).css('opacity', 1); }, 100);
            });
        }

        function renderImagesByVariant(colorId, configId) {
            // Try variant-specific images first
            const variantKey = colorId + '_' + configId;
            let list = variantImages && variantImages[variantKey] ? variantImages[variantKey] : null;

            // Fallback to color-only images
            if (!list || !list.length) {
                list = colorImages && colorImages[colorId] ? colorImages[colorId] : null;
            }

            if (list && list.length) {
                const baseUrl = "{{ asset('') }}";
                updateCarouselImages(list.map(function (p) { return baseUrl + p; }));
                return;
            }

            // No static data — fetch from API
            const params = new URLSearchParams();
            if (colorId) params.append('color_id', colorId);
            if (configId) params.append('config_id', configId);
            fetch('/api/product-images/{{ $product->id }}?' + params.toString())
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.success && data.images && data.images.length) {
                        updateCarouselImages(data.images.map(function (img) { return img.url; }));
                    }
                    // If still no images, keep current display
                })
                .catch(function () { /* keep current display on error */ });
        }

        function renderImagesByColor(colorId) {
            let list = colorImages && colorImages[colorId] ? colorImages[colorId] : null;
            if (list && list.length) {
                const baseUrl = "{{ asset('') }}";
                updateCarouselImages(list.map(function (p) { return baseUrl + p; }));
                return;
            }

            // Fallback to API with color only first so color selection always has priority.
            const colorOnlyParams = new URLSearchParams();
            if (colorId) colorOnlyParams.append('color_id', colorId);
            fetch('/api/product-images/{{ $product->id }}?' + colorOnlyParams.toString())
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.success && data.images && data.images.length) {
                        updateCarouselImages(data.images.map(function (img) { return img.url; }));
                        return;
                    }
                    renderImagesByVariant(colorId, getSelectedConfigId());
                })
                .catch(function () {
                    renderImagesByVariant(colorId, getSelectedConfigId());
                });
        }

        function refreshSizeState() {
            if (!hasVariantData) {
                $('.option-button').each(function () {
                    $(this).prop('disabled', false).removeClass('disabled').text($(this).data('size-label'));
                });
                return;
            }

            const selectedColorId = getSelectedColorId();
            let selectedStillValid = false;

            $('.option-button').each(function () {
                const sizeId = Number($(this).data('option-id'));
                const variant = findVariant(selectedColorId, sizeId);

                if (!variant) {
                    $(this).prop('disabled', true).addClass('disabled').text($(this).data('size-label') + ' (N/A)');
                    return;
                }

                if (Number(variant.stock) <= 0) {
                    $(this).prop('disabled', true).addClass('disabled').text($(this).data('size-label') + ' (Hết hàng)');
                } else {
                    $(this).prop('disabled', false).removeClass('disabled').text($(this).data('size-label'));
                }

                if (Number($('#selected_option_id').val()) === sizeId && Number(variant.stock) > 0) {
                    selectedStillValid = true;
                }
            });

            if (!selectedStillValid) {
                const firstAvailable = $('.option-button').filter(function () {
                    return !$(this).prop('disabled');
                }).first();

                if (firstAvailable.length) {
                    firstAvailable.trigger('click');
                } else {
                    $('#selected_option_id').val('');
                    $('.option-button').removeClass('selected');
                    $('.price-product-detail .new-price').text(formatCurrency(fallbackPrice));
                    $('#variant-stock').text('Biến thể hiện tại đã hết hàng.');
                }
            }
        }

        function applyPriceData(priceText, stock, isOutOfStock, oldPriceText) {
            if (priceText) {
                $('.price-product-detail .new-price').text(priceText);
            }
            const $oldPrice = $('.price-product-detail .old-price');
            if (oldPriceText) {
                if ($oldPrice.length) {
                    $oldPrice.text(oldPriceText).show();
                } else {
                    $('.price-product-detail').append('<del class="old-price d-inline-block">' + oldPriceText + '</del>');
                }
            } else {
                if ($oldPrice.length) {
                    $oldPrice.hide();
                }
            }
            if (typeof stock !== 'undefined') {
                if (isOutOfStock || stock <= 0) {
                    $('#variant-stock').text('Hết hàng').removeClass('text-muted text-success').addClass('text-danger fw-bold');
                } else {
                    $('#variant-stock').text('Còn hàng').removeClass('text-muted text-danger').addClass('text-success fw-bold');
                }
            }
        }

        function fetchPriceFromServer(colorId, configId) {
            $.post("{{ route('client.product.option') }}", {
                _token: '{{ csrf_token() }}',
                id: {{ $product->id }},
                colorId: colorId,
                idOption: configId
            }, function (data) {
                applyPriceData(data.price, data.stock, data.is_out_of_stock, data.old_price);
            }).fail(function () {
                // On failure, show size button price
                const selectedButton = $('.option-button.selected').first();
                const defaultPrice = selectedButton.length ? Number(selectedButton.data('default-price') || fallbackPrice) : fallbackPrice;
                $('.price-product-detail .new-price').text(formatCurrency(defaultPrice));
                $('#variant-stock').text('');
            });
        }

        function refreshPriceAndStock() {
            const selectedColorId = getSelectedColorId();
            const selectedConfigId = getSelectedConfigId();

            if (hasVariantData) {
                const variant = findVariant(selectedColorId, selectedConfigId);
                if (variant) {
                    $('.price-product-detail .new-price').text(formatCurrency(variant.price));
                    const stock = Number(variant.stock);
                    if (stock > 0) {
                        $('#variant-stock').text('Còn hàng').removeClass('text-muted text-danger').addClass('text-success fw-bold');
                    } else {
                        $('#variant-stock').text('Hết hàng').removeClass('text-muted text-success').addClass('text-danger fw-bold');
                    }
                    return;
                }
            }

            // No static variant data or variant not found — use AJAX
            if (selectedColorId && selectedConfigId) {
                fetchPriceFromServer(selectedColorId, selectedConfigId);
            } else {
                const selectedButton = $('.option-button.selected').first();
                const defaultPrice = selectedButton.length ? Number(selectedButton.data('default-price') || fallbackPrice) : fallbackPrice;
                $('.price-product-detail .new-price').text(formatCurrency(defaultPrice));
                $('#variant-stock').text('');
            }
        }

        $('.color-button').on('click', function () {
            $('.color-button').removeClass('selected');
            $(this).addClass('selected');
            $('#selected_color_id').val($(this).data('color-id'));

            renderImagesByColor(Number($(this).data('color-id')));
            refreshSizeState();
            refreshPriceAndStock();
        });

        $('.option-button').on('click', function () {
            if ($(this).prop('disabled')) {
                return;
            }
            $('.option-button').removeClass('selected');
            $(this).addClass('selected');
            $('#selected_option_id').val($(this).data('option-id'));
            
            // Update images when size is selected
            const selectedColorId = getSelectedColorId();
            const selectedConfigId = Number($(this).data('option-id'));
            if (selectedColorId && selectedConfigId) {
                renderImagesByVariant(selectedColorId, selectedConfigId);
            }
            
            refreshPriceAndStock();
        });

        $('form[action="{{ route('client.cart.add', $product->slug) }}"]').on('submit', function (e) {
            const selectedColorId = getSelectedColorId();
            const selectedConfigId = getSelectedConfigId();

            if (!selectedColorId && {{ !empty($productColors) && $productColors->count() > 0 ? 'true' : 'false' }}) {
                e.preventDefault();
                alert('Vui lòng chọn màu sắc.');
                return;
            }
            if (!selectedConfigId && {{ !empty($configs) && $configs->count() > 0 ? 'true' : 'false' }}) {
                e.preventDefault();
                alert('Vui lòng chọn kích cỡ.');
                return;
            }

            if (hasVariantData && selectedColorId && selectedConfigId) {
                const variant = findVariant(selectedColorId, selectedConfigId);
                if (variant && Number(variant.stock) <= 0) {
                    e.preventDefault();
                    alert('Size đã hết hàng, vui lòng chọn size khác.');
                }
            }
        });

        const firstColorBtn = $('.color-button.selected').first();
        if (firstColorBtn.length) {
            firstColorBtn.trigger('click');
        } else {
            refreshSizeState();
            refreshPriceAndStock();
        }
    });
</script>
@endsection