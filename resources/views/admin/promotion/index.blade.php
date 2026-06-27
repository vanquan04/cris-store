@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="m-0">Danh sách khuyến mãi</h5>
            <a href="{{ route('admin.promotion.create') }}" class="btn btn-primary">Thêm khuyến mãi</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Chiết khấu (%)</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promotions as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->discount_percent }}</td>
                        <td>{{ $p->start_date }} - {{ $p->end_date }}</td>
                        <td>{{ $p->status ? 'Hoạt động' : 'Không hoạt động' }}</td>
                        <td>
                            <a href="{{ route('admin.promotion.edit', $p->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="{{ url('admin/promotion/delete/'.$p->id) }}" class="btn btn-sm btn-danger">Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $promotions->links() }}
        </div>
    </div>
</div>
@endsection
