@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{ session('color') }} alert">
        <b>{{ session('status') }}</b>
    </div>
    @endif

    <div class="row">
        <!-- Add Group Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm nhóm mới
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customer_group.add') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Tên nhóm <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ví dụ: Khách VIP, Khách Sỉ..." required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Mô tả nhóm</label>
                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Nhập mô tả ngắn cho nhóm khách hàng này...">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Groups List Table -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Danh sách nhóm khách hàng</h5>
                    <a href="{{ route('admin.customer.list') }}" class="btn btn-secondary btn-sm"><i class="fas fa-users"></i> Danh sách khách hàng</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên nhóm</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col" class="text-center">Số lượng khách</th>
                                <th scope="col" class="text-center">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($groups->count() > 0)
                            @php $i = 0; @endphp
                            @foreach($groups as $group)
                            @php $i++; @endphp
                            <tr>
                                <th scope="row">{{ $i }}</th>
                                <td>
                                    <strong>{{ $group->name }}</strong>
                                    @if(in_array($group->id, [1, 2, 3]))
                                    <span class="badge badge-pill badge-info" style="font-size: 10px;">Hệ thống</span>
                                    @endif
                                </td>
                                <td>{{ $group->description ?? 'Không có mô tả' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill badge-primary" style="font-size: 12px; padding: 6px 12px;">
                                        {{ $group->users_count }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.customer_group.edit', $group->id) }}" class="btn btn-success btn-sm rounded-0 text-white mr-1" type="button" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-edit"></i></a>
                                    @if(!in_array($group->id, [1, 2, 3]))
                                    <a href="{{ route('admin.customer_group.delete', $group->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa nhóm này? Các khách hàng trong nhóm sẽ được đưa về Mặc định.')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Xóa"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center alert alert-danger">Không có nhóm nào tồn tại!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
