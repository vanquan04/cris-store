@extends('layouts.client')
@section('content')
<style>
    :root{
        --bg: #f6f7fb;
        --card: #ffffff;
        --text: #1f2937;
        --muted: #6b7280;
        --line: #e5e7eb;
        --shadow: 0 10px 25px rgba(17, 24, 39, 0.08);
        --radius: 14px;
    }

    #myContent {
        padding: 34px 0;
        min-height: 520px;
        background: var(--bg);
    }

    .container{
        max-width: 1100px;
    }

    h2.mb-4 {
        font-size: 26px;
        font-weight: 800;
        text-align: center;
        color: var(--text);
        letter-spacing: -0.2px;
        margin-bottom: 18px !important;
    }

    /* Card wrapper cho table */
    .table-responsive{
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--line);
        overflow: hidden;
    }

    .table {
        width: 100%;
        margin-top: 0;
        border-collapse: separate;
        border-spacing: 0;
        background: var(--card);
    }

    /* Header */
    .table thead th{
        background: #f9fafb;
        color: #374151;
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 14px 14px;
        text-align: center;
        border-bottom: 1px solid var(--line);
        position: sticky; /* giúp nhìn đẹp khi scroll bảng */
        top: 0;
        z-index: 1;
    }

    .table tbody td{
        padding: 16px 14px;
        text-align: center;
        font-size: 14px;
        color: var(--muted);
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
        background: #fff;
    }

    /* Zebra rows */
    .table tbody tr:nth-child(even) td{
        background: #fcfcfd;
    }

    /* Hover row */
    .table tbody tr:hover td{
        background: #f6fbff;
        transition: 0.15s;
    }

    /* Căn trái cho Mã đơn để nhìn "pro" hơn */
    .table tbody td:first-child{
        text-align: left;
        font-weight: 700;
        color: #111827;
        font-variant-numeric: tabular-nums;
    }

    /* Total tiền */
    .table tbody td:nth-child(3){
        font-weight: 800;
        color: #111827;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }

    /* Badge trạng thái (pill) */
    .badge{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        font-size: 13px;
        font-weight: 700;
        border-radius: 999px;
        color: #fff;
        line-height: 1;
        box-shadow: 0 8px 18px rgba(0,0,0,0.08);
        user-select: none;
        white-space: nowrap;
    }

    /* Dot nhỏ trước chữ */
    .badge::before{
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,0.9);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.18);
    }

    .badge-secondary{
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }
    .badge-primary{
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }
    .badge-info{
        background: linear-gradient(135deg, #06b6d4, #0891b2);
    }
    .badge-success{
        background: linear-gradient(135deg, #16a34a, #15803d);
    }
    .badge-danger{
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    /* Nút Chi tiết */
    .table td a.btn{
        padding: 9px 12px;
        font-size: 13px;
        font-weight: 800;
        border-radius: 10px;
        border: 1px solid rgba(23, 162, 184, 0.18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: 0.15s;
        box-shadow: 0 10px 18px rgba(23, 162, 184, 0.18);
        white-space: nowrap;
    }

    .btn-detail-order{
        background: linear-gradient(135deg, #0ea5e9, #0284c7) !important;
        color: #fff !important;
        text-decoration: none !important;
        border: 1px solid rgba(14, 165, 233, 0.2) !important;
    }

    .btn-detail-order:hover{
        transform: translateY(-1px);
        box-shadow: 0 14px 24px rgba(14, 165, 233, 0.3) !important;
        filter: brightness(1.05);
    }

    .btn-detail-order:active{
        transform: translateY(0);
        box-shadow: 0 10px 18px rgba(14, 165, 233, 0.2) !important;
    }

    .btn-danger-soft{
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border: 1px solid rgba(220, 38, 38, 0.15);
        box-shadow: 0 10px 18px rgba(220, 38, 38, 0.18);
    }
    .btn-danger-soft:hover{
        transform: translateY(-1px);
        box-shadow: 0 14px 24px rgba(220, 38, 38, 0.25);
        color: #fff;
        text-decoration: none;
    }

    .cancel-modal-mask{
        display:none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .cancel-modal{
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 20px 45px rgba(0,0,0,0.2);
        overflow: hidden;
    }
    .cancel-modal-head{
        padding: 14px 16px;
        border-bottom: 1px solid #eef2f7;
        font-weight: 800;
        color: #111827;
    }
    .cancel-modal-body{ padding: 16px; }
    .cancel-modal-foot{
        padding: 12px 16px;
        border-top: 1px solid #eef2f7;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .reason-select{
        width:100%;
        padding:10px 12px;
        border-radius:10px;
        border:1px solid #d1d5db;
        color:#111827;
        background:#fff;
    }

    /* Empty state */
    .no-orders{
        text-align: center;
        margin-top: 40px;
        background: var(--card);
        border-radius: var(--radius);
        border: 1px solid var(--line);
        box-shadow: var(--shadow);
        padding: 28px 18px;
    }

    .no-orders img{
        max-width: 320px;
        width: 100%;
        margin-bottom: 14px;
        opacity: 0.95;
    }

    .no-orders p{
        font-size: 16px;
        color: var(--muted);
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px){
        h2.mb-4{ font-size: 22px; }

        .table thead th{
            font-size: 12px;
            padding: 12px 10px;
        }

        .table tbody td{
            padding: 12px 10px;
            font-size: 13px;
        }

        .badge{ font-size: 12px; padding: 6px 10px; }
        .table td a.btn{ padding: 8px 10px; font-size: 12px; }
    }
</style>

<section id="myContent">
    <div class="container">
        <h2 class="mb-4">Đơn hàng của tôi</h2>

        @if ($orders->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->code_bill }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ number_format($order->total, 0, '.', '.') }} VNĐ</td>
                        <td>
                            @if ($order->progress == 0)
                            <span class="badge badge-secondary">Chờ xác nhận</span>
                            @elseif ($order->progress == 4)
                            <span class="badge badge-info">Đã xác nhận</span>
                            @elseif ($order->progress == 1)
                            <span class="badge badge-primary">Đang giao</span>
                            @elseif ($order->progress == 2)
                            <span class="badge badge-success">Giao hàng thành công</span>
                            @elseif ($order->progress == 3)
                            <span class="badge badge-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('client.cart.detailOrder', $order->id)}}" class="btn btn-detail-order">Chi tiết</a>
                            @if ((int)$order->progress === 0)
                                <button type="button"
                                    class="btn btn-danger-soft open-cancel-modal"
                                    data-id="{{ $order->id }}"
                                    data-code="{{ $order->code_bill }}"
                                    style="margin-left:8px;">
                                    Hủy đơn
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-orders">
            <img src="https://drive.gianhangvn.com/image/empty-cart.jpg" alt="No orders">
            <p>Hiện tại bạn chưa có đơn hàng nào. Hãy quay lại và mua sắm nhé!</p>
        </div>
        @endif
    </div>

    <div id="cancelOrderModalMask" class="cancel-modal-mask">
        <div class="cancel-modal">
            <div class="cancel-modal-head">Hủy đơn hàng <span id="cancelOrderCode" class="text-danger"></span></div>
            <form id="cancelOrderForm" method="POST" action="">
                @csrf
                <div class="cancel-modal-body">
                    <label for="cancel_reason" style="font-weight:700;display:block;margin-bottom:8px;">Chọn lý do hủy</label>
                    <select id="cancel_reason" name="cancel_reason" class="reason-select" required>
                        <option value="">-- Chọn lý do --</option>
                        <option value="Thay đổi nhu cầu mua hàng">Thay đổi nhu cầu mua hàng</option>
                        <option value="Đặt nhầm sản phẩm">Đặt nhầm sản phẩm</option>
                        <option value="Muốn đổi phương thức thanh toán">Muốn đổi phương thức thanh toán</option>
                        <option value="Tìm được giá tốt hơn">Tìm được giá tốt hơn</option>
                        <option value="Lý do cá nhân khác">Lý do cá nhân khác</option>
                    </select>
                    <small style="display:block;color:#6b7280;margin-top:8px;">Chỉ có thể hủy đơn khi trạng thái đang là <b>Chờ xác nhận</b>.</small>
                </div>
                <div class="cancel-modal-foot">
                    <button type="button" id="cancelModalClose" class="btn btn-outline-secondary">Đóng</button>
                    <button type="submit" class="btn btn-danger-soft">Xác nhận hủy đơn</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    (function () {
        const modalMask = document.getElementById('cancelOrderModalMask');
        const closeBtn = document.getElementById('cancelModalClose');
        const form = document.getElementById('cancelOrderForm');
        const codeHolder = document.getElementById('cancelOrderCode');
        const reasonSelect = document.getElementById('cancel_reason');
        const triggers = document.querySelectorAll('.open-cancel-modal');

        if (!modalMask || !form || !triggers.length) return;

        const closeModal = function () {
            modalMask.style.display = 'none';
            reasonSelect.value = '';
        };

        triggers.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = btn.getAttribute('data-id');
                const code = btn.getAttribute('data-code') || '';
                form.action = "{{ url('don-hang-cua-toi/huy') }}/" + id;
                codeHolder.textContent = code;
                modalMask.style.display = 'flex';
            });
        });

        closeBtn.addEventListener('click', closeModal);
        modalMask.addEventListener('click', function (e) {
            if (e.target === modalMask) closeModal();
        });
    })();
</script>
@endsection