@extends('layouts.admin')
@section('content')

<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm người dùng
        </div>
        <div class="card-body">
            <form action="{{url('admin/user/store')}}" method="POST">
                @csrf
                <div class="form-group">
                    {!! Form::label('name', 'Họ và tên',) !!}
                    {!! Form::text('name', old('name'), ['id' => 'name','class' => 'form-control']) !!}
                    @error('name')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email',) !!}
                    {!! Form::text('email', old('email'), ['id' => 'email','class' => 'form-control']) !!}
                    @error('email')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('username', 'Tài khoản',) !!}
                    {!! Form::text('username', old('username'), ['id' => 'username','class' => 'form-control']) !!}
                    @error('username')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Mật khẩu',) !!}
                    {!! Form::password('password', ['id' => 'password','class' => 'form-control']) !!}
                    @error('password')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Xác nhận mật khẩu',) !!}
                    {!! Form::password('password_confirmation', ['id' =>
                    'password_confirmation','class' => 'form-control']) !!}
                    @error('password_confirmation')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('role', 'Nhóm quyền') !!}
                    @php
                    $options = $roles->pluck('name', 'id')->toArray();
                    @endphp
                    {!! Form::select('roles[]', $options, '', ['id' => 'role','class' =>
                    'form-control','multiple'
                    =>
                    true]) !!}
                </div>


                <button type="submit" value="Thêm mới" name="btn-add" class="btn btn-success">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection()