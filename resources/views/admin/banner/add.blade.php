@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{session('color')?session('color'):'alert-success'}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm banner
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'admin.banner.handle_add', 'method' => 'POST','enctype' =>
            'multipart/form-data']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Tên banner') !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                @error('name')
                <small class="text-danger d-block">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('link', 'Link (URL)') !!}
                {!! Form::text('link', old('link'), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-1 p-0 m-0">
                <div class="form-group">
                    {!! Form::label('sort', 'Thứ tự') !!}
                    {!! Form::number('sort', old('sort'), ['class' => 'form-control', 'min' => '0']) !!}
                </div>
            </div>
            @error('sort')
            <small class="text-danger d-block">{{$message}}</small>
            @enderror
            <div class="col-md-3 p-0">
                {!! Form::label('file', 'Ảnh Slider (1 ảnh)', ['class' => 'form-label']) !!}
                {!! Form::file('file', ['id' => 'file_upload', 'onchange' => 'chooseFile(this)']) !!}
                <img src="{{asset('images/img-thumb.png')}}" class="rounded mt-1" alt="" id="image"
                    class="img-rounded my-2" width="280" height="160">
                @error('file')
                <small class="text-danger d-block mt-1">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('', 'Trạng thái') !!}
                <div class="form-check">
                    {!! Form::radio('status', 0, true, ['id' => 'exampleRadios1', 'class' =>
                    'form-check-input']) !!}
                    {!! Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                </div>
                <div class="form-check">
                    {!! Form::radio('status', 1, false, ['id' => 'exampleRadios2', 'class' =>
                    'form-check-input']) !!}
                    {!! Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            {!! Form::submit('Thêm mới', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection