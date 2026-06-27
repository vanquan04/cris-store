@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{session('color')?session('color'):'alert-success'}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Thêm mới vai trò</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'role.addHandle','method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Tên vai trò') !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control','id' => 'name']) !!}
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Mô tả') !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control','id' =>
                'description','rows' => '3'])
                !!}
                @error('description')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <strong>Vai trò này có quyền gì?</strong>
            <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn
                quyền.</small>
            <!-- List Permission  -->
            @php
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
            @foreach($permissions as $moduleName => $action)
            @php
                $displayName = isset($moduleLabels[$moduleName]) ? 'Quản lý ' . $moduleLabels[$moduleName] : 'Module ' . $moduleName;
                if($moduleName == 'dashboard') $displayName = 'Dashboard';
            @endphp
            <div class="card my-4 border">
                <div class="card-header">
                    {!! Form::checkbox('', '', '', ["class" => "check-all","id" => $moduleName]) !!}
                    {!! html_entity_decode(Form::label($moduleName, "<strong>".$displayName."</strong>", ['class' =>
                    'm-0'])) !!}
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($action as $value)
                        <div class="col-md-3">
                            {!! Form::checkbox('permission_id[]',$value->id, '', ['class' => 'permission','id'
                            =>$value->slug]) !!}
                            {!! Form::label($value->slug, $value->name) !!}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            <input type="submit" name="btn-add" class="btn btn-primary" value="Thêm mới">
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.check-all').click(function () {
        $(this).closest('.card').find('.permission').prop('checked', this.checked)
      })
</script>
@endsection