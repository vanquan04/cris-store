@extends('layouts.client')
@section('content')
<section id="myContent">
    <div class="container">
        <div class="col-md-12">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('home') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Khách phản hồi</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 sidebar d-none d-md-block">
                @include('inc.sbBlog')
            </div>
            <div class="col-md-9">
                <div class="row">
                    <b class="col-md-12 fs-3 text-center mb-2">PHẢN HỒI KHÁCH HÀNG</b>
                </div>
                <div class="row">
                    <div class="col-md-12 p-0">
                        <form id="form-feedback">
                            <label for=""><b>Đánh giá sao</b></label>
                            <div class="rated my-2 text-warning">
                                @for($i=1; $i <= 5; $i++) <i class="star far fa-star" data-rating="{{$i}}"></i>
                                    @endfor
                                    <input type="hidden" id="selected-rating" name="rating" value="">
                            </div>
                            <div class="form-group">
                                <label for="feedback-content"><b>Nội dung</b></label>
                                <textarea name="feedback-content" id="feedback-content" class="form-control my-2"
                                    cols="20" rows="5"></textarea>
                                <p class="btn-feedback btn btn-secondary" data-id="{{session('clientLogin')}}">Đánh giá
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12 my-2 d-md-flex justify-content-between">
                        <h2 class="fs-3 d-none d-md-block">ĐÁNH GIÁ CỦA KHÁCH HÀNG ({{$averageStar}}/5)</h2>
                        <div class="col-md-4">
                            <form action="" method="POST" class="d-flex">
                                <select name="" id="" class="form-control">
                                    <option value="">--Sắp xếp--</option>
                                    <option value="">Mới nhất</option>
                                    <option value="">Cũ nhất</option>
                                </select>
                                <input type="submit" value="Sắp xếp" class="btn-sort btn btn-secondary ms-2">
                            </form>
                        </div>
                    </div>
                    <hr>
                </div>
                <style>
                    #form-feedback {
                        border: 1px solid rgb(179, 175, 175);
                        padding: 10px;
                        border-radius: 5px;
                    }

                    #list-fb li .row {
                        background: #fff;
                        border-radius: 5px;
                        padding: 10px;
                    }
                </style>
                <ul id="list-fb">
                    @foreach ($feedbacks as $feedback)
                    <li class="my-2">
                        <div class="row">
                            <div class="info-fb d-flex">
                                <img src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg"
                                    alt="" width="50px" class="me-2">
                                <div>
                                    <div class="name fs-5 mb-2"><b><b>{{ optional($feedback->User)->name ?? 'Khách vãng lai' }}</b>
</b></div>
                                    <small>{{$feedback->created_at->format('d/m/Y | H:i')}}</small>
                                </div>
                            </div>
                            <hr>
                            <div class="point">
                                @for($i=1; $i <= $feedback->star; $i++) <i class="star fas fa-star text-warning"
                                        data-rating="{{$i}}">
                                    </i>
                                    @endfor
                            </div>
                            <div class="content-fb my-2">
                                {{$feedback->content}}
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
    const stars = document.querySelectorAll('.rated .star');

stars.forEach(star => {
  star.addEventListener('click', () => {
    const ratingValue = star.getAttribute('data-rating');
    document.getElementById('selected-rating').value = ratingValue;
    // console.log(ratingValue);

    // Reset the style of all stars
    stars.forEach(star => star.classList.remove('fas'));
    stars.forEach(star => star.classList.add('far'));

    // Highlight the selected stars
    for (let i = 1; i <= ratingValue; i++) {
      stars[i - 1].classList.remove('far');
      stars[i - 1].classList.add('fas');
    }
  });
});


function addFeedback(id,content ='',star = '') {
    var data = {
        id: id,
        content:content,
        star:star,
        _token: '{{ csrf_token() }}'
    };
    console.log(data);
    $.ajax({
    url: "{{ route('client.feedback.add') }}",
    method: "POST",
    data: data,
    dataType: "json",
    success: function(data) {
        // console.log(data);
        if (data.flagLogin == false) {
        location.reload();
      }else{
        var newFeedbackLi = `
            <li class="my-2">
                <div class="row">
                    <div class="info-fb d-flex">
                        <img src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg"
                            alt="" width="50px" class="me-2">
                        <div>
                            <div class="name fs-5 mb-2"><b>${data.fullname}</b></div>
                            <small>${data.created_at}</small>
                        </div>
                    </div>
                    <hr>
                    <div class="point">
                        ${generateStarIcons(data.star)}
                    </div>
                    <div class="content-fb my-2">
                        ${data.content}
                    </div>
                </div>
            </li>
        `;
        }
        // Thêm li mới vào danh sách phản hồi
        $("#list-fb").prepend(newFeedbackLi);
        $("#feedback-content").val(""); 
        $("#selected-rating").val(0);
    },
    error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
    },
});

function generateStarIcons(starCount) {
    var starIcons = '';
    for (var i = 1; i <= starCount; i++) {
        starIcons += '<i class="star fas fa-star text-warning" data-rating="' + i + '"></i> ';
    }
    return starIcons;
}
}

    $(".btn-feedback").click(function() {
        var id = $(this).attr("data-id");
      var content = $("#feedback-content").val();
      var star = $("#selected-rating").val();
if(star){
        addFeedback(id,content,star)
}else{
    alert('Bạn cần chọn số lượng sao!');
}
    });
});

</script>
@endsection