@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
        <div class="{{ session('color') ?? 'alert-success' }} alert">
            <b>{{ session('status') }}</b>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header font-weight-bold">
                    💬 Quản lý cuộc hội thoại AI
                </div>
                <div class="card-body">

                    {{-- Danh sách các session --}}
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>ID Session</th>
                                <th>Số tin nhắn</th>
                                <th>Tạo lúc</th>
                                <th>Cập nhật</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conversations as $i => $conv)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $conv->id }}</td>
                                <td>{{ $conv->messages_count ?? $conv->messages->count() }}</td>
                                <td>{{ $conv->created_at->format('d/m/Y | H:i') }}</td>
                                <td>{{ $conv->updated_at->format('d/m/Y | H:i') }}</td>
                                <td>
                                    <button data-id="{{ $conv->id }}" 
                                            class="btn btn-success btn-edit btn-sm rounded text-white" 
                                            data-toggle="tooltip" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <a href="{{ route('admin.chatbox.export', $conv->id) }}"
                                       class="btn btn-info btn-sm rounded text-white"
                                       data-toggle="tooltip" title="Xuất Excel">
                                        <i class="fas fa-file-excel"></i>
                                    </a>

                                    <a href="{{ route('admin.chatbox.deleteSession', $conv->id) }}"
                                       class="btn btn-danger btn-sm rounded text-white"
                                       data-toggle="tooltip" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> {{-- end card-body --}}
            </div>
        </div>
    </div>
</div>

{{-- Modal xem chi tiết tin nhắn --}}
<div class="modal fade" id="modalMessages" tabindex="-1" role="dialog"
     aria-labelledby="modalMessagesTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">📝 Chi tiết cuộc hội thoại</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="messagesContent" style="max-height:400px; overflow-y:auto;">
                {{-- Tin nhắn sẽ load AJAX --}}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

{{-- JS xử lý xem chi tiết session --}}
<script>
function viewConversation(id) {
    $.ajax({
        url: "{{ url('admin/chatbox/session') }}/" + id,
        method: "GET",
        dataType: "json",
        success: function(data) {
            let html = '';
            data.messages.forEach(msg => {
                html += `<div><b>${msg.sender === 'user' ? 'Người dùng' : 'AI'}:</b> ${msg.content}</div>`;
            });
            $("#messagesContent").html(html);

            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('modalMessages'));
            modal.show();
        },
        error: function(xhr) {
            alert("Lỗi: " + xhr.status + " - " + xhr.statusText);
        }
    });
}

$(document).on('click', '.btn-edit', function() {
    let id = $(this).data('id');
    viewConversation(id);
});
</script>
@endsection
