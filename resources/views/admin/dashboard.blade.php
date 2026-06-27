@extends('layouts.admin')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white box-success mb-3 box" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{$orderSuccess}}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white box-confirm mb-3 box" style="max-width: 18rem;">
                <div class="card-header">CHỜ XÁC NHẬN</div>
                <div class="card-body">
                    <h5 class="card-title">{{$orderConfirm}}</h5>
                    <p class="card-text">Số lượng đơn hàng chờ xác nhận</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card text-white box-revenue mb-3 box" style="max-width: 18rem;">
                <div class="card-header">DOANH THU</div>
                <div class="card-body">
                    <h5 class="card-title">{{number_format($total,0,'','.').' VNĐ'}}</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card text-white box-cancel mb-3 box" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{$orderCancel}}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">Mã đơn</th>
                        <th scope="col" class="text-center">Khách hàng</th>
                        <th scope="col" class="text-center">Số lượng</th>
                        <th scope="col" class="text-center">Giá trị</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($orders as $order)
                    <tr>
                        <th scope="row" class="py-4">{{++$i}}</th>
                        <td class="text-center">{{$order->code_bill}}</td>
                        <td class="text-center">
                            <a href="" data-toggle="modal" class="btn-edit" data-id="{{ $order->id }}"
                                data-target="#exampleModalCenter"><b> {{$order->fullname}}</b>
                            </a>
                        </td>
                        <td class="text-center">{{$order->amount}}</td>
                        <td class="text-center"><b class="text-danger">{{number_format($order->total,0,'','.').'đ'}}</b>
                        </td>
                        <td>
                            @if ($order->progress == 0)
                            <span class="badge badge-secondary">Chờ xác nhận</span>
                            @elseif ($order->progress == 1)
                            <span class="badge badge-primary">Đang giao</span>
                            @elseif ($order->progress == 4)
                            <span class="badge badge-info">Đã xác nhận</span>
                            @elseif ($order->progress == 2)
                            <span class="badge badge-success">Thành công</span>
                            @elseif ($order->progress == 3)
                            <span class="badge badge-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>{{$order->created_at->format('d/m/Y | H:i')}}</td>
                        <td>
                            <a data-toggle="modal" data-id="{{ $order->id }}" data-target="#exampleModalCenter"
                                class="btn btn-success btn-edit btn-sm rounded text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Chi tiết"><i
                                    class="fas fa-eye"></i></a>
                            <a href="{{route('admin.dashboard.delete',$order->id)}}"
                                class="btn btn-danger btn-sm rounded text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>
</div>
<form method="POST" id="id_update">
    @csrf
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Chi tiết đơn hàng =>| <b
                            class="customer text-danger"></b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="code">
                        <div class="d-flex">
                            <div class="icon mr-2 text-primary"><i class="fas fa-qrcode"></i></div>
                            <b>Mã đơn hàng</b>
                        </div>
                        <p class="code_bill"></p>
                    </div>
                    <div class="wp-address">
                        <div class="d-flex">
                            <div class="icon mr-2 text-primary"><i class="fas fa-map-marker-alt"></i></div>
                            <b>Địa chỉ nhận hàng</b>
                        </div>
                        <p class="address"></p>
                    </div>
                    <div class="wp-email">
                        <div class="d-flex">
                            <div class="icon mr-2 text-primary"><i class="far fa-envelope"></i></div>
                            <b>Email</b>
                        </div>
                        <p class="email"></p>
                    </div>
                    <div class="wp-note">
                        <div class="d-flex">
                            <div class="icon mr-2 text-primary"><i class="fas fa-clipboard"></i></div>
                            <b>Chú thích</b>
                        </div>
                        <p class="note"></p>
                    </div>
                    <div class="method">
                        <div class="d-flex">
                            <div class="icon mr-2 text-primary"><i class="far fa-money-bill-alt"></i></div>
                            <b>Hình thức thanh toán</b>
                        </div>
                        <p class="method_pay">Hình thức</p>
                        <div class="method">
                            <div class="d-flex">
                                <div class="icon mr-2 text-primary"><i class="fas fa-umbrella"></i></div>
                                <b>Tình trạng đơn hàng</b>
                            </div>
                            {!! Form::select('progress', [0 =>'Chờ xác nhận',4=>'Đã xác nhận',1=>'Đang giao',2=>'Thành công',3=>'Đã
                            hủy'],null, ['class' =>
                            'form-control my-2']) !!}
                        </div>
                    </div>
                    <div class="section">
                        <div class="section-head mt-4">
                            <h4 class="section-title">Sản phẩm đơn hàng</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table info-exhibition">
                                <thead>
                                    <tr>
                                        <td class="thead-text font-weight-bold">STT</td>
                                        <td class="thead-text font-weight-bold">Ảnh</td>
                                        <td class="thead-text font-weight-bold">Tên</td>
                                        <td class="thead-text font-weight-bold">Đơn giá</td>
                                        <td class="thead-text font-weight-bold">Số lượng</td>
                                        <td class="thead-text font-weight-bold">Thành tiền</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="section">
                        <h4 class="section-title">Giá trị đơn hàng</h4>
                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                <li>
                                    <span class="total-fee">Tổng số lượng</span>
                                    <span class="total">Tổng đơn hàng</span>
                                </li>
                                <li>
                                    <span class="total-fee">
                                        <b class="amount"></b>
                                    </span>
                                    <span class="total">
                                        <h5 class="total_cart text-danger">Tổng tiền</h5>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            {!! Form::label('created_at', 'Thời gian', ['class' => 'title']) !!}
                            {!! Form::text('created_at', null, ['class' => 'form-control','id' => 'created_at',
                            'placeholder' => 'Thời gian',
                            'disabled' => 'disabled']) !!}
                        </div>
                        <div class="col-sm-6 form-group">
                            {!! Form::label('updated_at', 'Cập nhật gần nhất', ['class' => 'title']) !!}
                            {!! Form::text('updated_at', null, ['class' => 'form-control','id' => 'updated_at',
                            'placeholder' => 'Cập nhật gần nhất',
                            'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    <input type="submit" class="btn btn-success" value="Cập nhật">
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function updateData(id) {
    var data = {
        id: id,
        _token: '{{ csrf_token() }}'
    };
    
    $.ajax({
        url: "dashboard/detail/" + id,
        method: "POST",
        data: data,
        dataType: "json",
        success: function(data) {
            // alert('oke');
            console.log(data);
            $("#id_update").attr("action", "dashboard/update/" + data.id);
            $(".customer").text(data.fullname);
            $("#fullname").val(data.fullname);
            $(".code_bill").text(data.code_bill);
            $(".address").text(data.address + ' | ' + data.phone);
            $(".code_bill").text(data.code_bill);
            $(".method_pay").text(data.method_pay);
            $(".note").text(data.note);
            $(".total_cart").text(data.total);
            $(".amount").text(data.amount);
            $(".email").text(data.email);
            $('select[name="progress"]').val(data.progress);

            const productData = data.product;
            const table = document.querySelector('.table.info-exhibition tbody');
            table.innerHTML = '';

// Kiểm tra xem productData là một đối tượng
if (typeof productData === 'object' && productData !== null) {
  let index = 1;

  for (const key in productData) {
    if (productData.hasOwnProperty(key)) {
      const item = productData[key];

      // Tạo một hàng bảng mới
      const row = document.createElement('tr');

      // Tạo các ô bảng và thiết lập nội dung cho chúng
      const sttCell = document.createElement('td');
      sttCell.textContent = index;
      row.appendChild(sttCell);

      const imgCell = document.createElement('td');
      const img = document.createElement('img');
      img.src = "http://localhost/LaravelPro/TQStore//" + item.options.thumb_main;
      img.width = 50;
      img.alt = 'error';
      imgCell.appendChild(img);
      row.appendChild(imgCell);

      const MAX_NAME_LENGTH = 30; // Giới hạn độ dài tên sản phẩm

const nameCell = document.createElement('td');
nameCell.textContent = item.name.length > MAX_NAME_LENGTH ? item.name.substring(0, MAX_NAME_LENGTH) + '...' : item.name;
row.appendChild(nameCell);

      const priceCell = document.createElement('td');
      var formattedPrice = item.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
      priceCell.textContent = formattedPrice;
      row.appendChild(priceCell);

      // Tiếp tục tạo các ô bảng và thiết lập nội dung cho chúng (phần còn lại)
      const qtyCell = document.createElement('td');
qtyCell.textContent = item.qty;
row.appendChild(qtyCell);

const subtotalCell = document.createElement('td');
subtotalCell.textContent = parseFloat(item.subtotal).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' , minimumFractionDigits: 0,
  maximumFractionDigits: 0});
row.appendChild(subtotalCell);
      // Thêm hàng vào bảng
      table.appendChild(row);

      index++;
    }
  }
} else {
  console.error("data.product is not an object.");
}
            
            $("#creator").val(data.creator);
            
            var createdAt = new Date(data.created_at);
            var formattedCreatedAt = createdAt.toLocaleString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
            var updatedAt = new Date(data.updated_at);
            var formattedUpdatedAt = updatedAt.toLocaleString("en-US", { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
            $("#created_at").val(formattedCreatedAt);
            $("#updated_at").val(formattedUpdatedAt);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        },
    });
}

$(document).ready(function() {
    // alert('oke')
    $(".btn-edit").click(function() {
        var id = $(this).attr("data-id");
        updateData(id);
    });
});

function count() {
    var price = document.getElementById('old_price').value;
    var discount = document.getElementById('discount').value;
    var new_price1 = price * discount / 100;
    var new_price = price - new_price1;
    console.log(discount)
    if (discount > 100) {
        alert('Không thể giảm giá vượt quá 100% giá trị sản phẩm')
    } else if (discount < 0) {
        alert('Không thể giảm giá thấp hơn 0%')
    } else {
        document.getElementById('new_price').value = new_price
    }
}
</script>
@endsection