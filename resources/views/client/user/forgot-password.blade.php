@extends('layouts.client')
<style>
    #myContent-user {
        background: url("https://gooccho.vn/wp-content/uploads/2020/12/mau-thiet-ke-noi-that-phong-khach-biet-thu-dep-2021-11.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    #wrapper-login {
        min-height: 80vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #form-login {
        max-width: 450px;
        background: rgba(0, 0, 0, 0.85);
        flex-grow: 1;
        padding: 30px 30px 40px;
        box-shadow: 0px 0px 17px 2px rgba(255, 255, 255, 0.8);
    }

    .form-heading {
        font-size: 25px;
        color: #f5f5f5;
        text-align: center;
        margin-bottom: 30px;
    }

    .form-group {
        border-bottom: 1px solid #fff;
        margin-top: 15px;
        margin-bottom: 20px;
        display: flex;
    }

    .form-group i {
        color: #fff;
        font-size: 14px;
        padding-top: 5px;
        padding-right: 10px;
    }

    .form-input {
        background: transparent;
        border: 0;
        outline: 0;
        color: white;
        flex-grow: 1;
    }

    .form-input::placeholder {
        color: #f5f5f5;
    }

    .form-submit {
        background: transparent;
        border: 1px solid #54a0ff;
        color: #fff;
        width: 100%;
        text-transform: uppercase;
        padding: 6px 10px;
        transition: 0.25s ease-in-out;
        margin-top: 30px;
    }

    .form-submit:hover {
        background: #54a0ff;
    }

    .error {
        color: #ff6b6b;
    }
</style>
@section('content')
<section id="myContent-user">
    <div class="container">
        <div id="wrapper-login">
            {!! Form::open(['route' => 'client.forgot-password.submit', 'method' => 'POST', 'id' => 'form-login']) !!}
            @csrf
            <h1 class="form-heading"><i class="fas fa-key me-2"></i>Quên mật khẩu</h1>
            
            <div class="alert alert-info text-white" style="background: rgba(84, 160, 255, 0.3); border: none;">
                <small>Vui lòng nhập Email hoặc Số điện thoại để khôi phục mật khẩu</small>
            </div>

            <div class="form-group">
                <i class="fas fa-envelope"></i>
                {!! Form::text('email_or_phone', old('email_or_phone'), ['class' => 'form-input','placeholder' => 'Email hoặc Số điện thoại']) !!}
            </div>
            @error('email_or_phone')
            <small class="text-danger d-block mb-2">{{$message}}</small>
            @enderror

            {!! Form::submit('Gửi yêu cầu', ['class' => 'form-submit mb-2']) !!}
            
            <div class="support d-flex justify-content-between mt-3">
                <a href="{{route('client.login')}}" class="text-success"><i class="fas fa-arrow-left me-1"></i> Quay lại đăng nhập</a>
            </div>
            {!! Form::close() !!}
        </div>
</section>
@endsection
