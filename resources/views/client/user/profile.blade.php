@extends('layouts.client')
@section('content')
<style>
    #myContent { padding: 30px 0; background: #f7f8fb; min-height: 560px; }
    .profile-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
    }
    .profile-card .card-header {
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .profile-nav .list-group-item {
        border-left: none;
        border-right: none;
        border-color: #f1f5f9;
    }
    .profile-nav .list-group-item.active {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border-color: transparent;
        color: #fff;
    }
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 14px;
    }
    .form-control {
        border-radius: 10px;
        border: 1px solid #d1d5db;
        min-height: 42px;
    }
    .btn-profile {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        color: #fff;
        font-weight: 700;
        border-radius: 10px;
        padding: 10px 16px;
    }
    .btn-profile:hover { color:#fff; filter: brightness(0.98); }
    .subtle-note { font-size: 12px; color: #6b7280; }
</style>
<section id="myContent">
    <div class="container">
        <div class="col-md-12">
            <div class="section" id="breadcrumb-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('home') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Tài khoản</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card profile-card profile-nav">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Tài khoản</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('client.profile') }}" class="list-group-item active">
                            <i class="fas fa-user-edit me-2"></i>Thông tin cá nhân
                        </a>
                        <a href="{{ route('client.cart.myOrder') }}" class="list-group-item">
                            <i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi
                        </a>
                        <a href="{{ route('client.logout') }}" class="list-group-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="card profile-card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Quản lý thông tin tài khoản</h5>
                    </div>
                    <div class="card-body">
                        @if(session('status_profile'))
                        <div class="alert alert-success">
                            {{ session('status_profile') }}
                        </div>
                        @endif

                        @if(session('status_password'))
                        <div class="alert alert-success">
                            {{ session('status_password') }}
                        </div>
                        @endif

                        <div class="section-title">Thông tin cá nhân</div>
                        {!! Form::open(['route' => 'client.profile.update', 'method' => 'POST']) !!}
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><strong>Họ và tên</strong></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                         value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label"><strong>Tên đăng nhập</strong></label>
                                    <input type="text" class="form-control" id="username" 
                                           value="{{ $user->username }}" readonly disabled>
                                    <small class="text-muted">Không thể thay đổi</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label"><strong>Email</strong></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                         value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label"><strong>Số điện thoại</strong></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                         value="{{ old('phone', $user->phone) }}" placeholder="0xxxxxxxxx">
                                    @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label"><strong>Địa chỉ</strong></label>
                                    <textarea class="form-control" id="address" name="address" rows="2" 
                                              placeholder="Nhập địa chỉ của bạn">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-profile">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                        {!! Form::close() !!}

                        <hr class="my-4">

                        <div class="section-title">Đổi mật khẩu</div>
                        <p class="subtle-note mb-3">Để bảo mật tài khoản, vui lòng nhập đúng mật khẩu hiện tại trước khi đổi mật khẩu mới.</p>

                        {!! Form::open(['route' => 'client.profile.password', 'method' => 'POST']) !!}
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label"><strong>Mật khẩu hiện tại</strong></label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label"><strong>Mật khẩu mới</strong></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label"><strong>Xác nhận mật khẩu mới</strong></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-profile">
                                <i class="fas fa-key me-2"></i>Cập nhật mật khẩu
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
