@extends('layouts.admin')
@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐỔI PHẾ THẢI LẤY QUÀ
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Khách hàng</th>
                        <th scope="col" class="text-center">Khối lượng phế liệu(KG)</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($listChange as $item)
                    <tr>
                        <th class="text-center">{{++$i}}</th>
                        <td class="text-center">
                            <b>{{$item->Users ? $item->Users->name : 'Đã xóa / Không tồn tại'}}</b>
                        </td>
                        <td class="text-center"> {{$item->amount}}</td>
                        <td>
                            @if ($item->status == 0)
                            <span class="badge badge-secondary">Chờ xác minh</span>
                            @elseif ($item->status == 1)
                            <span class="badge badge-success">Đã xác minh</span>
                            @endif
                        </td>
                        <td>{{$item->created_at->format('d/m/Y | H:i')}}</td>
                        <td>
                            <a href="{{route('admin.order.changePoints.check',$item->id)}}"
                                class="btn btn-success btn-sm rounded text-white" type="button" data-toggle="tooltip"
                                data-placement="top"><i class="fas fa-check"></i></a>
                            <a href="{{route('admin.order.changePoints.delete',$item->id)}}"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa yêu cầu này?')"
                                class="btn btn-danger btn-sm rounded text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $orders->links() }} --}}
        </div>
    </div>
</div>
@endsection