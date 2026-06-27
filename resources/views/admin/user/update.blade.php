@extends('layouts.admin')
@section('content')

<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật thông tin
        </div>
        <div class="card-body">
            <form action="{{route('user.update',$user -> id)}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{$user -> name}}">
                    @error('name')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{$user -> email}}" disabled>
                    @error('email')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('role', 'Nhóm quyền') !!}
                    @php
                    $options = $roles->pluck('name', 'id')->toArray();
                    $selectedRoles = $user -> roles -> pluck('id') -> toArray();
                    @endphp
                    {!! Form::select('roles[]', $options, $selectedRoles, ['id' => 'role','class' =>
                    'form-control','multiple'
                    =>
                    true,'size' => 8]) !!}
                </div>

                <div class="form-group">
                    <label for="created_at">Ngày tạo</label>
                    <input class="form-control" type="text" name="created_at" id="created_at"
                        value="{{$user -> created_at}}" disabled>
                    @error('created_at')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="updated_at">Cập nhật mới nhất</label>
                    <input class="form-control" type="text" name="updated_at" id="updated_at"
                        value="{{$user -> updated_at}}" disabled>
                    @error('updated_at')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <button type="submit" value="Cập nhật" name="btn-add" class="btn btn-success">Cập nhật</button>
            </form>
        </div>
    </div>
</div>

@endsection()