@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <style>
        .support-status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
        }

        .support-status-new {
            background: #2563eb;
            color: #ffffff;
        }

        .support-status-processing {
            background: #f59e0b;
            color: #1f2937;
        }

        .support-status-resolved {
            background: #16a34a;
            color: #ffffff;
        }

        .support-status-unknown {
            background: #4b5563;
            color: #ffffff;
        }
    </style>
    @if (session('status'))
    <div class="{{session('color')}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif

    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Danh sách yêu cầu hỗ trợ</h5>
            <div class="d-flex align-items-center">
                <span class="badge badge-danger mr-3">Tổng: {{ $totalSubscribers }} yêu cầu</span>
                <form action="#" class="d-flex">
                    <input type="text" class="form-control form-search" placeholder="Tìm kiếm..." 
                           value="{{$keyword}}" name="keyword">
                    <input type="submit" value="Tìm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Tài khoản</th>
                        <th scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Loại yêu cầu</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Nội dung</th>
                        <th scope="col">Ngày gửi</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($subscribers->total() > 0)
                    @php $temp = 0; @endphp
                    @foreach ($subscribers as $subscriber)
                    @php $temp++; @endphp
                    <tr>
                        <th scope="row">{{$temp}}</th>
                        <td>
                            <strong>{{ $subscriber->name }}</strong>
                        </td>
                        <td>
                            @if (!empty($subscriber->matched_user))
                                <span class="badge badge-success">{{ $subscriber->matched_user->name }}</span>
                            @else
                                <span class="badge badge-secondary">Khách vãng lai</span>
                            @endif
                        </td>
                        <td>
                            <a href="mailto:{{ $subscriber->email }}">{{ $subscriber->email }}</a>
                        </td>
                        <td>{{ $subscriber->phone ?? 'N/A' }}</td>
                        <td>
                            @if (!$hasRequestTypeColumn || !isset($subscriber->request_type))
                                <span class="badge badge-light">Chưa cập nhật DB</span>
                            @elseif ($subscriber->request_type == 'return_exchange')
                                <span class="badge badge-info">Đổi trả</span>
                            @elseif ($subscriber->request_type == 'complaint')
                                <span class="badge badge-warning">Khiếu nại</span>
                            @else
                                <span class="badge badge-primary">Cần hỗ trợ</span>
                            @endif
                        </td>
                        <td>
                            @if (!$hasStatusColumn)
                                <span class="support-status-badge support-status-new">Mới</span>
                            @elseif (empty($subscriber->status) || $subscriber->status == 'new')
                                <span class="support-status-badge support-status-new">Mới</span>
                            @elseif ($subscriber->status == 'processing')
                                <span class="support-status-badge support-status-processing">Đang xử lý</span>
                            @elseif ($subscriber->status == 'resolved')
                                <span class="support-status-badge support-status-resolved">Đã xong</span>
                            @else
                                <span class="support-status-badge support-status-unknown">Không xác định</span>
                            @endif
                        </td>
                        <td style="max-width: 280px; white-space: normal;">
                            @if ($hasSupportContentColumn && isset($subscriber->support_content))
                                {{ \Illuminate\Support\Str::limit($subscriber->support_content, 140, '...') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $subscriber->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.subscriber.detail', $subscriber->id) }}"
                               class="btn btn-primary btn-sm rounded-0 text-white mb-1"
                               title="Xem chi tiết">
                                <i class="fa fa-eye"></i>
                            </a>
                            @if ($hasStatusColumn)
                                <form action="{{ route('admin.subscriber.status', $subscriber->id) }}" method="POST" class="mb-1">
                                    @csrf
                                    <div class="input-group input-group-sm" style="min-width: 160px;">
                                        <select name="status" class="form-control">
                                            <option value="new" {{ $subscriber->status == 'new' ? 'selected' : '' }}>Mới</option>
                                            <option value="processing" {{ $subscriber->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                            <option value="resolved" {{ $subscriber->status == 'resolved' ? 'selected' : '' }}>Đã xong</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="submit">Lưu</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            <a href="{{url('admin/subscriber/delete/'.$subscriber->id)}}"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                               class="btn btn-danger btn-sm rounded-0 text-white">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10" class="text-center alert alert-danger">
                            Chưa có yêu cầu hỗ trợ nào!
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{$subscribers->links()}}
        </div>
    </div>
</div>
@endsection
