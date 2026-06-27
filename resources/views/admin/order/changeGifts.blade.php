@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đổi quà</h5>
            <div class="form-search form-inline">
                <form action="{{route('product.view')}}" method="GET" class="d-flex">
                    <input type="text" name="key" class="form-control form-search mr-1"
                        placeholder="Nhập vào tên sản phẩm">
                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mã phần quà</th>
                        <th scope="col" class="px-5">Ảnh</th>
                        <th scope="col">Tên khách hàng</th>
                        <th scope="col">Point</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($listChangeGift as $item)
                    <tr class="">
                        <td>{{++$i}}</td>
                        <td><b>{{$item->codeGift}}</b></td>
                        <td><img src="{{asset($item ->gifts->thumb)}}" alt="" width="90" height="90"
                                class="d-flex justify-content-center m-0"></td>
                        <td><b>{{$item->users ? $item->users->name : 'Đã xóa / Không tồn tại'}}</b></td>
                        <td class="text-danger">
                            <b>{{$item ->gifts->points}}</b>
                        </td>
                        <td>
                            @if ($item->status == 0)
                            <span class="badge badge-secondary">Chờ đổi</span>
                            @elseif ($item->status == 1)
                            <span class="badge badge-success">Thành công</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.order.changeGifts.check',$item->id)}}"
                                class="btn btn-success btn-sm rounded text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fas fa-check"></i></a>
                            <a href="{{route('admin.order.changeGifts.delete',$item->id)}}"
                                class="btn btn-danger btn-sm rounded text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $products->links() }} --}}
        </div>
    </div>
</div>
@endsection