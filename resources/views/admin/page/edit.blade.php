@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật trang
        </div>
        <div class="card-body">
            {!! Form::open(['route'=>['admin.page.update',$page], 'method' => 'POST']) !!}
            @csrf
            <div class="form-group">
                {!! Form::label('name', 'Tên trang') !!}
                {!! Form::text('name', $page->name, ['class' => 'form-control']) !!}
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="slug"> Slug(*) <small class="text-success"><b class="autofill-trigger">[Tự động
                            điền]</b></small></label>
                {!! Form::text('slug', $page->slug, ['class' => 'form-control' , 'id' => 'slug']) !!}
                @error('slug')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('title', 'Tiêu đề') !!}
                {!! Form::text('title', $page->title, ['class' => 'form-control']) !!}
                @error('title')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('content', 'Nội dung trang') !!}
                {!! Form::textarea('content', $page->content, ['class' => 'form-control edit', 'cols' => 30, 'rows' =>
                10]) !!}
                @error('content')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Trạng thái', ['class' => 'font-weight-bold']) !!}
                <div class="form-check">
                    {!! Form::radio('status', 0, $page->status == 0, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios1']) !!}
                    {!! Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                </div>
                <div class="form-check">
                    {!! Form::radio('status', 1, $page->status == 1, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios2']) !!}
                    {!! Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            {!! Form::submit('Cập nhật', ['class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection