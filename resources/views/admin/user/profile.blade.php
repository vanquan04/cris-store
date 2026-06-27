@extends('layouts.admin')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-id-card text-primary mr-2"></i>Thông tin cá nhân Admin</h5>
                </div>
                <div class="card-body">
                    @if(session('status_profile'))
                        <div class="alert alert-success">{{ session('status_profile') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.account.update') }}">
                        @csrf
                        <div class="form-group">
                            <label><b>Họ và tên</b></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><b>Email</b></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label><b>Số điện thoại</b></label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="0xxxxxxxxx">
                                @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label><b>Địa chỉ</b></label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Nhập địa chỉ">{{ old('address', $user->address) }}</textarea>
                            @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-group mb-0 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Lưu thông tin</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-key text-danger mr-2"></i>Đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    @if(session('status_password'))
                        <div class="alert alert-success">{{ session('status_password') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.account.password') }}">
                        @csrf
                        <div class="form-group">
                            <label><b>Mật khẩu hiện tại</b></label>
                            <input type="password" name="current_password" class="form-control" required>
                            @error('current_password')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><b>Mật khẩu mới</b></label>
                                <input type="password" name="password" class="form-control" required>
                                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label><b>Xác nhận mật khẩu</b></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                                @error('password_confirmation')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <div class="form-group mb-0 d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-lock mr-1"></i>Cập nhật mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-user-shield text-info mr-2"></i>Thông tin đăng nhập</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><b>Tài khoản:</b> {{ $user->username }}</p>
                    <p class="mb-2"><b>Quyền:</b> {{ $user->isAdmin ? 'Quản trị viên' : 'Người dùng' }}</p>
                    <p class="mb-0 text-muted">Bạn có thể cập nhật thông tin cá nhân và đổi mật khẩu tại đây.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
