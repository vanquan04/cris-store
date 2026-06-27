@extends('layouts.client')
@section('content')
<section id="myContent">
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
            color: #f04444;
        }

        .support-status-processing {
            background: #f59e0b;
            color: #1f2937;
        }

        .support-status-resolved {
            background: #16a34a;
            color: #d62020;
        }

        .support-status-unknown {
            background: #4b5563;
            color: #ff2a2a;
        }
    </style>
    <div class="container">
        <div class="col-md-12">
            <div class="section" id="breadcrumb-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('home') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Gửi yêu cầu hỗ trợ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white text-center">
                        <h4 class="mb-0"><i class="fas fa-headset me-2"></i>GỬI YÊU CẦU HỖ TRỢ</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/1067/1067566.png" alt="Support" width="100">
                            <h5 class="mt-3">Đổi trả, khiếu nại hoặc cần tư vấn thêm?</h5>
                            <p class="text-muted">Gửi yêu cầu để đội ngũ CRIS Store hỗ trợ bạn nhanh chóng</p>
                        </div>
                        
                        <form id="promotion-form">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label"><strong>Họ và tên <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ và tên của bạn" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                                <small class="text-danger error-message" id="name-error"></small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label"><strong>Email <span class="text-danger">*</span></strong></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập địa chỉ email của bạn" value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                                <small class="text-danger error-message" id="email-error"></small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label"><strong>Số điện thoại</strong></label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại (không bắt buộc)">
                                <small class="text-muted">Nếu có, vui lòng nhập để chúng tôi hỗ trợ nhanh hơn</small>
                                <small class="text-danger error-message d-block" id="phone-error"></small>
                            </div>

                            <div class="mb-3">
                                <label for="request_type" class="form-label"><strong>Loại yêu cầu <span class="text-danger">*</span></strong></label>
                                <select class="form-control" id="request_type" name="request_type" required>
                                    <option value="">-- Chọn loại yêu cầu --</option>
                                    <option value="return_exchange">Đổi trả</option>
                                    <option value="complaint">Khiếu nại</option>
                                    <option value="support">Cần hỗ trợ</option>
                                </select>
                                <small class="text-danger error-message d-block" id="request_type-error"></small>
                            </div>

                            <div class="mb-3">
                                <label for="support_content" class="form-label"><strong>Nội dung yêu cầu <span class="text-danger">*</span></strong></label>
                                <textarea class="form-control" id="support_content" name="support_content" rows="5" placeholder="Mô tả chi tiết vấn đề bạn cần hỗ trợ" required></textarea>
                                <small class="text-danger error-message d-block" id="support_content-error"></small>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agree" required>
                                <label class="form-check-label" for="agree">
                                    Tôi đồng ý để CRIS Store liên hệ qua email/số điện thoại đã cung cấp
                                </label>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger btn-lg" id="btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>GỬI YÊU CẦU
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-4">
                            <p class="text-muted mb-0">
                                <i class="fas fa-shield-alt me-1"></i>
                                Chúng tôi cam kết bảo mật thông tin của bạn
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::check())
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Danh sách khiếu nại/yêu cầu của bạn</h5>
                    </div>
                    <div class="card-body">
                        @if (isset($mySupportRequests) && $mySupportRequests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loại yêu cầu</th>
                                        <th>Nội dung</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày gửi</th>
                                        <th>Cập nhật</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mySupportRequests as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($item->request_type == 'return_exchange')
                                                Đổi trả
                                            @elseif ($item->request_type == 'complaint')
                                                Khiếu nại
                                            @else
                                                Cần hỗ trợ
                                            @endif
                                        </td>
                                        <td style="max-width: 420px; white-space: normal;">{{ $item->support_content }}</td>
                                        <td>
                                            @if (!isset($item->status) || empty($item->status) || $item->status == 'new')
                                                <span class="support-status-badge support-status-new">Mới</span>
                                            @elseif ($item->status == 'processing')
                                                <span class="support-status-badge support-status-processing">Đang xử lý</span>
                                            @elseif ($item->status == 'resolved')
                                                <span class="support-status-badge support-status-resolved">Đã xong</span>
                                            @else
                                                <span class="support-status-badge support-status-unknown">Không xác định</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td>{{ $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="mb-0 text-muted">Bạn chưa có yêu cầu hỗ trợ nào.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<script>
$(document).ready(function() {
    $('#promotion-form').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.error-message').text('');
        
        $.ajax({
            url: "{{ route('client.support.submit') }}",
            method: "POST",
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                request_type: $('#request_type').val(),
                support_content: $('#support_content').val(),
                _token: '{{ csrf_token() }}'
            },
            dataType: "json",
            beforeSend: function() {
                $('#btn-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...');
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            },
            error: function(xhr) {
                $('#btn-submit').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i>GỬI YÊU CẦU');
                
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.name) $('#name-error').text(errors.name[0]);
                    if (errors.email) $('#email-error').text(errors.email[0]);
                    if (errors.phone) $('#phone-error').text(errors.phone[0]);
                    if (errors.request_type) $('#request_type-error').text(errors.request_type[0]);
                    if (errors.support_content) $('#support_content-error').text(errors.support_content[0]);
                } else {
                    var serverMessage = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message
                        : 'Đã xảy ra lỗi. Vui lòng thử lại sau.';

                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: serverMessage,
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});
</script>
@endsection
