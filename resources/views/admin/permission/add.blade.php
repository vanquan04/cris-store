@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{session('color')?session('color'):'alert-success'}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm quyền
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'permission.store','method' => 'POST']) !!}
                    @csrf
                    <div class="form-group">
                        {!! Form::label('name', 'Tên quyền') !!}
                        {!! Form::text('name', old('name'), ['class'=>'form-control','id' => 'name']) !!}
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('slug', 'Slug') !!}
                        <small class="form-text text-muted pb-2">Ví dụ: post.add</small>
                        {!! Form::text('slug', old('slug'), ['class'=>'form-control','id' => 'slug']) !!}
                        @error('slug')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Mô tả') !!}
                        {!! Form::textarea('description', old('description'), ['class'=>'form-control','id' =>
                        'description']) !!}
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách quyền
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên quyền</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            $moduleLabels = [
                                'dashboard' => 'Dashboard',
                                'user' => 'Quản trị viên',
                                'role' => 'Vai trò',
                                'permission' => 'Phân quyền',
                                'blog' => 'Bài viết',
                                'product' => 'Sản phẩm',
                                'slider' => 'Slider',
                                'banner' => 'Banner',
                                'page' => 'Trang',
                                'promotion' => 'Khuyến mãi',
                                'chatbox' => 'Chatbox AI',
                                'feedback' => 'Phản hồi',
                                'customer' => 'Khách hàng',
                                'customer_group' => 'Nhóm khách hàng',
                                'subscriber' => 'Người đăng ký',
                                'order' => 'Đơn hàng'
                            ];
                            @endphp
                            @foreach ($permission as $k=>$v)
                            @php
                                $displayName = isset($moduleLabels[$k]) ? 'Quản lý ' . $moduleLabels[$k] : 'Module ' . ucfirst($k);
                                if($k == 'dashboard') $displayName = 'Dashboard';
                            @endphp
                            <tr>
                                <td scope="row"></td>
                                <td><strong class="text-primary">{{$displayName}}</strong></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach ($v as $item)
                            <tr>
                                <td scope="row">{{$i++}}</td>
                                <td>|--- {{$item->name}}</td>
                                <td>{{$item->slug}}</td>
                                <td>
                                    <a href="{{url('admin/permission/update/'.$item -> id)}}"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{url('admin/permission/delete/'.$item -> id)}}"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa admin này?')"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection