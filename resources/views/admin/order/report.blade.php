@extends('layouts.admin')
@section('content')
<div class="container-fluid py-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-body py-3">
            <form method="GET" action="" class="mb-0">
                <div class="d-flex align-items-end" style="gap: 15px;">
                    <div>
                        <label class="font-weight-bold mb-1">Từ ngày</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                    </div>
                    <div>
                        <label class="font-weight-bold mb-1">Đến ngày</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                    </div>
                    <div>
                        <button class="btn btn-primary mb-0" type="submit">Lọc báo cáo</button>
                        <a href="{{ route('admin.order.report') }}" class="btn btn-outline-secondary mb-0 ml-2">Mặc định (7 ngày)</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white box-success mb-3 box" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{$orderSuccess}}</h5>
                    <p class="card-text">Đơn hàng đã hoàn tất.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white box-confirm mb-3 box" style="max-width: 18rem;">
                <div class="card-header">CHỜ XÁC NHẬN</div>
                <div class="card-body">
                    <h5 class="card-title">{{$orderConfirm}}</h5>
                    <p class="card-text">Đơn hàng đang chờ xử lý.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white box-revenue mb-3 box" style="max-width: 18rem;">
                <div class="card-header">DOANH THU</div>
                <div class="card-body">
                    <h5 class="card-title">{{number_format($total,0,'','.').' VNĐ'}}</h5>
                    <p class="card-text">Doanh thu từ đơn thành công.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white box-cancel mb-3 box" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{$orderCancel}}</h5>
                    <p class="card-text">Đơn hàng đã bị hủy.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header font-weight-bold">Báo cáo bán hàng trực quan</div>
        <div class="card-body">
            <p class="text-muted">Các biểu đồ dưới đây hiển thị tình trạng đơn hàng và doanh thu theo khoảng thời gian đã chọn.</p>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">Số đơn theo ngày</div>
                        <div class="card-body">
                            <canvas id="orderBarChart" style="max-height:320px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">Doanh thu theo ngày</div>
                        <div class="card-body">
                            <canvas id="revenueLineChart" style="max-height:320px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">Phân bổ trạng thái đơn hàng</div>
                        <div class="card-body">
                            <canvas id="orderStatusPie" style="max-height:320px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">Ghi chú</div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li><strong>Đơn hàng thành công:</strong> số lượng đơn đã hoàn tất.</li>
                                <li><strong>Đã xác nhận:</strong> đơn đã xác nhận chuẩn bị bàn giao vận chuyển.</li>
                                <li><strong>Chờ xác nhận:</strong> đơn mới chưa xử lý.</li>
                                <li><strong>Doanh thu:</strong> tổng giá trị đơn thành công.</li>
                                <li><strong>Đơn hủy:</strong> các đơn bị huỷ trong hệ thống.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const barLabels = @json($barLabels ?? []);
        const barData   = @json($barData ?? []);
        const revenueData = @json($revenueData ?? []);
        const statusLabels = @json($statusLabels ?? []);
        const statusData   = @json($statusData ?? []);

        const barEl = document.getElementById('orderBarChart');
        if (barEl) {
            new Chart(barEl, {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Số đơn',
                        data: barData,
                        backgroundColor: '#276bb9',
                        borderColor: '#1f5bb8',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }

        const revenueEl = document.getElementById('revenueLineChart');
        if (revenueEl) {
            new Chart(revenueEl, {
                type: 'line',
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: revenueData,
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 }).format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 }).format(context.parsed.y);
                                }
                            }
                        }
                    }
                }
            });
        }

        const pieEl = document.getElementById('orderStatusPie');
        if (pieEl) {
            new Chart(pieEl, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: ['#28a745', '#007bff', '#17a2b8', '#6c757d', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    });
</script>
@endsection
