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
        background: rgba(0, 0, 0, 0.8);
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

    #eye i, #eyeConfirm i {
        padding-right: 0;
        cursor: pointer;
    }

    .form-submit {
        background: transparent;
        border: 1px solid #f5f5f5;
        color: #fff;
        width: 100%;
        text-transform: uppercase;
        padding: 6px 10px;
        transition: 0.25s ease-in-out;
        margin-top: 30px;
    }

    .form-submit:hover {
        border: 1px solid #54a0ff;
    }

    .error {
        color: #ff6b6b;
    }

    .icon {
        padding: 6px 0px;
    }

    .remember {
        color: white;
    }
</style>
@section('content')
<section id="myContent-user">
    <div class="container">
        <div id="wrapper-login">
            {!! Form::open(['route' => 'client.register.handle', 'method' => 'POST', 'id' => 'form-login']) !!}
            @csrf
            <h1 class="form-heading">Đăng kí</h1>
            <div class="form-group">
                <i class="far fa-user icon"></i>
                {!! Form::text('name', old('name'), ['class' => 'form-input','placeholder' => 'Họ và tên']) !!}
            </div>
            @error('name')
            <small class="text-danger d-block mb-2">{{$message}}</small>
            @enderror
            <div class="form-group">
                <i class="far fa-user icon"></i>
                {!! Form::text('username', old('username'), ['class' => 'form-input','placeholder' => 'Tên đăng nhập']) !!}
            </div>
            @error('username')
            <small class="text-danger d-block mb-2">{{$message}}</small>
            @enderror
            <div class="form-group">
                <i class="fas fa-envelope icon"></i>
                {!! Form::email('email', old('email'), ['class' => 'form-input','placeholder' => 'Email']) !!}
            </div>
            @error('email')
            <small class="text-danger d-block mb-2">{{$message}}</small>
            @enderror
            <div class="form-group">
                <i class="fas fa-phone icon"></i>
                {!! Form::text('phone', old('phone'), ['class' => 'form-input','placeholder' => 'Số điện thoại (0xxxxxxxxx)']) !!}
            </div>
            @error('phone')
            <small class="text-danger d-block mb-2">{{$message}}</small>
            @enderror
            <div class="form-group">
                <i class="fas fa-key"></i>
                {!! Form::password('password', ['class' => 'form-input','placeholder' => 'Mật khẩu']) !!}
                <div id="eye">
                    <i class="far fa-eye icon"></i>
                </div>
            </div>
            @error('password')
            <small class="text-danger d-block mb-2">{{$message}}</small>
            @enderror
            <div class="form-group">
                <i class="fas fa-key"></i>
                {!! Form::password('password_confirmation', ['class' => 'form-input','placeholder' => 'Xác nhận mật khẩu'])!!}
                <div id="eyeConfirm">
                    <i class="far fa-eye icon p-0"></i>
                </div>
            </div>
            @error('password_confirmation')
            <small class="text-danger d-block mb-2">{{$message}}</small>
            @enderror

            {!! Form::submit('Đăng kí', ['class' => 'form-submit mb-2','name' => 'btn-submit']) !!}
            <div class="support d-flex justify-content-between mt-3">
                <p class="text-white">Bạn đã có tài khoản?</p> <a href="{{route('client.login')}}"
                    class="text-success">Đăng nhập ngay!</a>
            </div>
            {!! Form::close() !!}
        </div>
</section>
<script>
    $(document).ready(function() {
        $('#eye, #eyeConfirm').click(function() {
            $(this).toggleClass('open');
            $(this).children('i').toggleClass('fa-eye-slash fa-eye');
            if ($(this).hasClass('open')) {
                $(this).prev().attr('type', 'text');
            } else {
                $(this).prev().attr('type', 'password');
            }
        });
    });
</script>
@endsection