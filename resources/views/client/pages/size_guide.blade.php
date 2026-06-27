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
                            <a href="" title="">Hướng dẫn chọn size</a>
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
                <div class="card p-4 border-0 shadow-sm mb-4">
                    <h1 class="text-center fs-3 fw-bold my-3 text-success">HƯỚNG DẪN CHỌN SIZE GIÀY ĐÁ BÓNG</h1>
                    <p class="text-center text-muted mb-4">Để chọn được đôi giày vừa vặn và thoải mái nhất, vui lòng tham khảo bảng hướng dẫn dưới đây của Cris Store.</p>
                    
                    <h4 class="fw-bold mt-3">1. Cách đo chiều dài bàn chân</h4>
                    <p>Để đo chính xác, bạn nên thực hiện vào cuối ngày khi bàn chân đã nở ra tối đa.</p>
                    <ul>
                        <li><strong>Bước 1:</strong> Đặt một tờ giấy xuống sàn, sát vào tường.</li>
                        <li><strong>Bước 2:</strong> Đặt gót chân của bạn chạm vào tường, đứng thẳng.</li>
                        <li><strong>Bước 3:</strong> Đánh dấu điểm dài nhất của ngón chân (thường là ngón cái hoặc ngón thứ hai).</li>
                        <li><strong>Bước 4:</strong> Đo khoảng cách từ tường đến điểm đã đánh dấu (tính bằng cm).</li>
                    </ul>

                    <h4 class="fw-bold mt-4">2. Bảng quy đổi kích cỡ (Size Chart)</h4>
                    <p><em>Lưu ý: Đối với giày đá bóng, bạn nên cộng thêm 0.5 - 1 cm vào chiều dài chân thực tế để có không gian cho tất (vớ) thể thao dày và tránh đau ngón chân khi thi đấu.</em></p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>Chiều dài chân (cm)</th>
                                    <th>Size EU (Việt Nam)</th>
                                    <th>Size UK</th>
                                    <th>Size US</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>23.5 - 24.0</td>
                                    <td>38</td>
                                    <td>5.5</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td>24.0 - 24.5</td>
                                    <td>39</td>
                                    <td>6</td>
                                    <td>6.5</td>
                                </tr>
                                <tr>
                                    <td>24.5 - 25.0</td>
                                    <td>40</td>
                                    <td>6.5</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td>25.0 - 25.5</td>
                                    <td>41</td>
                                    <td>7.5</td>
                                    <td>8</td>
                                </tr>
                                <tr>
                                    <td>25.5 - 26.0</td>
                                    <td>42</td>
                                    <td>8</td>
                                    <td>8.5</td>
                                </tr>
                                <tr>
                                    <td>26.0 - 26.5</td>
                                    <td>43</td>
                                    <td>9</td>
                                    <td>9.5</td>
                                </tr>
                                <tr>
                                    <td>26.5 - 27.0</td>
                                    <td>44</td>
                                    <td>9.5</td>
                                    <td>10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4 class="fw-bold mt-4">3. Mẹo chọn giày theo form chân</h4>
                    <ul>
                        <li><strong>Chân thon (bè ít):</strong> Phù hợp với hầu hết các dòng giày (Nike Mercurial, Adidas X, Puma Ultra). Bạn có thể chọn đúng size (True to size).</li>
                        <li><strong>Chân bè (rộng ngang):</strong> Nên chọn các dòng giày có form thoải mái như Nike Tiempo, Adidas Copa, hoặc Mizuno. Xem xét tăng thêm 0.5 - 1 size để tránh bị tức hai bên hông bàn chân.</li>
                    </ul>
                    
                    <div class="alert alert-info mt-4" role="alert">
                        <strong><i class="fas fa-headset me-2"></i>Cần hỗ trợ thêm?</strong> Nếu bạn vẫn băn khoăn chưa biết chọn size nào, đừng ngần ngại liên hệ với <strong>Cris Store</strong> qua số Hotline/Zalo: <strong>0325994526</strong> để được tư vấn viên hỗ trợ tận tình nhé!
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
