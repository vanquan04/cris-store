@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('delete_success'))
    <div class="alert-success alert">
        <b>{{session('delete_success')}}</b>
    </div>
    @endif
    @if (session('status'))
    <div class="{{session('color')}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search form-inline">
                <form action="#" class="d-flex">
                    <input type="" class="form-control form-search" placeholder="Bạn tìm ai?" value="{{$keyword}}"
                        name="keyword">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
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
            <form action="{{url('admin/user/action')}}" method="POST">
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
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->total() > 0)
                        @php
                        $temp = 0;
                        @endphp
                        @foreach ($users as $user)
                        <?php $temp++?>
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{$user -> id}}">
                            </td>
                            <th scope="row">{{$temp}}</th>
                            <td> {{$user -> name}}</td>
                            <td>{{$user -> email}}</td>
                            <td>
                                @foreach ($user -> roles as $role)
                                <span><a href="{{route('role.list')}}"
                                        class="badge badge-warning">{{$role->name}}</a></span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{url($url_btn_success.$user -> id)}}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                @if (session('userID')!= $user -> id)
                                <a href="{{url($url_delete.$user -> id)}}"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa admin này?')"
                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <p class="alert alert-danger">Không tìm thấy kết quả nào!</p>
                        @endif
                    </tbody>
                </table>
                {{$users->links()}}
            </form>
        </div>
    </div>
</div>

@endsection()