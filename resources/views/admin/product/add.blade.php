@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{session('color')?session('color'):'alert-success'}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'product.handle.add','method' => 'POST','id' =>'main-form' ,'files' => true]) !!}
            @csrf
            
            <!-- Section 1: Thông tin cơ bản -->
            <div class="card mb-4 border">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold">1. Thông tin cơ bản</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Tên sản phẩm(*)',['class' => 'font-weight-bold']) !!}
                                {!! Form::text('name', old('name'), ['class' => 'form-control' , 'id' => 'name']) !!}
                                @error('name')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug"> Slug(<small class="text-success"><b class="autofill-trigger">[Tự động
                                            điền]</b></small>) </label>
                                {!! Form::text('slug', old('slug'), ['class' => 'form-control' , 'id' => 'slug']) !!}
                                @error('slug')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('field_type', 'Loại đinh', ['class' => 'font-weight-bold']) !!}
                                {!! Form::select('field_type', [
                                    'Đinh TF (sân cỏ nhân tạo, trong nhà)' => 'Đinh TF (sân cỏ nhân tạo, trong nhà)',
                                    'Đinh FG (sân cỏ tự nhiên)' => 'Đinh FG (sân cỏ tự nhiên)'
                                ], old('field_type'), ['class' => 'form-control', 'id' => 'field_type', 'placeholder' => '--- Chọn loại đinh ---']) !!}
                                @error('field_type')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('cat_id', 'Loại sản phẩm', ['class' => 'font-weight-bold']) !!}
                                {!! Form::select('cat_id', collect($categoryOptions)->mapWithKeys(function ($value) {
                                return [$value['id'] => str_repeat('|--- ',$value['lever']).$value['name']];
                                }), '', ['class' => 'form-control', 'placeholder' => 'Chọn danh mục']) !!}
                                @error('cat_id')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check">
                                {!! Form::checkbox('featured_products', 1, old('featured_products'), ['class' => 'form-check-input', 'id' => 'featured_products']) !!}
                                {!! Form::label('featured_products', 'Sản phẩm có biến thể (màu sắc, size, giá khác nhau)', ['class' => 'form-check-label']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 1.5: Ảnh sản phẩm -->
            <div class="card mb-4 border">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold">Ảnh đại diện sản phẩm</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="file_upload" class="font-weight-bold">Ảnh đại diện SP (1 ảnh)<span class="text-danger">*</span></label>
                                <input type="file" name="file" id="file_upload" accept="image/*" onchange="chooseFile(this)" class="form-control">
                                <img src="{{asset('images/img-thumb.png')}}" alt="" id="image" class="img-rounded my-2" width="120" height="120">
                                @error('file')
                                <small class="text-danger d-block">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">Ảnh chi tiết SP (1-6 ảnh)</label>
                                <div id="detail-images-wrapper" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    @for ($i = 1; $i <= 6; $i++)
                                    <div class="image-upload-box" id="box-{{$i}}" style="width: 60px; height: 60px; border: 2px dashed #ccc; border-radius: 4px; position: relative; display: flex; align-items: center; justify-content: center; cursor: pointer; background: #f8f9fa;">
                                        <div class="add-icon" style="color: #999; font-size: 32px; font-weight: 300; line-height: 1;">+</div>
                                        <img id="preview-img-{{$i}}" src="" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 4px; position: absolute; top: 0; left: 0;">
                                        <input type="file" name="files[]" id="file-input-{{$i}}" accept="image/*" style="display: none;" onchange="previewSingleImage(this, {{$i}})">
                                        <div class="remove-btn" id="remove-btn-{{$i}}" onclick="removeSingleImage(event, {{$i}})" style="display: none; position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 16px; height: 16px; align-items: center; justify-content: center; font-size: 10px; cursor: pointer; font-weight: bold; line-height: 1; z-index: 10;">×</div>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Màu sắc & Hình ảnh -->
            <div class="card mb-4 border">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold">2. Màu sắc & Hình ảnh (Chọn màu và upload nhiều ảnh cho mỗi màu)</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Chọn màu</label>
                        <div class="d-flex flex-wrap" id="color-selector" style="gap: 10px;">
                            @foreach ($colors as $color)
                            <div class="form-check">
                                {!! Form::checkbox('color[]', $color->id, old('color[]'), ['id' => 'color_'.$color->id, 'class' => 'form-check-input color-checkbox']) !!}
                                {!! Form::label('color_'.$color->id, $color->name, ['class' => 'form-check-label box-color', 'style' => 'background:'.$color->code.'; display: inline-block; width: 30px; height: 30px; border-radius: 4px; border: 2px solid transparent; margin-left: 5px;']) !!}
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Color Tabs for Image Upload -->
                    <div class="mt-4" id="color-image-tabs-container" style="display:none;">
                        <ul class="nav nav-tabs" id="colorImageTabs" role="tablist">
                            @foreach ($colors as $color)
                            <li class="nav-item" id="color-tab-item-{{$color->id}}" style="display:none;">
                                <a class="nav-link color-image-tab" id="color-tab-{{$color->id}}" data-toggle="tab" href="#color-panel-{{$color->id}}" role="tab" data-color-id="{{$color->id}}">
                                    <span class="box-color" style="display: inline-block; width: 12px; height: 12px; background: {{$color->code}}; border-radius: 2px; margin-right: 5px;"></span>{{$color->name}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content border p-3" id="colorImageTabsContent">
                            @foreach ($colors as $color)
                            <div class="tab-pane fade" id="color-panel-{{$color->id}}" role="tabpanel">
                                <div class="form-group">
                                    <label class="font-weight-bold">Upload ảnh cho màu <strong>{{$color->name}}</strong></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input color-image-input" id="color-images-{{$color->id}}" 
                                               name="color_images[{{$color->id}}][]" multiple accept="image/*">
                                        <label class="custom-file-label" for="color-images-{{$color->id}}">Chọn ảnh...</label>
                                    </div>
                                    <small class="text-muted d-block mt-2">Tối đa 5 ảnh, định dạng: JPG, PNG, GIF</small>
                                    <div class="color-image-preview mt-3" id="preview-{{$color->id}}" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                        <!-- Preview ảnh sẽ hiển thị ở đây -->
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Size giá -->
            <div class="card mb-4 border">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold">3. Size giá (Chọn nhất khác nhau)</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Chọn size</label>
                        <div class="d-flex flex-wrap" style="gap: 15px;">
                            @foreach ($configs as $config)
                            <div class="form-check">
                                {!! Form::checkbox('config[]', $config->id, old('config[]'), ['id' => 'config'.$config->id, 'class' => 'form-check-input size-checkbox']) !!}
                                {!! Form::label('config'.$config->id, $config->memory, ['class' => 'form-check-label']) !!}
                            </div>
                            @endforeach
                        </div>
                        <small class="text-muted d-block mt-2">Các size đã chọn bên trái là những giá và tồn kho bên cạnh.</small>
                    </div>
                </div>
            </div>

            <!-- Section 4: Giá, giảm giá và tồn kho theo màu + size -->
            <div class="card mb-4 border">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold">4. Giá, giảm giá và tồn kho theo màu + size</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold mb-3">Nhập giá, giảm giá và tồn kho cho từng màu và size giày.</label>
                        
                        <!-- Color Tabs for Variant Data -->
                        <ul class="nav nav-tabs" id="colorVariantTabs" role="tablist">
                            @foreach ($colors as $color)
                            <li class="nav-item" id="variant-tab-item-{{$color->id}}" style="display:none;">
                                <a class="nav-link color-variant-tab" id="variant-tab-{{$color->id}}" data-toggle="tab" href="#variant-panel-{{$color->id}}" role="tab" data-color-id="{{$color->id}}">
                                    <span class="box-color" style="display: inline-block; width: 12px; height: 12px; background: {{$color->code}}; border-radius: 2px; margin-right: 5px;"></span>{{$color->name}}
                                </a>
                            </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="colorVariantTabsContent">
                            @foreach ($colors as $color)
                            <div class="tab-pane fade" id="variant-panel-{{$color->id}}" role="tabpanel">
                                <div class="table-responsive mt-3">
                                    <table class="table table-sm table-bordered variant-data-table" id="variant-table-{{$color->id}}">
                                        <thead style="background: #f8f9fa;">
                                            <tr>
                                                <th style="width: 20%;">Size</th>
                                                <th style="width: 20%;">Giá bán (VNĐ) <span class="text-danger">*</span></th>
                                                <th style="width: 15%;">Giảm giá (%) <span class="text-danger">*</span></th>
                                                <th style="width: 25%;">Giá sau giảm</th>
                                                <th style="width: 20%;">Tồn kho <span class="text-danger">*</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-{{$color->id}}">
                                            <!-- Rows will be generated by JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="alert alert-info mt-3" id="variant-tip">
                        <small><strong>💡 Mẹo:</strong> Bảo chặp giá, tồn kho sang màu khác</small>
                    </div>
                </div>
            </div>

            <!-- Section 5: Mô tả sản phẩm -->
            <div class="card mb-4 border">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold">5. Mô tả sản phẩm</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('des_quick', 'Mô tả nhanh',['class' => 'font-weight-bold']) !!}
                        {!! Form::textarea('des_quick', old('des_quick'), ['class' => 'form-control edit' , 'id' =>
                        'textarea','rows' => '5']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('des_detail', 'Mô tả chi tiết sản phẩm',['class' => 'font-weight-bold']) !!}
                        {!! Form::textarea('des_detail', old('des_detail'), ['class' => 'form-control edit' , 'id' =>
                        'textarea','rows' => '10']) !!}
                    </div>
                </div>
            </div>

            <!-- Section 6: Trạng thái -->
            <div class="card mb-4 border">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold">6. Trạng thái</h6>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        {!! Form::radio('status', 0, true, ['class' => 'form-check-input', 'id' => 'status-draft']) !!}
                        {!! Form::label('status-draft', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                    </div>
                    <div class="form-check">
                        {!! Form::radio('status', 1, false, ['class' => 'form-check-input', 'id' => 'status-publish']) !!}
                        {!! Form::label('status-publish', 'Công khai', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Thêm mới</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<style>
    .box-color {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .box-color:hover {
        transform: scale(1.1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .color-checkbox:checked + .box-color {
        border: 2px solid #333;
        box-shadow: 0 0 8px rgba(0,0,0,0.3);
    }
    
    .color-image-preview img {
        max-width: 80px;
        max-height: 80px;
        border-radius: 4px;
        border: 1px solid #ddd;
        object-fit: cover;
    }
    
    .nav-tabs .nav-link {
        color: #666;
        border: 1px solid transparent;
    }
    
    .nav-tabs .nav-link.active {
        color: #333;
        border-bottom: 2px solid #007bff;
        background: none;
    }
</style>

<script>
(function() {
    const colorCheckboxes = document.querySelectorAll('.color-checkbox');
    const sizeCheckboxes = document.querySelectorAll('.size-checkbox');
    const colorImageTabsContainer = document.getElementById('color-image-tabs-container');
    const colorImageTabs = document.querySelectorAll('.color-image-tab');
    const colorVariantTabs = document.querySelectorAll('.color-variant-tab');
    
    // Show/hide color tabs based on selection
    function updateColorTabs() {
        let hasSelectedColor = false;
        colorCheckboxes.forEach(checkbox => {
            const colorId = checkbox.value;
            const tabItem = document.getElementById(`color-tab-item-${colorId}`);
            const variantTabItem = document.getElementById(`variant-tab-item-${colorId}`);
            
            if (checkbox.checked) {
                tabItem.style.display = 'block';
                variantTabItem.style.display = 'block';
                hasSelectedColor = true;
            } else {
                tabItem.style.display = 'none';
                variantTabItem.style.display = 'none';
            }
        });
        
        colorImageTabsContainer.style.display = hasSelectedColor ? 'block' : 'none';
        
        // Activate first visible tab
        const visibleTab = document.querySelector('.color-image-tab[style*="display"]');
        if (visibleTab) {
            const firstTab = document.querySelector('.color-image-tab:not([style*="display: none"])');
            if (firstTab) {
                firstTab.click();
            }
        }
    }
    
    // Update variant table rows based on selected sizes
    function updateVariantTables() {
        const selectedSizes = Array.from(sizeCheckboxes).filter(cb => cb.checked).map(cb => ({
            id: cb.value,
            name: document.querySelector(`label[for="${cb.id}"]`).innerText.trim()
        }));
        
        colorCheckboxes.forEach(colorCb => {
            if (!colorCb.checked) return;
            
            const colorId = colorCb.value;
            const tbody = document.getElementById(`tbody-${colorId}`);
            
            if (!selectedSizes.length) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-muted text-center py-3">Chọn size để nhập dữ liệu.</td></tr>';
                return;
            }
            
            let html = '';
            selectedSizes.forEach(size => {
                html += `
                    <tr>
                        <td><strong>${size.name}</strong></td>
                        <td>
                            <input type="text" class="form-control form-control-sm price-format" 
                                name="variant_price[${colorId}][${size.id}]" 
                                placeholder="Giá bán">
                        </td>
                        <td>
                            <input type="number" min="0" max="100" class="form-control form-control-sm" 
                                name="variant_discount[${colorId}][${size.id}]" 
                                placeholder="0-100">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm variant-total-display" 
                                readonly value="0 VNĐ">
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control form-control-sm" 
                                name="variant_stock[${colorId}][${size.id}]" 
                                placeholder="Tồn kho">
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;

            bindVariantTotalPriceHandlers(tbody);
        });
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
    
    // Image preview
    document.querySelectorAll('.color-image-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const colorId = this.id.replace('color-images-', '');
            const preview = document.getElementById(`preview-${colorId}`);
            preview.innerHTML = '';
            
            Array.from(this.files).slice(0, 5).forEach(file => {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.maxWidth = '80px';
                    img.style.maxHeight = '80px';
                    img.style.borderRadius = '4px';
                    img.style.border = '1px solid #ddd';
                    img.style.objectFit = 'cover';
                    img.title = file.name;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
            
            if (this.files.length > 5) {
                const warning = document.createElement('span');
                warning.textContent = `+${this.files.length - 5}`;
                warning.style.fontSize = '12px';
                warning.style.color = '#ff6b6b';
                warning.style.alignSelf = 'center';
                preview.appendChild(warning);
            }
        });
    });

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
    };
    
    // Event listeners
    colorCheckboxes.forEach(cb => cb.addEventListener('change', () => {
        updateColorTabs();
        updateVariantTables();
    }));
    
    sizeCheckboxes.forEach(cb => cb.addEventListener('change', updateVariantTables));
    
    // Initialize
    updateColorTabs();
    updateVariantTables();
})();
</script>

@endsection

