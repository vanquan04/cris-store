<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/login.css') }}">

    <title>Đăng nhập</title>
</head>

<body>
    <div id="wrapper">
        {!! Form::open(['route' => 'handle.login', 'method' => 'POST', 'id' => 'form-login']) !!}
        @csrf
        <h1 class="form-heading">Đăng nhập</h1>
        <div class="form-group">
            <i class="far fa-user icon"></i>
            {!! Form::text('username', old('username'), ['class' => 'form-input','placeholder' => 'Tên đăng nhập']) !!}
        </div>
        @error('username')
        <small class="text-danger">{{$message}}</small>
        @enderror
        <div class="form-group">
            <i class="fas fa-key"></i>
            {!! Form::password('password', ['class' => 'form-input','placeholder' => 'Mật khẩu']) !!}
            <div id="eye">
                <i class="far fa-eye icon"></i>
            </div>
        </div>
        @error('password')
        <small class="text-danger">{{$message}}</small>
        @enderror

        <div class="form-grou">
            {!! Form::checkbox('remember_me', true, '', ['id' => 'remember_me']) !!}
            {!! Form::label('remember_me', 'Nhớ đăng nhập', ['class' => 'remember m-0']) !!}
        </div>
        {!! Form::submit('Đăng nhập', ['class' => 'form-submit mb-2','name' => 'btn-submit']) !!}
        <div class="support d-flex justify-content-between mt-2">
            <a href="?mod=users&controller=team&action=reset">Quên mật khẩu?</a>
        </div>
        {!! Form::close() !!}
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function() {
        $('#eye').click(function() {
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

</html>