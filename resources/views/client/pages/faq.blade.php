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
                            <a href="" title="">FAQ</a>
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
                <style>
                    #wp-faq ul {
                        padding: 0;
                        list-style: none;
                    }
                    #wp-faq ul li {
                        background: #fff;
                        padding: 14px 18px;
                        border-radius: 8px;
                        margin-bottom: 10px;
                        line-height: 30px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
                        cursor: pointer;
                        border-left: 4px solid #2b5480;
                        transition: box-shadow 0.2s;
                    }
                    #wp-faq ul li:hover {
                        box-shadow: 0 4px 16px rgba(43,84,128,0.15);
                    }
                    #wp-faq img.faq-logo {
                        width: 100px;
                        display: block;
                        margin: 0 auto 10px auto;
                    }
                    .contact-faq {
                        line-height: 32px;
                        background: #f0f4f8;
                        border-radius: 8px;
                        padding: 16px 20px;
                        margin-top: 20px;
                    }
                    .faq-category-title {
                        font-size: 15px;
                        font-weight: 700;
                        color: #2b5480;
                        margin: 22px 0 10px 0;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        border-bottom: 2px solid #e0e8f0;
                        padding-bottom: 6px;
                    }
                    .icon-question {
                        min-width: 30px;
                        text-align: right;
                        color: #2b5480;
                    }
                    .wp-question {
                        width: 100%;
                    }
                    .card.card-body {
                        background: #f8fafc;
                        border: 1px solid #e0e8f0;
                        color: #333;
                        line-height: 1.8;
                    }
                </style>

                <div id="wp-faq">
                    <img class="faq-logo" src="https://cdn-icons-png.flaticon.com/512/5610/5610944.png" alt="FAQ Cris Store">
                    <h1 class="text-center fs-3 fw-bold my-3" style="color:#2b5480;">CÂU HỎI THƯỜNG GẶP</h1>
                    <p class="text-center fs-5 my-2 text-secondary">
                        Dưới đây là những thắc mắc phổ biến về sản phẩm và dịch vụ tại
                        <strong>Cris Store</strong> — Chuyên giày đá bóng chính hãng.<br>
                        Nếu chưa thấy câu trả lời, hãy liên hệ với chúng tôi!
                    </p>

                    {{-- NHÓM 1: SẢN PHẨM --}}
                    <p class="faq-category-title">⚽ Sản phẩm</p>
                    <ul>

                        {{-- Câu hỏi 1 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq1" role="button"
                            aria-expanded="false" aria-controls="faq1">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 1: Giày tại Cris Store có phải hàng chính hãng không?
                                    </b>
                                    <div class="collapse mt-2" id="faq1">
                                        <div class="card card-body">
                                            <strong>Có, 100% sản phẩm tại Cris Store đều là hàng chính hãng.</strong>
                                            Chúng tôi nhập khẩu trực tiếp từ các nhà phân phối ủy quyền của Nike, Adidas, Puma, Mizuno và các thương hiệu lớn khác.
                                            Mỗi đôi giày đều có tem chống hàng giả và hóa đơn mua hàng rõ ràng.
                                            Bạn hoàn toàn có thể yên tâm về chất lượng sản phẩm.
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- Câu hỏi 2 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq2" role="button"
                            aria-expanded="false" aria-controls="faq2">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 2: Cris Store bán những loại đế giày đá bóng nào?
                                    </b>
                                    <div class="collapse mt-2" id="faq2">
                                        <div class="card card-body">
                                            Cris Store cung cấp đầy đủ các loại đế phù hợp với từng loại sân:
                                            <ul class="mt-2">
                                                <li><strong>FG (Firm Ground)</strong> – Sân cỏ tự nhiên cứng, phổ biến nhất</li>
                                                <li><strong>AG (Artificial Ground)</strong> – Sân cỏ nhân tạo thế hệ mới, đinh ngắn phân bổ đều</li>
                                                <li><strong>TF (Turf)</strong> – Sân cỏ nhân tạo sợi ngắn, phổ biến tại Việt Nam</li>
                                                <li><strong>IC (Indoor Court)</strong> – Giày futsal sân trong nhà</li>
                                                <li><strong>SG (Soft Ground)</strong> – Sân cỏ tự nhiên mềm, trơn (đinh vít)</li>
                                            </ul>
                                            Hãy chọn đúng loại đế để đảm bảo hiệu suất và tránh chấn thương!
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- Câu hỏi 3 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq3" role="button"
                            aria-expanded="false" aria-controls="faq3">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 3: Tôi nên chọn size giày đá bóng như thế nào?
                                    </b>
                                    <div class="collapse mt-2" id="faq3">
                                        <div class="card card-body">
                                            Để chọn size giày đá bóng chính xác, bạn nên:
                                            <ul class="mt-2">
                                                <li>Đo chiều dài bàn chân (cm) vào cuối ngày khi chân hơi phù.</li>
                                                <li>Giày đá bóng thường nên mặc vừa sát hơn giày thường khoảng <strong>0.5 size</strong> để kiểm soát bóng tốt hơn.</li>
                                                <li>Nike, Adidas thông thường dùng size EU chuẩn. Mizuno thường nhỏ hơn 0.5 size.</li>
                                                <li>Nếu chân rộng hoặc hẹp, liên hệ tư vấn viên để được hỗ trợ thêm.</li>
                                            </ul>
                                            📞 Hotline tư vấn size: <strong>0325994526</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- NHÓM 2: MUA HÀNG --}}
                        <p class="faq-category-title">🛒 Mua hàng &amp; Thanh toán</p>

                        {{-- Câu hỏi 4 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq4" role="button"
                            aria-expanded="false" aria-controls="faq4">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 4: Cris Store hỗ trợ những hình thức thanh toán nào?
                                    </b>
                                    <div class="collapse mt-2" id="faq4">
                                        <div class="card card-body">
                                            Chúng tôi hỗ trợ các hình thức thanh toán sau:
                                            <ul class="mt-2">
                                                <li><strong>COD</strong> – Thanh toán tiền mặt khi nhận hàng.</li>
                                                <li><strong>VNPay</strong> – Thẻ ATM nội địa, Visa/Mastercard và ví điện tử (Momo, ZaloPay...).</li>
                                                <li><strong>Chuyển khoản ngân hàng</strong> – Liên hệ để nhận thông tin tài khoản.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- Câu hỏi 5 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq5" role="button"
                            aria-expanded="false" aria-controls="faq5">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 5: Làm thế nào để đặt hàng tại Cris Store?
                                    </b>
                                    <div class="collapse mt-2" id="faq5">
                                        <div class="card card-body">
                                            Đặt hàng tại Cris Store rất đơn giản:
                                            <ol class="mt-2">
                                                <li>Chọn sản phẩm → Chọn size và màu sắc → Nhấn <strong>"Thêm vào giỏ hàng"</strong>.</li>
                                                <li>Vào <strong>Giỏ hàng</strong> → Kiểm tra đơn hàng → Nhấn <strong>"Thanh toán"</strong>.</li>
                                                <li>Điền thông tin giao hàng và chọn phương thức thanh toán.</li>
                                                <li>Xác nhận đơn hàng – Bạn sẽ nhận email/SMS xác nhận ngay sau đó.</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- NHÓM 3: VẬN CHUYỂN --}}
                        <p class="faq-category-title">🚚 Vận chuyển &amp; Giao hàng</p>

                        {{-- Câu hỏi 6 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq6" role="button"
                            aria-expanded="false" aria-controls="faq6">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 6: Phí và thời gian giao hàng như thế nào?
                                    </b>
                                    <div class="collapse mt-2" id="faq6">
                                        <div class="card card-body">
                                            <ul class="mt-1">
                                                <li><strong>Miễn phí vận chuyển</strong> toàn quốc cho đơn từ <strong>500.000đ</strong> trở lên.</li>
                                                <li>Đơn dưới 500.000đ: phí theo biểu giá đơn vị vận chuyển.</li>
                                                <li>Nội thành Hà Nội: <strong>1–3 ngày</strong>.</li>
                                                <li>Các tỉnh thành khác: <strong>3–7 ngày</strong>.</li>
                                                <li>Đơn hàng được xử lý và gửi đi trong vòng <strong>24 giờ</strong> sau khi xác nhận.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- Câu hỏi 7 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq7" role="button"
                            aria-expanded="false" aria-controls="faq7">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 7: Tôi có thể theo dõi đơn hàng của mình không?
                                    </b>
                                    <div class="collapse mt-2" id="faq7">
                                        <div class="card card-body">
                                            Có! Sau khi đặt hàng thành công, bạn có thể:
                                            <ul class="mt-2">
                                                <li>Đăng nhập → Vào <strong>"Đơn hàng của bạn"</strong> để xem trạng thái.</li>
                                                <li>Nhận thông báo qua email ở từng giai đoạn: <em>Đã xác nhận → Đang giao → Giao thành công</em>.</li>
                                                <li>Gọi hotline <strong>0325994526</strong> hoặc nhắn tin fanpage để hỗ trợ thêm.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- NHÓM 4: ĐỔI TRẢ & BẢO HÀNH --}}
                        <p class="faq-category-title">🔄 Đổi trả &amp; Bảo hành</p>

                        {{-- Câu hỏi 8 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq8" role="button"
                            aria-expanded="false" aria-controls="faq8">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 8: Chính sách đổi trả của Cris Store như thế nào?
                                    </b>
                                    <div class="collapse mt-2" id="faq8">
                                        <div class="card card-body">
                                            Chúng tôi áp dụng chính sách đổi trả linh hoạt:
                                            <ul class="mt-2">
                                                <li><strong>Thời gian đổi trả: 7 ngày</strong> kể từ ngày nhận hàng.</li>
                                                <li>Điều kiện: lỗi từ nhà sản xuất, giao sai size, sai màu hoặc sai model.</li>
                                                <li>Sản phẩm phải còn nguyên vẹn, chưa qua sử dụng, còn đủ hộp và phụ kiện.</li>
                                                <li>Cris Store chịu 100% phí vận chuyển đổi hàng nếu lỗi từ phía cửa hàng.</li>
                                            </ul>
                                            <em class="text-danger">⚠ Không áp dụng đổi trả với sản phẩm đã qua sử dụng hoặc hư hỏng do tác động bên ngoài.</em>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- Câu hỏi 9 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq9" role="button"
                            aria-expanded="false" aria-controls="faq9">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 9: Giày đá bóng có được bảo hành không?
                                    </b>
                                    <div class="collapse mt-2" id="faq9">
                                        <div class="card card-body">
                                            Tất cả giày chính hãng tại Cris Store đều được bảo hành theo chính sách nhà sản xuất:
                                            <ul class="mt-2">
                                                <li><strong>Nike, Adidas, Puma:</strong> Bảo hành lỗi kỹ thuật trong <strong>6 tháng</strong> kể từ ngày mua.</li>
                                                <li><strong>Mizuno, New Balance:</strong> Bảo hành <strong>3–6 tháng</strong> tùy dòng sản phẩm.</li>
                                                <li>Bảo hành: bong keo đế, bung đường may, lỗi vật liệu thân giày.</li>
                                                <li>Không bảo hành: mòn đế do sử dụng, rách hoặc ngâm nước.</li>
                                            </ul>
                                            💡 Giữ lại hóa đơn mua hàng để thuận tiện trong quá trình bảo hành!
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        {{-- NHÓM 5: CHĂM SÓC --}}
                        <p class="faq-category-title">✨ Chăm sóc &amp; Bảo quản giày</p>

                        {{-- Câu hỏi 10 --}}
                        <li class="row" data-bs-toggle="collapse" href="#faq10" role="button"
                            aria-expanded="false" aria-controls="faq10">
                            <div class="wp-question d-flex justify-content-between">
                                <div style="flex:1;">
                                    <b class="py-1">
                                        <span><i class="fas fa-question-circle text-danger me-1"></i></span>
                                        Câu hỏi 10: Làm thế nào để bảo quản giày đá bóng bền lâu?
                                    </b>
                                    <div class="collapse mt-2" id="faq10">
                                        <div class="card card-body">
                                            Để giày đá bóng bền đẹp và giữ form tốt, bạn nên:
                                            <ul class="mt-2">
                                                <li>Sau khi thi đấu, <strong>vệ sinh ngay</strong> đất cát bám trên đế và thân giày bằng vải mềm ẩm.</li>
                                                <li>Không giặt bằng máy giặt — hãy giặt tay nhẹ nhàng với nước ấm và xà phòng trung tính.</li>
                                                <li>Để khô tự nhiên, <strong>tránh phơi trực tiếp dưới nắng</strong> hoặc sấy nhiệt cao vì sẽ làm biến dạng và bong keo.</li>
                                                <li>Nhét giấy báo hoặc cây giữ form vào giày khi không dùng để giày không nhăn và biến dạng.</li>
                                                <li>Bảo quản ở nơi thoáng mát, tránh ẩm mốc.</li>
                                                <li>Với giày da kangaroo, dùng xi hoặc kem dưỡng da chuyên dụng định kỳ.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-question ps-2">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </li>

                        <div class="contact-faq fs-5 my-3">
                            <p><strong>📞 Bạn còn câu hỏi nào khác? Liên hệ ngay với chúng tôi!</strong></p>
                            <p>🔗 Hotline: <a href="tel:0325994526"><strong>0325994526</strong></a></p>
                            <p>📧 Email: <a href="mailto:quannguyen04082004@gmail.com">quannguyen04082004@gmail.com</a></p>
                            <p>📍 Địa chỉ: Đại học Công nghệ Đông Á, Hà Nội</p>
                            <p>⏰ Hỗ trợ: Thứ 2 – Thứ 7 | 8:00 – 21:00</p>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection