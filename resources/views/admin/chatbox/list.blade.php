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
                    🧠 Huấn luyện AI - Thêm Kiến Thức Mới
                </div>
                <div class="card-body">

                    {{-- Form thêm kiến thức mới --}}
                    {!! Form::open(['route' => ['admin.chatbox.add'],'method' => 'POST']) !!}
                        <div class="form-group">
                            {!! Form::label('category', 'Chủ đề') !!}
                            {!! Form::text('category', null, [
                                'class' => 'form-control',
                                'placeholder' => 'VD: sản phẩm, khuyến mãi, vận chuyển...',
                                'required'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('title', 'Tiêu đề ngắn') !!}
                            {!! Form::text('title', null, [
                                'class' => 'form-control',
                                'placeholder' => 'VD: Giày Nike Mercurial',
                                'required'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('content', 'Nội dung chi tiết') !!}
                            {!! Form::textarea('content', null, [
                                'class' => 'form-control',
                                'rows' => 6,
                                'placeholder' => 'Nhập nội dung để AI học...',
                                'required'
                            ]) !!}
                        </div>

                        {!! Form::button('💾 Lưu kiến thức', [
                            'type' => 'submit',
                            'class' => 'btn btn-primary'
                        ]) !!}
                    {!! Form::close() !!}

                    {{-- Danh sách kiến thức gần đây --}}
                    <hr>
                    <h5>📋 Kiến thức đã huấn luyện gần đây</h5>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Chủ đề</th>
                                <th>Tiêu đề</th>
                                <th>Nội dung</th>
                                <th>Cập nhật</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0?>
                            @foreach ($knowledges as $item)
                             <?php $i++?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ Str::limit($item->content, 100, '...') }}</td>
                                <td>{{ $item->updated_at->format('d/m/Y | H:i')}} </td>
                                <td>
                                    <button data-id="{{ $item->id }}" 
                                            class="btn btn-success btn-edit btn-sm rounded text-white" 
                                            data-toggle="tooltip" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <a href="{{ route('admin.chatbox.delete', $item->id) }}"
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

{{-- Modal cập nhật kiến thức --}}
<form method="POST" id="id_update">
    @csrf
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        🧠 Chi tiết & chỉnh sửa kiến thức
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{-- ID ẩn --}}
                    <input type="hidden" name="id" id="knowledge_id">

                    <div class="form-group">
                        {!! Form::label('category_edit', 'Chủ đề') !!}
                        {!! Form::text('category', null, [
                            'class' => 'form-control',
                            'id' => 'category_edit',
                            'placeholder' => 'VD: sản phẩm, khuyến mãi, vận chuyển...',
                            'required'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('title_edit', 'Tiêu đề ngắn') !!}
                        {!! Form::text('title', null, [
                            'class' => 'form-control',
                            'id' => 'title_edit',
                            'placeholder' => 'VD: Giày Nike Mercurial',
                            'required'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('content_edit', 'Nội dung chi tiết') !!}
                        {!! Form::textarea('content', null, [
                            'class' => 'form-control',
                            'id' => 'content_edit',
                            'rows' => 6,
                            'placeholder' => 'Nhập nội dung chi tiết để chỉnh sửa...',
                            'required'
                        ]) !!}
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            {!! Form::label('created_at_edit', 'Tạo lúc') !!}
                            {!! Form::text('created_at', null, [
                                'class' => 'form-control',
                                'id' => 'created_at_edit',
                                'disabled' => true
                            ]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('updated_at_edit', 'Cập nhật gần nhất') !!}
                            {!! Form::text('updated_at', null, [
                                'class' => 'form-control',
                                'id' => 'updated_at_edit',
                                'disabled' => true
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success">💾 Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- JS xử lý --}}

<script>
function updateData(id) {
    $.ajax({
        url: "detail/" + id,
        method: "POST",
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        dataType: "json",
        success: function(data) {
            console.log(data)
            // Gán dữ liệu vào form modal
            $("#knowledge_id").val(data.id);
            $("#category_edit").val(data.category);
            $("#title_edit").val(data.title);
            $("#content_edit").val(data.content);

            // Định dạng thời gian hiển thị
            let created = new Date(data.created_at).toLocaleString("vi-VN");
            let updated = new Date(data.updated_at).toLocaleString("vi-VN");
            $("#created_at_edit").val(created);
            $("#updated_at_edit").val(updated);

            // Set action form update
            $("#id_update").attr("action", "update/" + data.id);

       var modal = new bootstrap.Modal(document.getElementById('exampleModalCenter'));
modal.show();

            
        },
        error: function(xhr) {
            alert("Lỗi: " + xhr.status + " - " + xhr.statusText);
        },
    });
}

$(document).on('click', '.btn-edit', function() {
    var id = $(this).data('id');
    updateData(id);
});

</script>
@endsection
