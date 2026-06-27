@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{session('color')}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif

    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-start align-items-center" style="gap: 20px;">
            <h5 class="m-0 py-1" style="white-space: nowrap;">Danh sách khách hàng</h5>
            <div class="form-search">
                <form action="#" class="d-flex align-items-center" style="gap: 6px;">
                    <select name="group_id" class="form-control" style="height: 38px; width: 150px;" onchange="this.form.submit()">
                        <option value="">Tất cả các nhóm</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ $groupId == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                        @endforeach
                    </select>
                    @if(request()->has('status'))
                    <input type="hidden" name="status" value="{{ request()->input('status') }}">
                    @endif
                    <input type="text" class="form-control form-search" placeholder="Tìm kiếm..." 
                           value="{{$keyword}}" name="keyword" style="height: 38px; width: 140px;">
                    <input type="submit" value="Tìm" class="btn btn-primary" style="height: 38px;">
                    <a href="{{ route('admin.customer_group.list') }}" class="btn btn-info" style="height: 38px; display: inline-flex; align-items: center; white-space: nowrap;"><i class="fas fa-layer-group mr-1"></i> Quản lý nhóm</a>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">
                    Đang hoạt động<span class="text-muted">({{$numActive}})</span>
                </a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">
                    Đã xóa<span class="text-muted">({{$numTrash}})</span>
                </a>
            </div>
            <form action="{{url('admin/customer/action')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act">
                        <option>Chọn</option>
                        @foreach($list_act as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">HD</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Loại</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Nhóm</th>
                            <th scope="col" class="text-right">Tổng tiền</th>
                            <th scope="col" class="text-center">Lần mua</th>
                            <th scope="col" class="text-center">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($customers->total() > 0)
                        @php $temp = 0; @endphp
                        @foreach ($customers as $customer)
                        @php $temp++; @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{$customer->id}}">
                            </td>
                            <th scope="row">{{$temp}}</th>
                            <td>
                                @if($status == 'active')
                                <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-success btn-sm rounded-0 text-white mr-1" type="button" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-edit"></i></a>
                                <a href="{{ url('admin/customer/delete/' . $customer->id) }}" onclick="return confirm('Bạn có chắc chắn muốn vô hiệu hóa khách hàng này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Vô hiệu hóa"><i class="fa fa-trash"></i></a>
                                @else
                                <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-warning btn-sm rounded-0 text-white mb-1 mr-1" type="button" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-edit"></i></a>
                                <a href="{{ url('admin/customer/restore/' . $customer->id) }}" class="btn btn-success btn-sm rounded-0 text-white mb-1 mr-1" type="button" data-toggle="tooltip" data-placement="top" title="Kích hoạt"><i class="fa fa-undo"></i></a>
                                <a href="{{ url('admin/customer/forcedelete/' . $customer->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn khách hàng này?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Xóa vĩnh viễn"><i class="fa fa-trash-alt"></i></a>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $customer->name }}</strong>
                                <div class="small text-muted" style="font-size: 11px;">@username: {{ $customer->username }}</div>
                                <div class="small text-muted" style="font-size: 11px;">Email: {{ $customer->email ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <span class="badge badge-secondary" style="font-size: 11px;">Thành viên</span>
                            </td>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                            <td>
                                @if($customer->group)
                                    @if($customer->group->id == 2)
                                        <span class="badge badge-success text-uppercase" style="font-size: 11px;"><i class="fas fa-crown"></i> {{ $customer->group->name }}</span>
                                    @elseif($customer->group->id == 3)
                                        <span class="badge badge-warning text-uppercase" style="font-size: 11px;"><i class="fas fa-handshake"></i> {{ $customer->group->name }}</span>
                                    @else
                                        <span class="badge badge-primary text-uppercase" style="font-size: 11px;">{{ $customer->group->name }}</span>
                                    @endif
                                @else
                                    <span class="badge badge-secondary text-uppercase" style="font-size: 11px;">Mặc định</span>
                                @endif
                            </td>
                            <td class="text-right font-weight-bold text-success">
                                {{ number_format($customer->total_spent, 0, ',', '.') }} đ
                            </td>
                            <td class="text-center">
                                <span class="badge badge-pill badge-info font-weight-bold" style="font-size: 12px; padding: 5px 10px;">
                                    {{ number_format($customer->total_orders, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-pill badge-dark font-weight-bold" style="font-size: 12px; padding: 5px 10px;">
                                    {{ number_format($customer->total_qty, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="12" class="text-center alert alert-danger">
                                Không tìm thấy kết quả nào!
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                {{$customers->links()}}
            </form>
        </div>
    </div>
</div>
@endsection
