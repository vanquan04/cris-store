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
            <h5 class="m-0 ">Danh sách slider</h5>
            <div class="form-search form-inline">
                <form action="{{route('admin.slider.list')}}" method="GET" class="d-flex">
                    <input type="text" name="key" class="form-control form-search mr-1"
                        placeholder="Nhập vào tên sản phẩm">
                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Đang kích hoạt<span
                        class="text-muted">({{$numUsersActive}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Đã vô hiệu hóa<span
                        class="text-muted">({{$numSoftDelete}})</span></a>
            </div>
            <form action="{{route('admin.slider.action')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="act">
                        <option>Chọn</option>
                        @foreach($list_act as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Link</th>
                            <th scope="col">Thứ tự</th>
                            <th class="text-center" scope="col">Người tạo</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i= 0;
                        @endphp
                        @foreach ($sliders as $slider)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{$slider -> id}}">
                            </td>
                            <th scope="row">{{++$i}}</th>
                            <td><img src="{{asset($slider->thumb_slider)}}" class="imgg" data-id="{{ $slider->id }} "
                                    data-toggle="modal" data-target="#exampleModalCenter" alt="" width="80px"></td>
                            <td><a href="" class="link" data-id="{{ $slider->id }}" data-toggle="modal"
                                    data-target="#exampleModalCenter">{{Str::limit($slider->link,
                                    $limit = 20, $end =
                                    '...')}}</a></td>
                            <td>{{$slider->sort}}</td>
                            <td class="text-center">
                                @if($slider->users)
                                    <small><b>{{$slider->users->name}}</b></small>
                                    <br>
                                    @if(!empty($slider->users->roles) && isset($slider->users->roles[0]))
                                        <p class="bg-secondary text-white rounded px-1 text-center d-inline-block mb-0">
                                            {{$slider->users->roles[0]['name']}}</p>
                                    @else
                                        <p class="bg-secondary text-white rounded px-1 text-center d-inline-block mb-0">
                                            Chưa phân vai trò</p>
                                    @endif
                                @else
                                    <small><b>Hệ thống / Đã xóa</b></small>
                                @endif
                            </td>
                            <td>{{$slider->created_at->format('H:i | d/m/Y')}}</td>
                            <td>{!!($slider->status == 0)?'<span class="badge badge-warning">Chờ duyệt</span>':'<span
                                    class="badge badge-success">Công khai</span>'!!}</td>
                            <td>
                                <a href="{{url($url_btn_success.$slider->id)}}"
                                    class="btn btn-success btn-sm rounded text-white" type="button"
                                   data-id="{{ $slider->id }} "
                                    data-toggle="modal" data-target="#exampleModalCenter" title="Edit"><i
                                        class="fa fa-edit"></i></a>

                                <a href="{{url($url_delete.$slider->id)}}"
                                    class="btn btn-danger btn-sm rounded text-white" type="button" data-toggle="tooltip"
                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<form method="post" id="id_update" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thông tin slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Tên slider (*)', ['class' => 'title']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control','id' => 'name_update']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('link', 'Link', ['class' => 'title']) !!}
                        {!! Form::text('link', null, ['class' => 'form-control','id' => 'link_update']) !!}
                    </div>
                    <div class="col-md-3 p-0">
                        <div class="form-group">
                            {!! Form::label('sort', 'Thứ tự') !!}
                            {!! Form::number('sort', old('sort'), ['class' => 'form-control', 'min' =>
                            '0','id'=>'sort_update']) !!}
                        </div>
                    </div>
                    <div class="col-md-4 p-0">
                        {!! Form::label('file', 'Ảnh Slider (1 ảnh)', ['class' => 'form-label']) !!}
                        {!! Form::file('file', ['id' => 'file_upload', 'onchange' => 'chooseFile(this)']) !!}
                        <img src="{{asset('images/img-thumb.png')}}" class="rounded mt-1" alt="" id="image_update"
                            class="img-rounded my-2" width="280" height="160">
                        @error('file')
                        <small class="text-danger d-block my-2">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('', 'Trạng thái (*)', ['class' => 'title']) !!}
                        <div class="d-flex">
                            <div class="col-sm-4 form-check">
                                {!! Form::radio('status', 0, '', ['id' => 'status-pending', 'class' =>
                                'form-check-input']) !!}
                                {!! Form::label('status-pending', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                            </div>
                            <div class="col-sm-4 form-check">
                                {!! Form::radio('status', 1, '', ['id' => 'status-public', 'class' =>
                                'form-check-input']) !!}
                                {!! Form::label('status-public', 'Công khai', ['class' => 'form-check-label']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('creator', 'Người tạo', ['class' => 'title']) !!}
                            {!! Form::text('creator', null, ['class' => 'form-control','id' => 'creator' ,'placeholder'
                            => 'Người tạo',
                            'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            {!! Form::label('created_at', 'Ngày tạo', ['class' => 'title']) !!}
                            {!! Form::text('created_at', null, ['class' => 'form-control','id' => 'created_at',
                            'placeholder' => 'Ngày tạo',
                            'disabled' => 'disabled']) !!}
                        </div>
                        <div class="col-sm-6 form-group">
                            {!! Form::label('updated_at', 'Cập nhật gần nhất', ['class' => 'title']) !!}
                            {!! Form::text('updated_at', null, ['class' => 'form-control','id' => 'updated_at',
                            'placeholder' => 'Cập nhật gần
                            nhất', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    <input type="submit" class="btn btn-success" value="Cập nhật">
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function updateData(id) {
    var data = {
        id: id,
        _token: '{{ csrf_token() }}'
    };
    console.log(data)
    $.ajax({
        url: "edit/" + id,
        method: "POST",
        data: data,
        dataType: "json",
        success: function(data) {
            // alert('oke');
            console.log(data);
            $("#id_update").attr("action", "update/" + data.id);
            $("#name_update").val(data.name);
            $("#link_update").val(data.url);
            $("#sort_update").val(data.sort);
            $('#image_update').attr('src', "{{ asset('/') }}"+data.link);
            if (data.status == 0) {
                $('#status-pending').prop('checked', true);
            } else if (data.status == 1) {
                $('#status-public').prop('checked', true);
            }
            
            $("#creator").val(data.creator);
            
            var createdAt = new Date(data.created_at);
            var formattedCreatedAt = createdAt.toLocaleString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' });
            
            var updatedAt = new Date(data.updated_at);
            var formattedUpdatedAt = updatedAt.toLocaleString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' });
            
            $("#created_at").val(formattedCreatedAt);
            $("#updated_at").val(formattedUpdatedAt);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        },
    });
}

$(document).ready(function() {
    $(".btn-edit,.link,.imgg").click(function() {
        var id = $(this).attr("data-id");
        // console.log(id)
        updateData(id);
    });
});
</script>
@endsection