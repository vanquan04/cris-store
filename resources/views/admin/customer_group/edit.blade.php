@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card col-md-8 offset-md-2">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Chỉnh sửa nhóm khách hàng</h5>
            <a href="{{ route('admin.customer_group.list') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.customer_group.update', $group->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="font-weight-bold">Tên nhóm <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $group->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="description" class="font-weight-bold">Mô tả nhóm</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Nhập mô tả ngắn cho nhóm khách hàng này...">{{ old('description', $group->description) }}</textarea>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success mr-2"><i class="fas fa-save"></i> Lưu thay đổi</button>
                    <a href="{{ route('admin.customer_group.list') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
