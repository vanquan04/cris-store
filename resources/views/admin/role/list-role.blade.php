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
            <h5 class="m-0 ">Danh sách vai trò</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="">
                    <option>Chọn</option>
                    <option>Tác vụ 1</option>
                    <option>Tác vụ 2</option>
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
                        <th scope="col">Vai trò</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @if (!empty($roles))
                    @foreach ($roles as $role)
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td scope="row">{{$i++}}</td>
                        <td><a href="{{url('admin/role/edit/'.$role->id)}}">{{$role->name}}</a></td>
                        <td>{!!$role->description!!}</td>
                        <td>{{$role->created_at}}</td>
                        <td>
                            <a href="{{url('admin/role/edit/'.$role->id)}}"
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{url('admin/role/delete/'.$role -> id)}}"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa quyền này?')"
                                class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i class="fa fa-trash"></i>
                            </a>
                        </td>
                        @endforeach
                        @else
                        <p class="alert alert-danger">Hiện không tồn tại vai trò nào!</p>
                        @endif
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection