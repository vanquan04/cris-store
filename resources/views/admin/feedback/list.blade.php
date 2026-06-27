@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="{{session('color')}} alert">
        <b>{{session('status')}}</b>
    </div>
    @endif

    <div class="row">
        <div class="col-4">
            <div class="card text-center">
                <div class="card-header font-weight-bold">
                    Điểm trung bình
                </div>
                <div class="card-body">
                    <h1 class="display-4 text-warning">{{ $averageStar }} <small>/ 5</small></h1>
                    <div class="text-warning">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($averageStar))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thống kê đánh giá theo sao
                </div>
                <div class="card-body">
                    @foreach($starCounts as $star => $count)
                        <div class="d-flex align-items-center mb-2">
                            <span style="width: 60px;">{{ $star }} <i class="fas fa-star text-warning"></i></span>
                            <div class="flex-grow-1 mx-2">
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                         style="width: {{ $numActive > 0 ? ($count / $numActive) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                            <span style="width: 40px;">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Danh sách đánh giá phản hồi</h5>
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.feedback.export') }}" class="btn btn-success btn-sm mr-2">
                    <i class="fas fa-file-export"></i> Xuất Word
                </a>
                <form action="{{ route('admin.feedback.export') }}" method="GET" class="form-inline">
                    <input type="text" class="form-control form-search" placeholder="Tìm kiếm..." 
                           value="{{$keyword}}" name="keyword">
                    <input type="submit" class="btn btn-primary ml-1" value="Tìm">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">
                    Đang hiển thị<span class="text-muted">({{$numActive}})</span>
                </a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">
                    Đã xóa<span class="text-muted">({{$numTrash}})</span>
                </a>
            </div>
            <form action="{{url('admin/feedback/action')}}" method="POST">
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
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Số sao</th>
                            <th scope="col">Nội dung</th>
                            <th scope="col">Ngày đánh giá</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($feedbacks->total() > 0)
                        @php $temp = 0; @endphp
                        @foreach ($feedbacks as $feedback)
                        @php $temp++; @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{$feedback->id}}">
                            </td>
                            <th scope="row">{{$temp}}</th>
                            <td>
                                <strong>{{ $feedback->User ? $feedback->User->name : 'N/A' }}</strong>
                                <br>
                                <small class="text-muted">{{ $feedback->User ? $feedback->User->email : '' }}</small>
                            </td>
                            <td>
                                <span class="text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $feedback->star)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </span>
                                <br>
                                <small>{{ $feedback->star }}/5</small>
                            </td>
                            <td>
                                <p class="mb-0" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $feedback->content ?: 'Không có nội dung' }}
                                </p>
                            </td>
                            <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="" data-toggle="modal" data-id="{{ $feedback->id }}" data-target="#feedbackDetailModal"
                                   class="btn btn-info btn-sm rounded-0 text-white btn-detail" type="button"
                                   title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if ($status == 'active')
                                <a href="{{url($url_delete.$feedback->id)}}"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')"
                                   class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                   data-toggle="tooltip" data-placement="top" title="Xóa">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @else
                                <a href="{{url('admin/feedback/restore/'.$feedback->id)}}"
                                   class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                   data-toggle="tooltip" data-placement="top" title="Khôi phục">
                                    <i class="fas fa-trash-restore"></i>
                                </a>
                                <a href="{{url($url_delete.$feedback->id)}}"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn?')"
                                   class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                   data-toggle="tooltip" data-placement="top" title="Xóa vĩnh viễn">
                                    <i class="fas fa-minus-circle"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center alert alert-danger">
                                Không tìm thấy kết quả nào!
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                {{$feedbacks->links()}}
            </form>
        </div>
    </div>
</div>

<!-- Modal Chi tiết đánh giá -->
<div class="modal fade" id="feedbackDetailModal" tabindex="-1" role="dialog"
    aria-labelledby="feedbackDetailModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="feedbackDetailModalTitle">
                    <i class="fas fa-info-circle mr-1"></i> Chi tiết đánh giá
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="mb-2">
                        <span class="badge badge-secondary" id="detail-id"></span>
                    </div>
                    <div class="text-warning" id="detail-stars" style="font-size: 1.5rem;"></div>
                    <div class="mt-1">
                        <strong id="detail-star-text" class="text-muted"></strong>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        <div class="mr-2 text-primary"><i class="fas fa-user"></i></div>
                        <strong>Khách hàng</strong>
                    </div>
                    <p class="mb-0 ml-4" id="detail-user-name"></p>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        <div class="mr-2 text-primary"><i class="fas fa-envelope"></i></div>
                        <strong>Email</strong>
                    </div>
                    <p class="mb-0 ml-4" id="detail-user-email"></p>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        <div class="mr-2 text-primary"><i class="fas fa-phone"></i></div>
                        <strong>Số điện thoại</strong>
                    </div>
                    <p class="mb-0 ml-4" id="detail-user-phone"></p>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        <div class="mr-2 text-primary"><i class="fas fa-comment-dots"></i></div>
                        <strong>Nội dung đánh giá</strong>
                    </div>
                    <div class="ml-4 p-3 bg-light rounded" id="detail-content" style="white-space: pre-wrap;"></div>
                </div>
                <hr>
                <div class="row text-muted small">
                    <div class="col-6">
                        <i class="fas fa-calendar-alt mr-1"></i> <strong>Ngày đánh giá:</strong>
                        <br><span id="detail-created-at"></span>
                    </div>
                    <div class="col-6">
                        <i class="fas fa-clock mr-1"></i> <strong>Cập nhật lần cuối:</strong>
                        <br><span id="detail-updated-at"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".btn-detail").click(function(e) {
            e.preventDefault();
            var id = $(this).attr("data-id");

            $.ajax({
                url: "{{ url('admin/feedback/detail') }}/" + id,
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(data) {
                    $("#detail-id").text("#" + data.id);
                    $("#detail-user-name").text(data.user_name);
                    $("#detail-user-email").text(data.user_email);
                    $("#detail-user-phone").text(data.user_phone);
                    $("#detail-content").text(data.content);
                    $("#detail-created-at").text(data.created_at);
                    $("#detail-updated-at").text(data.updated_at);
                    $("#detail-star-text").text(data.star + " / 5");

                    // Render stars
                    var starsHtml = '';
                    for (var i = 1; i <= 5; i++) {
                        if (i <= data.star) {
                            starsHtml += '<i class="fas fa-star"></i> ';
                        } else {
                            starsHtml += '<i class="far fa-star"></i> ';
                        }
                    }
                    $("#detail-stars").html(starsHtml);
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra khi tải chi tiết đánh giá!');
                }
            });
        });
    });
</script>
@endsection
