@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách trang</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary ml-1">
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên trang</th>
                        <th scope="col">Slug</th>
                        <th scope="col" class="text-center">Người tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($pages as $page)
                    <tr>
                        <td scope="row">{{++$i}}</td>
                        <td><a href="{{route('admin.page.edit',$page)}}" class="font-weight-bold">{{$page->name}}</a>
                        </td>
                        <td>{{$page->slug}}</td>
                        <td class="text-center">
                            @if($page->users)
                                <small><b>{{$page->users->name}}</b></small>
                                <br>
                                @if(!empty($page->users->roles) && isset($page->users->roles[0]))
                                    <p class="bg-secondary text-white rounded px-1 text-center d-inline-block mb-0">
                                        {{$page->users->roles[0]['name']}}</p>
                                @else
                                    <p class="bg-secondary text-white rounded px-1 text-center d-inline-block mb-0">
                                        Chưa phân vai trò</p>
                                @endif
                            @else
                                <small><b>Hệ thống / Đã xóa</b></small>
                            @endif
                        </td>

                        <td>{!!$page->status = 0?'<span class="badge badge-warning">Chờ duyệt</span>':'<span
                                class="badge badge-success">Công khai</span>'!!}</td>
                        <td>{{$page->created_at->format('d/m/Y | H:i')}}</td>
                        <td>
                            <a href="{{route('admin.page.edit',$page)}}"
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{route('admin.page.delete',$page)}}"
                                class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection