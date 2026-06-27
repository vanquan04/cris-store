@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">Sửa khuyến mãi</div>
        <div class="card-body">
            <form action="{{ route('admin.promotion.update', $promotion->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tên khuyến mãi</label>
                    <input type="text" name="name" class="form-control" value="{{ $promotion->name }}" required>
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ $promotion->slug }}" required>
                </div>
                <div class="form-group">
                    <label>Chiết khấu (%)</label>
                    <input type="number" name="discount_percent" class="form-control" min="0" max="100" value="{{ $promotion->discount_percent }}">
                </div>
                <div class="form-group">
                    <label>Ngày bắt đầu</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $promotion->start_date }}">
                </div>
                <div class="form-group">
                    <label>Ngày kết thúc</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $promotion->end_date }}">
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="4">{{ $promotion->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Áp dụng cho danh mục</label>
                    <div class="pl-2">
                        @foreach($categories as $cat)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $cat->id }}" id="cat_{{ $cat->id }}" {{ $promotion->categories->contains($cat->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat_{{ $cat->id }}">{{ $cat->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label>Áp dụng cho sản phẩm (tìm kiếm):</label>
                    <input type="text" id="productSearch" class="form-control mb-2" placeholder="Tìm sản phẩm...">
                    <div id="productList" style="max-height:300px;overflow:auto;border:1px solid #ddd;padding:8px;">
                        @foreach($products as $p)
                        <div class="form-check product-item">
                            <input class="form-check-input" type="checkbox" name="products[]" value="{{ $p->id }}" id="prod_{{ $p->id }}" {{ $promotion->products->contains($p->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="prod_{{ $p->id }}">{{ $p->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="status" class="form-check-input" {{ $promotion->status ? 'checked' : '' }}>
                    <label class="form-check-label">Hoạt động</label>
                </div>
                <button class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('productSearch').addEventListener('input', function(e){
    var q = e.target.value.toLowerCase();
    document.querySelectorAll('#productList .product-item').forEach(function(el){
        var text = el.textContent.toLowerCase();
        el.style.display = text.indexOf(q) !== -1 ? '' : 'none';
    });
});
</script>
@endsection
