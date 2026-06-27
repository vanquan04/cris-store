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
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Chi tiết yêu cầu hỗ trợ #{{ $subscriber->id }}</h5>
            <a href="{{ route('admin.subscriber.list') }}" class="btn btn-secondary btn-sm">Quay lại</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Họ tên:</strong>
                    <div>{{ $subscriber->name }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Email:</strong>
                    <div><a href="mailto:{{ $subscriber->email }}">{{ $subscriber->email }}</a></div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Số điện thoại:</strong>
                    <div>{{ $subscriber->phone ?: 'N/A' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>User tài khoản:</strong>
                    <div>
                        @if (!empty($matchedUser))
                            {{ $matchedUser->name }} (ID: {{ $matchedUser->id }})
                        @else
                            Khách vãng lai
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Loại yêu cầu:</strong>
                    <div>
                        @if (!isset($subscriber->request_type))
                            N/A
                        @elseif ($subscriber->request_type == 'return_exchange')
                            Đổi trả
                        @elseif ($subscriber->request_type == 'complaint')
                            Khiếu nại
                        @else
                            Cần hỗ trợ
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Trạng thái:</strong>
                    <div>
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
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <strong>Nội dung chi tiết:</strong>
                    <div class="border rounded p-3" style="white-space: pre-line;">{{ $subscriber->support_content ?? 'N/A' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Ngày gửi:</strong>
                    <div>{{ $subscriber->created_at ? $subscriber->created_at->format('d/m/Y H:i') : 'N/A' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Cập nhật lần cuối:</strong>
                    <div>{{ $subscriber->updated_at ? $subscriber->updated_at->format('d/m/Y H:i') : 'N/A' }}</div>
                </div>
            </div>

            <hr>

            @if ($hasStatusColumn)
                <form action="{{ route('admin.subscriber.status', $subscriber->id) }}" method="POST" class="form-inline">
                    @csrf
                    <label class="mr-2"><strong>Cập nhật trạng thái:</strong></label>
                    <select name="status" class="form-control mr-2">
                        <option value="new" {{ $subscriber->status == 'new' ? 'selected' : '' }}>Mới</option>
                        <option value="processing" {{ $subscriber->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="resolved" {{ $subscriber->status == 'resolved' ? 'selected' : '' }}>Đã xong</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Lưu trạng thái</button>
                </form>
            @else
                <div class="alert alert-warning mb-0">
                    Chức năng cập nhật trạng thái tạm thời chưa khả dụng vì database chưa chạy migration mới nhất.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
