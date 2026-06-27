@extends('layouts.client')
@section('content')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0"
    nonce="67vbHzoI"></script>
<style>
    #myContent-minigame {
        background: url("https://anhdep123.com/109-hinh-anh-phong-canh-ve-thien-nhien-dep-hung-vi/hinh-anh-phong-canh-dep/");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        padding: 0px 0px 20px 0px
    }

    #listReward li {
        margin: 0px 5px;
        border: 1px solid #fff;
    }

    #listReward li img {
        transition: all 0.3s;
        max-width: 100%;
    }

    #listReward li:hover img {
        transform: translateY(-10px);
        margin: 0px auto;
    }

    #wp-exchange {
        background: #fff;
        text-align: center;
        font-size: 18px
    }

    #wp-register {
        color: #fff;
        border: 1px solid #fff;
        padding: 60px 30px;
        margin-top: 30px;
        border-radius: 10px;

    }

    .modal {
        color: black;
    }

    .modal-body {
        line-height: 30px;
    }

    .swal2-popup {
        color: black;
    }

    #wp-gift {
        display: flex;
        justify-content: center;
    }

    .modal-body img {
        width: 60%;
        margin: 0px auto;

    }
</style>
<section id="myContent-minigame">
    <div class="container">
        <div class="col-md-12">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="" class="text-white">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="" class="text-white">Đổi điểm lấy cây</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="titleMinigame">
            <h1 class="fs-2 text-center fw-bold text-white bg-secondary py-2 rounded">
                ĐỔI PHẾ LIỆU LẤY CÂY XANH
            </h1>
            <div class="row my-2">
                <div class="col-xl-4">
                    <style>
                        #wp-rules {
                            font-weight: 500;
                            line-height: 25px
                        }
                    </style>
                    <div id="wp-rules" class="bg-white p-2 rounded">
                        <h2 class="text-center text-danger fw-bold py-2">THỂ LỆ CHƯƠNG TRÌNH</h2>
                        <p>Chương trình "<span class="fw-bold">Đổi Phế Liệu Lấy Cây</span> 🌴"</p>
                        <p>Nhằm khuyến khích và hỗ trợ cộng đồng trong việc tái chế và bảo vệ môi trường.</p>
                        <p>Thời gian tham gia chương trình: Từ <span class="fw-bold">[25/07/2023]</span> đến <span
                                class="fw-bold">[01/08/2023]</span>.</p>
                        <p>Nội dung chương trình: Tích điểm thông qua việc đổi phế liệu.</p>
                        <div class="py-2">
                            <p>Quy định điểm đổi:</p>
                            <ul class="text-success fw-bold">
                                <li>1kg phế liệu = 150 điểm</li>
                                <li>2kg phế liệu = 300 điểm</li>
                                <li>5kg phế liệu = 750 điểm</li>
                                <li>10kg phế liệu = 1500 điểm</li>
                                <li>20kg phế liệu = 3000 điểm</li>
                            </ul>
                        </div>
                        <p class="my-1"><span class="fw-bold">Cách tính điểm:</span> Đối tượng tham gia chương trình
                            mang phế liệu đến trạm thu gom
                            để cân và tính
                            điểm tương ứng.</p>
                        <p class="my-1"><span class="fw-bold">Cách đổi quà:</span> Người tham gia chương trình có thể
                            đổi điểm thành các món quà ngay
                            trên website
                        </p>
                        <p class="my-1">Mỗi địa điểm đổi quà có số lượng quà và mức điểm tương ứng quy định. Khi hết
                            quà, chương
                            trình sẽ kết thúc sớm hơn dự kiến.</p>
                        <p class="my-1">Mỗi người tham gia chương trình chỉ được đổi quà một lần mỗi <span
                                class="fw-bold">30</span> ngày.</p>
                        <p class="my-1">Chương trình không áp dụng đổi điểm thành tiền mặt hoặc chuyển nhượng điểm cho
                            người khác.
                        </p>
                        <div class="btn-society my-2">
                            <div class="btn-like d-block">
                                <div class="fb-like" data-href="https://quan.unitopcv.com/DevChampion/" data-width="200"
                                    data-layout="" data-action="" data-size="" data-share="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <ul id="listReward" class="d-flex">
                        <div class="row">
                            @foreach ($listGifts as $gift)
                            <div class="col-12 col-md-4">
                                <li class="my-2">
                                    <img src="{{asset($gift->thumb)}}" alt="" width="300px" height="300px">
                                    <div id="wp-exchange">
                                        <p class="p-2 d-block fw-bold text-danger">{{$gift->points}} Points</p>
                                        <button style="cursor: pointer;" data-id="{{$gift->id}}"
                                            class="p-2 d-inline-block btn btn-success mb-2 btn-changeGift fw-bold text-white"
                                            onclick="return handleButtonClick({{$gift->id}})">Đổi quà</button>
                                    </div>
                                </li>
                            </div>
                            @endForeach
                        </div>
                    </ul>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="wp-register">
                                <h2 class="text-center fs-4 mb-4">FORM ĐĂNG KÝ GỬI PHẾ LIỆU</h2>
                                <div class="form-group">
                                    <div class="my-2">Nhập vào khối lượng phế thải tái chế muốn gửi (KG)</div>
                                    <form action="{{route('client.changePoints.handle')}}" method="POST" class="d-flex">
                                        @csrf
                                        <input type="number" min="0" name="amount" class="form-control"
                                            placeholder="KG">
                                        <input type="submit" value="Đăng kí" class="btn btn-success ms-2">

                                    </form>
                                    @error('amount')
                                    <small class="text-white d-block my-2">{{$message}}</small>
                                    @enderror
                                    @if (session('status'))
                                    <div class="{{session('color')?session('color'):'alert-success'}} alert mt-2">
                                        <b>{{session('status')}}</b>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade modal-centered-vertical" id="exampleModalLong" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-success fs-5 fw-bold" id="exampleModalLongTitle">Chúc mừng bạn đã đổi quà
                    thành công!
                </h1>
                <a class="close">
                    <span aria-hidden="true" class="btn btn-danger">Cris Store</span>
                </a>
            </div>
            <div class="modal-body">
                <div id="wp-gift">
                    <img src="" alt="Ảnh gift" id="thumbGift">
                </div>
                <p class="text-center text-success">Mã phần quà: <span id="codeGift" class="fw-bold text-black"></span>
                </p>
                <p class="text-center">Hãy lưu lại mã này và mang đến <b>Cris Store</b> để nhận thưởng ngay!</p>
                <div class="my-2">
                    <p>Point cũ: <b id="pointOld"></b></p>
                    <p>Point cây: <b id="price"></b></p>
                    <p class="text-danger">Còn lại: <b id="pointsCurrent"></b> Point</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="HideDelayedModal()"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showDelayedModal() {
    $('#exampleModalLong').modal('show');
     }
    function HideDelayedModal() {
    $('#exampleModalLong').modal('hide');
    location.reload();
    }

    function updateData(id) {
  var data = {
    id: id,
    _token: '{{ csrf_token() }}'
  };
  
  $.ajax({
    url: "changeGift/" + id,
    method: "POST",
    data: data,
    dataType: "json",
    success: function(data) {
      if (data.flagError == true) {
        location.reload();
      }
      if (data.flagLogin == false) {
        location.reload();
      }else{
        $("#thumbGift").attr("src", asset(data.thumb));
        $("#codeGift").text(data.codeGift);
        $("#pointOld").text(data.pointOld);
        $("#price").text(data.price);
        $("#pointsCurrent").text(data.pointsCurrent);
        
        showDelayedModal();
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
    },
  });
}


function handleButtonClick(id) {
    
    const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-1",
                    cancelButton: "btn btn-danger m-1",
                },
                buttonsStyling: false,
            });
    
            swalWithBootstrapButtons
                .fire({
                    title: "Xác nhận đổi quà",
                    text: "Bạn có chắc chắn muốn đổi phần quà này?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Xác nhận đổi",
                    cancelButtonText: "Suy nghĩ thêm",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        updateData(id);
                    }else{
                   return false;
                    }
                });
}
</script>

@endsection