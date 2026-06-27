@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <style>
        .variant-editor-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .variant-editor-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .variant-editor-note {
            margin: 0;
            font-size: 13px;
            color: #6b7280;
        }

        .variant-editor-wrap {
            max-height: 560px;
            overflow: auto;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fff;
        }

        .product-section-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #fff;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        }

        .product-section-title {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 14px;
        }

        .selection-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 18px;
        }

        #variant-matrix-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f8fafc;
            white-space: nowrap;
            border-bottom: 1px solid #dbe2ea;
        }

        #variant-matrix-table tbody td {
            vertical-align: middle;
        }

        #variant-matrix-table .form-control-sm {
            min-width: 92px;
        }

        .variant-empty-state {
            padding: 24px 16px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .product-main-image img {
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }
    </style>
    @if (session('status'))
    <div class="{{session('color')?session('color'):'alert-success'}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật sản phẩm
        </div>
        <div class="card-body">
            {!! Form::open(['route' => ['product.update', $product->id],'method' => 'POST','id' =>'main-form' ,'files'
            => true]) !!}
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="product-section-card">
                        <div class="product-section-title">Thông tin cơ bản</div>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    {!! Form::label('name', 'Tên sản phẩm(*)',['class' => 'font-weight-bold']) !!}
                                    {!! Form::text('name', $product->name, ['class' => 'form-control' , 'id' => 'name']) !!}
                                    @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="slug">Slug(*) <small class="text-success"><b class="autofill-trigger">[Tự động điền]</b></small></label>
                                    {!! Form::text('slug', $product->slug, ['class' => 'form-control' , 'id' => 'slug']) !!}
                                    @error('slug')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-0">
                                    {!! Form::label('field_type', 'Loại đinh', ['class' => 'font-weight-bold']) !!}
                                    {!! Form::select('field_type', [
                                        'Đinh TF (sân cỏ nhân tạo, trong nhà)' => 'Đinh TF (sân cỏ nhân tạo, trong nhà)',
                                        'Đinh FG (sân cỏ tự nhiên)' => 'Đinh FG (sân cỏ tự nhiên)'
                                    ], $product->field_type, ['class' => 'form-control', 'id' => 'field_type', 'placeholder' => '--- Chọn loại đinh ---']) !!}
                                    @error('field_type')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="product-section-card">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-section-title">Chọn màu</div>
                                <div class="selection-group mb-3">
                                    @foreach ($colors as $color)
                                    <div class="form-group mb-0">
                                        {!! Form::checkbox('color[]', $color->id, in_array($color->id,
                                        $product->colors->pluck('id')->toArray()), ['id' => $color->id]) !!}
                                        <label for="{{$color->id}}" class="box-color my-0"
                                            style="background:{{$color->code}}">{{$color->name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="product-section-title">Chọn size giày</div>
                                <div class="selection-group mb-0">
                                    @foreach ($configs as $config)
                                    <div class="form-group mb-0">
                                        {!! Form::checkbox('config[]', $config->id, in_array($config->id, $product->configs->pluck('id')->toArray()), ['id' => 'config'.$config->id]) !!}
                                        {!! Form::label('config'.$config->id, $config->memory, ['class' => 'box-config my-0']) !!}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="variant-editor-card p-3 mb-4">
                        <div class="variant-editor-head">
                            <label class="font-weight-bold mb-0">Tồn kho và giá theo màu + size</label>
                            <p class="variant-editor-note">Bỏ chọn màu hoặc size để ẩn biến thể không dùng.</p>
                        </div>
                        <div class="variant-editor-wrap">
                            <table class="table table-sm mb-0" id="variant-matrix-table">
                                <thead>
                                    <tr>
                                        <th style="width: 22%;">Màu</th>
                                        <th style="width: 14%;">Size</th>
                                        <th style="width: 18%;">Giá</th>
                                        <th style="width: 14%;">Giảm giá %</th>
                                        <th style="width: 18%;">Giá sau giảm</th>
                                        <th style="width: 14%;">Tồn kho</th>
                                    </tr>
                                </thead>
                                <tbody id="variant-matrix-body">
                                    @foreach ($product->colors as $selectedColor)
                                        @foreach ($product->configs as $selectedConfig)
                                            @php
                                                $variantKey = $selectedColor->id . '_' . $selectedConfig->id;
                                                $variant = $variants->get($variantKey);
                                            @endphp
                                            <tr data-variant="{{ $variantKey }}">
                                                <td>{{ $selectedColor->name }}</td>
                                                <td>{{ $selectedConfig->memory ?: $selectedConfig->name }}</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm price-format" 
                                                    name="variant_price[{{ $selectedColor->id }}][{{ $selectedConfig->id }}]"
                                                    value="{{ $variant ? number_format($variant->price, 0, '', ',') : number_format($product->new_price, 0, '', ',') }}">
                                                </td>
                                                <td>
                                                    <input type="number" min="0" max="100" class="form-control form-control-sm"
                                                        name="variant_discount[{{ $selectedColor->id }}][{{ $selectedConfig->id }}]"
                                                        value="{{ $variant ? (int) $variant->discount : 0 }}" placeholder="0-100%">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm variant-total-display" 
                                                        readonly value="0 VNĐ">
                                                </td>
                                                <td>
                                                    <input type="number" min="0" class="form-control form-control-sm"
                                                        name="variant_stock[{{ $selectedColor->id }}][{{ $selectedConfig->id }}]"
                                                        value="{{ $variant ? $variant->stock : 0 }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="product-section-card">
                        <div class="product-section-title">Hình ảnh và hiển thị</div>
                        <div class="row align-items-start">
                            <div class="col-lg-3">
                                <label for="formFile" class="form-label"><b>Ảnh đại diện SP (1 ảnh)</b></label>
                                <input type="file" name="file" id="file_upload" onchange="chooseFile(this)">
                                <div class="product-main-image mt-2">
                                    <img src="{{asset($product->thumb_main)}}" alt="" id="image" class="img-rounded" width="160"
                                        height="160">
                                </div>
                                @error('file')
                                <small class="text-danger d-block">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="col-lg-5">
                                <label class="form-label"><b>Ảnh chi tiết SP (1-6 ảnh)</b></label>
                                <div id="detail-images-wrapper" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    @php
                                        $existingThumbs = !empty($thumb_detail) && is_array($thumb_detail) ? $thumb_detail : [];
                                    @endphp
                                    @for ($i = 1; $i <= 6; $i++)
                                        @php
                                            $thumbPath = isset($existingThumbs[$i-1]) ? $existingThumbs[$i-1] : '';
                                        @endphp
                                        <div class="image-upload-box" id="box-{{$i}}" style="width: 80px; height: 80px; border: 2px dashed #ccc; border-radius: 4px; position: relative; display: flex; align-items: center; justify-content: center; cursor: pointer; background: #f8f9fa;">
                                            @if($thumbPath)
                                                <div class="add-icon" style="display: none; color: #999; font-size: 32px; font-weight: 300; line-height: 1;">+</div>
                                                <img id="preview-img-{{$i}}" src="{{ asset($thumbPath) }}" style="display: block; width: 100%; height: 100%; object-fit: cover; border-radius: 4px; position: absolute; top: 0; left: 0;">
                                                <div class="remove-btn" id="remove-btn-{{$i}}" onclick="removeSingleImage(event, {{$i}})" style="display: flex; position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 16px; height: 16px; align-items: center; justify-content: center; font-size: 10px; cursor: pointer; font-weight: bold; line-height: 1; z-index: 10;">×</div>
                                                <input type="hidden" name="existing_files[]" id="existing-file-{{$i}}" value="{{ $thumbPath }}">
                                            @else
                                                <div class="add-icon" style="color: #999; font-size: 32px; font-weight: 300; line-height: 1;">+</div>
                                                <img id="preview-img-{{$i}}" src="" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 4px; position: absolute; top: 0; left: 0;">
                                                <div class="remove-btn" id="remove-btn-{{$i}}" onclick="removeSingleImage(event, {{$i}})" style="display: none; position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 16px; height: 16px; align-items: center; justify-content: center; font-size: 10px; cursor: pointer; font-weight: bold; line-height: 1; z-index: 10;">×</div>
                                            @endif
                                            <input type="file" name="files[]" id="file-input-{{$i}}" accept="image/*" style="display: none;" onchange="previewSingleImage(this, {{$i}})">
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="pt-lg-4 mt-lg-3">
                                    <input type="checkbox" id="featured_products" {{$product->status=1?'checked':''}}
                                    name="featured_products">
                                    <label for="featured_products" class="m-0"><b>Hiện ở danh mục sản phẩm nổi bật</b></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('des_quick', 'Mô tả nhanh',['class' => 'font-weight-bold']) !!}
                        {!! Form::textarea('des_quick', $product->desc_quick, ['class' => 'form-control edit' , 'id' =>
                        'textarea','rows' => '8']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        {!! Form::label('des_detail', 'Mô tả chi tiết sản phẩm',['class' => 'font-weight-bold']) !!}
                        {!! Form::textarea('des_detail', $product->desc_detail, ['class' => 'form-control edit' , 'id'
                        =>
                        'textarea','rows' => '15']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::select('cat_id', collect($categoryOptions)->mapWithKeys(function ($value) {
                return [$value['id'] => str_repeat('|--- ',$value['lever']).$value['name']];
                }), $product->cat_id, ['class' => 'form-control' , 'id'
                =>
                'cat','placeholder' => 'Chọn danh mục']) !!}
                @error('cat_id')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {{ Form::label('status', 'Trạng thái', ['class' => 'font-weight-bold']) }}
                <div class="form-check">
                    {{ Form::radio('status', 0, $status0, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios1']) }}
                    {{ Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) }}
                </div>
                <div class="form-check">
                    {{ Form::radio('status', 1, $status1, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios2']) }}
                    {{ Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) }}
                </div>
            </div>

            <button type="submit" class="btn btn-success mb-2">Cập nhật</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    (function () {
        const colorCheckboxes = document.querySelectorAll('input[name="color[]"]');
        const configCheckboxes = document.querySelectorAll('input[name="config[]"]');
        const matrixBody = document.getElementById('variant-matrix-body');

        function selectedColors() {
            return Array.from(colorCheckboxes).filter(item => item.checked).map(item => ({
                id: item.value,
                name: document.querySelector('label[for="' + item.id + '"]')?.innerText || ('Màu ' + item.value)
            }));
        }

        function selectedConfigs() {
            return Array.from(configCheckboxes).filter(item => item.checked).map(item => {
                const label = document.querySelector('label[for="' + item.id + '"]');
                return {
                    id: item.value,
                    name: label ? label.innerText.trim() : ('Size ' + item.value)
                };
            });
        }

        function renderMatrix() {
            const colors = selectedColors();
            const configs = selectedConfigs();

            if (!colors.length || !configs.length) {
                matrixBody.innerHTML = '<tr><td colspan="6" class="variant-empty-state">Chọn màu và size để khai báo biến thể.</td></tr>';
                return;
            }

            let html = '';
            
            colors.forEach(color => {
                configs.forEach(config => {
                    html += `
                        <tr>
                            <td>${color.name}</td>
                            <td>${config.name}</td>
                            <td>
                                <input type="text" class="form-control form-control-sm price-format" 
                                name="variant_price[${color.id}][${config.id}]" 
                                placeholder="Giá bán">
                            </td>
                            <td>
                                <input type="number" min="0" max="100" class="form-control form-control-sm" 
                                    name="variant_discount[${color.id}][${config.id}]" 
                                    value="" placeholder="0-100%">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm variant-total-display" 
                                    readonly value="0 VNĐ">
                            </td>
                            <td>
                                <input type="number" min="0" class="form-control form-control-sm" 
                                    name="variant_stock[${color.id}][${config.id}]" 
                                    value="0" placeholder="Tồn kho">
                            </td>
                        </tr>
                    `;
                });
            });
            matrixBody.innerHTML = html;

            bindVariantTotalPriceHandlers(matrixBody);
        }

        function bindVariantTotalPriceHandlers(scope) {
            const rows = scope.querySelectorAll('tr');
            rows.forEach(row => {
                const priceInput = row.querySelector('input[name^="variant_price["]');
                const discountInput = row.querySelector('input[name^="variant_discount["]');
                const totalDisplay = row.querySelector('.variant-total-display');

                if (!priceInput || !discountInput || !totalDisplay) {
                    return;
                }

                const recalc = () => {
                const basePrice = Math.max(0, Number(priceInput.value.replace(/,/g, '')) || 0);
                const discountPercent = Math.min(100, Math.max(0, Number(discountInput.value) || 0));
                const finalPrice = Math.round(basePrice * (1 - discountPercent / 100));
                totalDisplay.value = finalPrice.toLocaleString('vi-VN') + ' VNĐ';
            };

            priceInput.addEventListener('input', function() {
                let val = this.value.replace(/\D/g, '');
                if (val) {
                    this.value = parseInt(val, 10).toLocaleString('en-US');
                } else {
                    this.value = '';
                }
                recalc();
            });
            discountInput.addEventListener('input', recalc);
            recalc();
            });
        }

        colorCheckboxes.forEach(item => item.addEventListener('change', renderMatrix));
        configCheckboxes.forEach(item => item.addEventListener('change', renderMatrix));

        bindVariantTotalPriceHandlers(matrixBody);
    })();

    document.querySelectorAll('.image-upload-box').forEach(box => {
        box.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) return;
            this.querySelector('input[type="file"]').click();
        });
    });

    window.previewSingleImage = function(input, index) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img-' + index).src = e.target.result;
                document.getElementById('preview-img-' + index).style.display = 'block';
                document.getElementById('remove-btn-' + index).style.display = 'flex';
                document.getElementById('box-' + index).querySelector('.add-icon').style.display = 'none';
                
                // If they replace an existing image, we remove the existing file input so it doesn't get submitted as existing
                const existingFile = document.getElementById('existing-file-' + index);
                if(existingFile) existingFile.remove();
            }
            reader.readAsDataURL(input.files[0]);
        }
    };

    window.removeSingleImage = function(e, index) {
        e.stopPropagation();
        document.getElementById('file-input-' + index).value = '';
        document.getElementById('preview-img-' + index).src = '';
        document.getElementById('preview-img-' + index).style.display = 'none';
        document.getElementById('remove-btn-' + index).style.display = 'none';
        document.getElementById('box-' + index).querySelector('.add-icon').style.display = 'block';
        
        // Remove existing file input if they click remove on an existing image
        const existingFile = document.getElementById('existing-file-' + index);
        if(existingFile) existingFile.remove();
    };
</script>
@endsection