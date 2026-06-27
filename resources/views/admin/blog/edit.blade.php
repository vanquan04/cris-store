@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật bài viết
        </div>
        <div class="card-body">
            {!! Form::open(['route'=>['post.update',$post->id], 'method' => 'POST','enctype' =>
            'multipart/form-data'])
            !!}
            @csrf
            <div class="form-group">
                {!! Form::label('name', 'Tiêu đề') !!}
                {!! Form::text('name', $post->name, ['class' => 'form-control']) !!}
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="slug"> Slug(*) <small class="text-success"><b class="autofill-trigger">[Tự động
                            điền]</b></small></label>
                {!! Form::text('slug', $post->slug, ['class' => 'form-control' , 'id' => 'slug']) !!}
                @error('slug')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="col-md-3 p-0">
                <label for="formFile" class="form-label"><b>Ảnh bài viết</b></label>
                <input type="file" name="file" id="file_upload" onchange="chooseFile(this)">
                <img src="{{asset($post->thumb_main)}}" alt="" id="image" class="img-rounded my-2 rounded" width="220"
                    height="160">
                @error('file')
                <small class="text-danger d-block">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('content-demo', 'Nội dung demo') !!}
                {!! Form::text('content-demo', $post->content_demo, ['class' => 'form-control']) !!}
                @error('content-demo')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('content', 'Nội dung trang') !!}
                {!! Form::textarea('content', $post->content, ['class' => 'form-control edit', 'cols' => 30, 'rows' =>
                10]) !!}
                @error('content')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::select('cat_id', collect($categoryOptions)->mapWithKeys(function ($value) {
                return [$value['id'] => str_repeat('|--- ',$value['lever']).$value['name']];
                }), $post->cat_parent, ['class' => 'form-control' , 'id' =>
                'cat','placeholder' => 'Chọn danh mục']) !!}
                @error('cat_id')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Trạng thái', ['class' => 'font-weight-bold']) !!}
                <div class="form-check">
                    {!! Form::radio('status', 0, $post->status == 0, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios1']) !!}
                    {!! Form::label('exampleRadios1', 'Chờ duyệt', ['class' => 'form-check-label']) !!}
                </div>
                <div class="form-check">
                    {!! Form::radio('status', 1, $post->status == 1, ['class' => 'form-check-input', 'id' =>
                    'exampleRadios2']) !!}
                    {!! Form::label('exampleRadios2', 'Công khai', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            {!! Form::submit('Cập nhật', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection