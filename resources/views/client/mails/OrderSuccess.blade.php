<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng {{ $code_bill }}</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#333;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:30px 0;">
    <tr>
        <td align="center">
            <table width="620" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">

                {{-- Header --}}
                <tr>
                    <td style="background:#0f146d;padding:28px 30px;text-align:center;">
                        <h1 style="margin:0;color:#ffffff;font-size:24px;letter-spacing:1px;">CRIS STORE</h1>
                        <p style="margin:6px 0 0;color:#c5c9f5;font-size:13px;">Giày đá bóng chính hãng</p>
                    </td>
                </tr>

                {{-- Order confirmed banner --}}
                <tr>
                    <td style="background:#e8eaf6;padding:18px 30px;text-align:center;border-bottom:3px solid #0f146d;">
                        <p style="margin:0;font-size:16px;color:#0f146d;font-weight:bold;">
                            ✅ Đơn hàng <span style="color:#e53935;">{{ $code_bill }}</span> đã được tiếp nhận!
                        </p>
                        <p style="margin:4px 0 0;font-size:12px;color:#666;">{{ $time }}</p>
                    </td>
                </tr>

                {{-- Greeting --}}
                <tr>
                    <td style="padding:24px 30px 10px;">
                        <p style="margin:0;font-size:15px;">Xin chào <strong>{{ $fullname }}</strong>,</p>
                        <p style="margin:10px 0 0;line-height:1.7;color:#555;">
                            Cảm ơn bạn đã đặt hàng tại <strong>Cris Store</strong>! Đơn hàng của bạn đang được xử lý.
                            Chúng tôi sẽ thông báo ngay khi hàng sẵn sàng giao.
                        </p>
                    </td>
                </tr>

                {{-- Delivery info --}}
                <tr>
                    <td style="padding:16px 30px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9f9f9;border:1px solid #e0e0e0;border-radius:6px;">
                            <tr>
                                <td style="padding:14px 18px;">
                                    <p style="margin:0 0 10px;font-size:13px;font-weight:bold;color:#0f146d;text-transform:uppercase;letter-spacing:0.5px;">
                                        📦 Thông tin giao hàng
                                    </p>
                                    <table width="100%" cellpadding="4" cellspacing="0">
                                        <tr>
                                            <td width="30%" style="color:#777;font-size:13px;">Người nhận:</td>
                                            <td style="font-size:13px;font-weight:bold;">{{ $fullname }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#777;font-size:13px;">Địa chỉ:</td>
                                            <td style="font-size:13px;">{{ $address }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#777;font-size:13px;">Điện thoại:</td>
                                            <td style="font-size:13px;">{{ $phone }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#777;font-size:13px;">Email:</td>
                                            <td style="font-size:13px;">{{ $email }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Product list --}}
                <tr>
                    <td style="padding:4px 30px 16px;">
                        <p style="margin:0 0 12px;font-size:13px;font-weight:bold;color:#0f146d;text-transform:uppercase;letter-spacing:0.5px;">
                            🛒 Sản phẩm đặt mua
                        </p>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e0e0e0;border-radius:6px;overflow:hidden;">
                            <thead>
                                <tr style="background:#0f146d;">
                                    <th style="padding:10px 12px;text-align:left;color:#fff;font-size:12px;font-weight:600;">Sản phẩm</th>
                                    <th style="padding:10px 12px;text-align:center;color:#fff;font-size:12px;font-weight:600;width:50px;">SL</th>
                                    <th style="padding:10px 12px;text-align:right;color:#fff;font-size:12px;font-weight:600;white-space:nowrap;">Đơn giá</th>
                                    <th style="padding:10px 12px;text-align:right;color:#fff;font-size:12px;font-weight:600;white-space:nowrap;">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $index => $item)
                                <tr style="background:{{ $index % 2 === 0 ? '#ffffff' : '#f9f9f9' }};border-top:1px solid #eee;">
                                    <td style="padding:10px 12px;font-size:13px;">
                                        <strong>{{ $item['name'] }}</strong>
                                        @if(!empty($item['field_type']) || !empty($item['color']) || !empty($item['size']))
                                        <br>
                                        <span style="font-size:11px;color:#888;">
                                            @if(!empty($item['field_type']))Đinh: {{ str_replace('Đinh ', '', $item['field_type']) }}@endif
                                            @if(!empty($item['field_type']) && !empty($item['size'])) &nbsp;|&nbsp; @endif
                                            @if(!empty($item['size']))Phân loại: {{ $item['size'] }}@endif
                                        </span>
                                        @endif
                                    </td>
                                    <td style="padding:10px 12px;text-align:center;font-size:13px;">{{ $item['qty'] }}</td>
                                    <td style="padding:10px 12px;text-align:right;font-size:13px;white-space:nowrap;">
                                        {{ number_format($item['price'], 0, '.', '.') }}đ
                                    </td>
                                    <td style="padding:10px 12px;text-align:right;font-size:13px;font-weight:bold;white-space:nowrap;color:#e53935;">
                                        {{ number_format($item['subtotal'], 0, '.', '.') }}đ
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background:#f4f4f4;border-top:2px solid #0f146d;">
                                    <td colspan="3" style="padding:12px;text-align:right;font-size:14px;font-weight:bold;color:#0f146d;">
                                        TỔNG CỘNG:
                                    </td>
                                    <td style="padding:12px;text-align:right;font-size:16px;font-weight:bold;color:#e53935;white-space:nowrap;">
                                        {{ number_format($total, 0, '.', '.') }}đ
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>

                {{-- Note --}}
                <tr>
                    <td style="padding:0 30px 20px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff8e1;border-left:4px solid #ffc107;border-radius:4px;">
                            <tr>
                                <td style="padding:12px 16px;font-size:13px;color:#555;line-height:1.6;">
                                    <strong>⚠️ Lưu ý:</strong> Chỉ nhận hàng khi trạng thái đơn là <strong>"Đang giao hàng"</strong>.
                                    Kiểm tra kỹ mã đơn hàng, thông tin người gửi và mã vận đơn trước khi nhận.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#0f146d;padding:20px 30px;text-align:center;">
                        <p style="margin:0;color:#c5c9f5;font-size:12px;">
                            © {{ date('Y') }} Cris Store &nbsp;|&nbsp; Đại học Công nghệ Đông Á
                        </p>
                        <p style="margin:6px 0 0;color:#c5c9f5;font-size:12px;">
                            📞 0325994526 &nbsp;|&nbsp; ✉️ quannguyen04082004@gmail.com
                        </p>
                        <p style="margin:8px 0 0;color:#8c93d4;font-size:11px;">
                            Email này được gửi tự động. Vui lòng không trả lời trực tiếp.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
