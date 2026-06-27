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
                    Thêm màu sắc
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'product.color.add', 'method' => 'POST']) }}
                    @csrf
                    <div class="form-group">
                        {{ Form::label('name', 'Tên màu sắc (*)') }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{-- {{ Form::label('slug', 'Slug (*)') }} --}}
                        <label for="slug"> Slug(*) <small class="text-success"><b class="autofill-trigger">[Tự động
                                    điền]</b></small></label>
                        {{-- <a class="text-success autofill-trigger"><small><b>[Tự động điền]</b></small></a> --}}
                        {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'id' => 'slug']) !!}
                        @error('slug')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('code', 'Màu sắc') }}
                        {{ Form::input('color', 'code', null, ['class' => 'form-control', 'id' => 'code']) }}
                        @error('code')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="title" for="">Trạng thái (*)</label>
                        <div class="form-check">
                            {!! Form::radio('status', '0', true, ['class' => 'form-check-input', 'id' =>
                            'exampleRadios1']) !!}
                            {!! Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                        </div>
                        <div class="form-check">
                            {!! Form::radio('status', '1', false, ['class' => 'form-check-input', 'id' =>
                            'exampleRadios2']) !!}
                            {!! Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) !!}
                        </div>
                    </div>

                    {{ Form::submit('Thêm mới', ['class' => 'btn btn-danger']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách màu sắc
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên màu</th>
                                <th scope="col">Màu</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Cập nhật gần nhất</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0;
                            @endphp
                            @foreach ($colors as $color)
                            <tr>
                                <th scope="row">{{++$i}}</th>
                                <td>{{$color -> name}}</td>
                                <td> <label for="{{$color->id}}" class="box-color-lable my-0"
                                        style="background:{{$color->code}}"></label>
                                </td>
                                @if ($color -> status == 0)
                                <td><span class="text-badge badge badge-warning">Chờ duyệt</span></td>
                                @else
                                <td><span class="text-badge badge badge-success">Công khai</span></td>
                                @endif
                                <td>{{$color -> updated_at->format('H:i | d/m/Y')}}</td>
                                <td>
                                    <a data-toggle="modal" data-id="{{ $color->id }}" data-target="#exampleModalCenter"
                                        class="btn btn-success btn-edit btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{url('admin/product/col/delete/'.$color -> id)}}"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa màu này?')"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script src="https://code.jquery.com/jquery-2.2.4.js"
    integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script> --}}

<form method="post" id="id_update">
    @csrf
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thông tin màu sắc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Tên màu (*)', ['class' => 'title']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control','id' => 'name_update', 'placeholder' =>
                        'Tên cấu hình']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('slug', 'Slug (*)', ['class' => 'title']) !!}
                        {!! Form::text('slug', null, ['class' => 'form-control','id' => 'slug_update',
                        'placeholder'
                        =>
                        'slug']) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('code', 'Màu sắc') }}
                        {{ Form::input('color', 'code', null, ['class' => 'form-control', 'id' => 'code_update']) }}
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
    
    $.ajax({
        url: "col/edit/" + id,
        method: "POST",
        data: data,
        dataType: "json",
        success: function(data) {
            // alert('oke');
            console.log(data);
            $("#id_update").attr("action", "col/update/" + data.id);
            $("#name_update").val(data.name);
            $("#slug_update").val(data.slug);
            $("#code_update").val(data.code);
            
            if (data.status == 0) {
                $('#status-pending').prop('checked', true);
            } else if (data.status == 1) {
                $('#status-public').prop('checked', true);
            }
            
            $("#creator").val(data.creator);
            
            var createdAt = new Date(data.created_at);
            var formattedCreatedAt = createdAt.toLocaleString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
            var updatedAt = new Date(data.updated_at);
            var formattedUpdatedAt = updatedAt.toLocaleString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
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
    $(".btn-edit").click(function() {
    // alert('oke')
        var id = $(this).attr("data-id");
        updateData(id);
    });
});

</script>
@endsection