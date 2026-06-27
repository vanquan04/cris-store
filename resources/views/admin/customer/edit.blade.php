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

    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Chỉnh sửa thông tin khách hàng</h5>
            <a href="{{ route('admin.customer.list') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.customer.update', $customer->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="username" class="font-weight-bold">Tên tài khoản (Không thể sửa)</label>
                            <input type="text" id="username" class="form-control" value="{{ $customer->username }}" disabled style="background-color: #e9ecef;">
                        </div>

                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $customer->email) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="font-weight-bold">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                        </div>


                        <div class="form-group">
                            <label for="address" class="font-weight-bold">Địa chỉ</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $customer->address) }}">
                        </div>

                        <div class="form-group">
                            <label for="group_id" class="font-weight-bold">Nhóm khách hàng</label>
                            <select name="group_id" id="group_id" class="form-control">
                                <option value="">Chưa phân nhóm</option>
                                @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id', $customer->group_id) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success mr-2"><i class="fas fa-save"></i> Lưu thay đổi</button>
                    <a href="{{ route('admin.customer.list') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
