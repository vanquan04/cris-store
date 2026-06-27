
@extends('layouts.client')
@section('content')
<style>
    #myContent { padding: 30px 0; min-height: 520px; background: #f6f7fb; }

    h2.mb-4{
        font-size: 26px; font-weight: 800; text-align: center; color:#1f2937;
        letter-spacing: -0.2px; margin-bottom: 18px !important;
    }

    .card-wrap{
        background:#fff; border-radius:14px; border:1px solid #e5e7eb;
        box-shadow: 0 10px 25px rgba(17,24,39,0.08);
        padding: 18px;
        overflow: hidden;
    }

    .section-title{
        font-size: 15px; font-weight: 800; color:#111827;
        margin: 0 0 10px;
    }

    .info-grid{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 16px;
    }

    .info-item{
        background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px;
        padding: 12px;
        font-size: 14px;
        color:#374151;
    }

    .info-item b{ color:#111827; }
    .info-item.full{ grid-column: 1 / -1; }

    .badge{
        display:inline-flex; align-items:center; gap:8px;
        padding: 7px 12px; font-size: 13px; font-weight: 800;
        border-radius: 999px; color:#fff; line-height:1;
        box-shadow: 0 8px 18px rgba(0,0,0,0.08);
        white-space: nowrap;
    }
    .badge::before{
        content:""; width:8px; height:8px; border-radius:50%;
        background: rgba(255,255,255,0.9);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.18);
    }
    .badge-secondary{ background: linear-gradient(135deg,#6b7280,#4b5563); }
    .badge-primary{ background: linear-gradient(135deg,#2563eb,#1d4ed8); }
    .badge-info{ background: linear-gradient(135deg,#06b6d4,#0891b2); }
    .badge-success{ background: linear-gradient(135deg,#16a34a,#15803d); }
    .badge-danger{ background: linear-gradient(135deg,#ef4444,#dc2626); }

    .table-responsive{
        margin-top: 14px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        background:#fff;
    }

    .table{
        width:100%;
        margin:0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th{
        background:#f9fafb;
        color:#374151;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 14px 12px;
        text-align:center;
        border-bottom: 1px solid #e5e7eb;
    }

    .table tbody td{
        padding: 14px 12px;
        text-align:center;
        font-size: 14px;
        color:#6b7280;
        border-bottom: 1px solid #f1f3f5;
        background:#fff;
        vertical-align: middle;
    }

    .table tbody tr:nth-child(even) td{ background:#fcfcfd; }
    .table tbody tr:hover td{ background:#f6fbff; transition: 0.15s; }

    .product-cell{
        text-align:left !important;
        display:flex; gap:10px; align-items:center;
        min-width: 240px;
    }
    .product-cell img{
        width:56px; height:56px; border-radius:12px;
        object-fit:cover; border:1px solid #e5e7eb; background:#fff;
        flex: 0 0 auto;
    }
    .product-name{ font-weight:800; color:#111827; font-size:14px; margin:0; line-height:1.25; }
    .product-meta{ font-size:12px; color:#6b7280; margin-top:3px; }

    .summary{
        margin-top: 14px;
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .summary-box{
        background:#fff;
        border:1px dashed #e5e7eb;
        border-radius: 14px;
        padding: 12px;
        color:#374151;
        font-size: 14px;
    }
    .summary-row{
        display:flex;
        justify-content: space-between;
        gap: 12px;
        padding: 8px 0;
        border-bottom: 1px solid #f1f3f5;
    }
    .summary-row:last-child{ border-bottom:none; }
    .summary-row b{ color:#111827; font-variant-numeric: tabular-nums; }
    .summary-total b{ font-size: 16px; }

    .actions{
        margin-top: 16px;
        display:flex;
        flex-wrap:wrap;
        gap: 10px;
        justify-content: flex-end;
    }
    .btn{
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 800;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap: 8px;
        transition: 0.15s;
        white-space: nowrap;
    }
    .btn-outline{
        background:#fff;
        border:1px solid #d1d5db;
        color:#374151;
    }
    .btn-outline:hover{ background:#f9fafb; }

    .btn-info{
        background: linear-gradient(135deg, #20c997, #17a2b8);
        color:#fff;
        box-shadow: 0 10px 18px rgba(23,162,184,0.18);
    }
    .btn-info:hover{ transform: translateY(-1px); box-shadow: 0 14px 24px rgba(23,162,184,0.25); }

    .btn-danger-soft{
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color:#fff;
        box-shadow: 0 10px 18px rgba(220, 38, 38, 0.18);
    }
    .btn-danger-soft:hover{
        color:#fff;
        text-decoration:none;
        transform: translateY(-1px);
        box-shadow: 0 14px 24px rgba(220, 38, 38, 0.25);
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

    .status-flow-wrap{
        margin-top: 14px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px;
    }
    .status-flow-title{
        font-size: 14px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 10px;
    }
    .status-flow-steps{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
        position: relative;
    }
    .status-flow-line{
        position: absolute;
        top: 15px;
        left: 6%;
        right: 6%;
        height: 2px;
        background: #d1d5db;
        z-index: 0;
    }
    .status-step{
        position: relative;
        z-index: 1;
        text-align: center;
    }
    .status-dot{
        width: 14px;
        height: 14px;
        border-radius: 999px;
        margin: 8px auto 6px;
        border: 2px solid #9ca3af;
        background: #fff;
    }
    .status-label{
        font-size: 12px;
        color: #6b7280;
        font-weight: 700;
        line-height: 1.25;
    }
    .status-step.done .status-dot{
        background: #10b981;
        border-color: #059669;
    }
    .status-step.done .status-label{ color: #065f46; }
    .status-step.current .status-dot{
        width: 18px;
        height: 18px;
        background: #2563eb;
        border-color: #1d4ed8;
        box-shadow: 0 0 0 4px rgba(37,99,235,0.18);
    }
    .status-step.current .status-label{ color: #1e3a8a; }
    .status-flow-text{
        margin-top: 8px;
        font-size: 12px;
        color: #4b5563;
    }
    .status-cancel-box{
        margin-top: 10px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 13px;
        font-weight: 700;
    }

    @media (max-width: 992px){
        .info-grid{ grid-template-columns: 1fr; }
        .summary{ grid-template-columns: 1fr; }
    }
</style>

@php
    // Map trạng thái theo progress giống trang myOrder
    $statusText = match((int)($data['progress'] ?? -1)){
        0 => 'Chờ xác nhận',
        4 => 'Đã xác nhận',
        1 => 'Đang giao',
        2 => 'Giao hàng thành công',
        3 => 'Đã hủy',
        default => 'Không xác định'
    };

    $statusClass = match((int)($data['progress'] ?? -1)){
        0 => 'badge-secondary',
        4 => 'badge-info',
        1 => 'badge-primary',
        2 => 'badge-success',
        3 => 'badge-danger',
        default => 'badge-secondary'
    };

    $progressValue = (int)($data['progress'] ?? -1);
    $progressFlow = [
        0 => 'Chờ xác nhận',
        4 => 'Đã xác nhận',
        1 => 'Đang giao',
        2 => 'Giao hàng thành công',
    ];
    $progressIndex = [0 => 0, 4 => 1, 1 => 2, 2 => 3];
    $currentFlowIndex = $progressIndex[$progressValue] ?? -1;
    $isCanceled = $progressValue === 3;

    // product là mảng sau json_decode
    $products = $data['product'] ?? [];
    if(!is_array($products)) $products = [];

    // Tính tạm tính từ sản phẩm (nếu đủ field)
    $subTotal = 0;
    foreach($products as $p){
        $price = (int)($p['price'] ?? 0);
        $qty   = (int)($p['quantity'] ?? ($p['qty'] ?? 1));
        $subTotal += $price * $qty;
    }
@endphp

<section id="myContent">
    <div class="container">
        <h2 class="mb-4">Chi tiết đơn hàng</h2>

        <div class="card-wrap">
            <div class="section-title">Thông tin đơn hàng</div>
            <div class="info-grid">
                <div class="info-item">Mã đơn: <b>{{ $data['code_bill'] }}</b></div>
                <div class="info-item">Ngày đặt: <b>{{ \Carbon\Carbon::parse($data['created_at'])->format('d/m/Y H:i') }}</b></div>
                <div class="info-item">Trạng thái: <span class="badge {{ $statusClass }}">{{ $statusText }}</span></div>
                <div class="info-item">Phương thức: <b>{{ $data['method_pay'] }}</b></div>
            </div>

            <div class="status-flow-wrap">
                <div class="status-flow-title">Lộ trình trạng thái đơn hàng</div>
                <div class="status-flow-steps">
                    <div class="status-flow-line"></div>
                    @foreach($progressFlow as $stepCode => $stepLabel)
                        @php
                            $stepIndex = $progressIndex[$stepCode];
                            $isDone = !$isCanceled && $currentFlowIndex > $stepIndex;
                            $isCurrent = !$isCanceled && $progressValue === $stepCode;
                            $stepClass = $isCurrent ? 'current' : ($isDone ? 'done' : '');
                        @endphp
                        <div class="status-step {{ $stepClass }}">
                            <div class="status-dot"></div>
                            <div class="status-label">{{ $stepLabel }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="status-flow-text">
                    Chờ xác nhận → Đã xác nhận → Đang giao → Giao hàng thành công
                </div>
                @if($isCanceled)
                    <div class="status-cancel-box">
                        Đơn hàng đã bị hủy. Lộ trình giao hàng đã dừng tại trạng thái: <b>{{ $statusText }}</b>.
                    </div>
                @endif
            </div>

            <div class="section-title" style="margin-top:14px;">Thông tin nhận hàng</div>
            <div class="info-grid">
                <div class="info-item">Họ tên: <b>{{ $data['fullname'] }}</b></div>
                <div class="info-item">SĐT: <b>{{ $data['phone'] }}</b></div>
                <div class="info-item full">Email: <b>{{ $data['email'] }}</b></div>
                <div class="info-item full">Địa chỉ: <b>{{ $data['address'] }}</b></div>
                <div class="info-item full">Ghi chú: <b>{{ $data['note'] }}</b></div>
            </div>

            <div class="section-title" style="margin-top:14px;">Sản phẩm trong đơn</div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                            @php
                      $name = $p['name'] ?? 'Sản phẩm';

    // qty của bạn là "qty" (không phải quantity)
    $qty  = (int)($p['qty'] ?? 1);

    $price = (int)($p['price'] ?? 0);

    // Ảnh nằm trong options.thumb_main
    $thumb = $p['options']['thumb_main'] ?? null;

    // Nếu ảnh nằm trong public/uploads/... thì dùng asset()
    $img = $thumb ? asset($thumb) : asset('images/no-image.png');

    $code = $p['options']['code'] ?? null;
    $lineTotal = $price * $qty;
                            @endphp
                            <tr>
                                <td style="text-align:left;">
                                    <div class="product-cell">
                                        <img src="{{ $img ?: 'https://via.placeholder.com/120x120?text=No+Image' }}" alt="{{ $name }}">
                                        <div>
                                            <p class="product-name">{{ $name }}</p>
                                            @php
                                                $details = [];
                                                if (!empty($p['options']['field_type'])) {
                                                    $details[] = 'Đinh: ' . str_replace('Đinh ', '', $p['options']['field_type']);
                                                }
                                                if (!empty($p['options']['option'])) {
                                                    $details[] = 'Phân loại: ' . $p['options']['option'];
                                                }
                                            @endphp
                                            @if(!empty($details))
                                                <p style="font-size:12px; color:#6b7280; margin-top:4px;">{{ implode(' | ', $details) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($price, 0, '.', '.') }} VNĐ</td>
                                <td>{{ $qty }}</td>
                                <td style="font-weight:800;color:#111827;">
                                    {{ number_format($lineTotal, 0, '.', '.') }} VNĐ
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 18px; color:#6b7280;">
                                    Không có sản phẩm trong đơn (product JSON rỗng).
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="summary">
                <div class="summary-box">
                    <div class="section-title" style="margin:0 0 6px;">Tổng kết</div>
                    <div class="summary-row">
                        <span>Tạm tính (từ sản phẩm)</span>
                        <b>{{ number_format($subTotal, 0, '.', '.') }} VNĐ</b>
                    </div>

                    {{-- total bạn đã format sẵn trong controller --}}
                    <div class="summary-row summary-total">
                        <span>Tổng thanh toán</span>
                        <b>{{ $data['total'] }}</b>
                    </div>

                    <div class="summary-row">
                        <span>Số lượng món</span>
                        <b>{{ (int)($data['amount'] ?? 0) }}</b>
                    </div>
                </div>

                <div class="summary-box">
                    <div class="section-title" style="margin:0 0 6px;">Thông tin hệ thống</div>
                    <div class="summary-row">
                        <span>Mã đơn nội bộ</span>
                        <b>#{{ $data['code_bill'] }}</b>
                    </div>
                    <div class="summary-row">
                        <span>Cập nhật lần cuối</span>
                        <b>{{ \Carbon\Carbon::parse($data['updated_at'])->format('d/m/Y H:i') }}</b>
                    </div>
                </div>
            </div>

            <div class="actions">
                <a href="javascript:history.back()" class="btn btn-outline">Quay lại</a>
                @if ((int)($data['progress'] ?? -1) === 0)
                    <button type="button" class="btn btn-danger-soft" id="openCancelOrderModal">Hủy đơn hàng</button>
                @endif
                <a href="#" class="btn btn-info" onclick="window.print(); return false;">In đơn</a>
            </div>
        </div>
    </div>

    <div id="cancelOrderModalMask" class="cancel-modal-mask">
        <div class="cancel-modal">
            <div class="cancel-modal-head">Hủy đơn hàng <span class="text-danger">{{ $data['code_bill'] }}</span></div>
            <form id="cancelOrderForm" method="POST" action="{{ route('client.cart.cancelOrder', $data['id']) }}">
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
                    <button type="button" id="cancelModalClose" class="btn btn-outline">Đóng</button>
                    <button type="submit" class="btn btn-danger-soft">Xác nhận hủy đơn</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    (function () {
        const openBtn = document.getElementById('openCancelOrderModal');
        const modalMask = document.getElementById('cancelOrderModalMask');
        const closeBtn = document.getElementById('cancelModalClose');
        const reasonSelect = document.getElementById('cancel_reason');

        if (!openBtn || !modalMask || !closeBtn) return;

        const closeModal = function () {
            modalMask.style.display = 'none';
            if (reasonSelect) {
                reasonSelect.value = '';
            }
        };

        openBtn.addEventListener('click', function () {
            modalMask.style.display = 'flex';
        });
        closeBtn.addEventListener('click', closeModal);
        modalMask.addEventListener('click', function (e) {
            if (e.target === modalMask) closeModal();
        });
    })();
</script>
@endsection
