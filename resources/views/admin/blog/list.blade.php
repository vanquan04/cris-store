@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách bài viết</h5>
            <div class="form-search form-inline">
                <form action="{{route('post.list')}}" method="GET" class="d-flex">
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
            <form action="{{route('post.action')}}" method="POST">
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
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 0;
                        @endphp
                        @foreach ($posts as $post)
                        <tr class="">
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{$post -> id}}">
                            </td>
                            <td>{{++$i}}</td>
                            <td><img src="{{asset($post->thumb_main)}}" alt="" width="80" height="80"></td>
                            <td><a href="{{route('post.edit',$post->id)}}">{{Str::limit($post->name,
                                    $limit = 30, $end =
                                    '...')}}</a></td>
                            <td>{{$post->cat_blog->name}}</td>
                            <td>{{$post->created_at->format('d/m/Y | H:i')}}</td>
                            <td>{!!$post->status = 0?'<span class="badge badge-warning">Chờ duyệt</span>':'<span
                                    class="badge badge-success">Công khai</span>'!!}</td>
                            <td>
                                <a href="{{url($url_btn_success.$post->id)}}"
                                    class="btn btn-success btn-sm rounded text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <a href="{{url($url_delete.$post->id)}}"
                                    class="btn btn-danger btn-sm rounded text-white" type="button" data-toggle="tooltip"
                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->links() }}
            </form>
        </div>
    </div>
</div>
@endsection