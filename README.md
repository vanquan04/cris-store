# Cris Store

Đây là mã nguồn hệ thống website thương mại điện tử (e-commerce) được xây dựng dựa trên nền tảng PHP và **Laravel Framework**. Dự án cung cấp các tính năng quản lý sản phẩm, danh mục, đơn hàng, người dùng và các chức năng bán hàng cơ bản.

## 🚀 Tính Năng Chính
- **Quản lý Sản phẩm**: Quản lý thông tin sản phẩm, biến thể (màu sắc, kích thước, ảnh).
- **Quản lý Đơn hàng**: Xem và xử lý các đơn đặt hàng từ khách hàng.
- **Quản lý Người dùng**: Phân quyền hệ thống, quản trị viên và khách hàng.
- **Tối ưu Hóa**: Tối ưu tốc độ tải trang, hình ảnh và cơ sở dữ liệu.

## 🛠️ Yêu Cầu Hệ Thống (Prerequisites)
Đảm bảo máy tính hoặc máy chủ của bạn đã cài đặt sẵn các thành phần sau:
- **PHP** (>= 7.3 hoặc 8.x)
- **Composer**
- **Node.js & NPM**
- **MySQL** hoặc MariaDB
- **Git**

## 💻 Cài Đặt Dự Án Ở Môi Trường Local (Máy cá nhân)

Làm theo các bước sau để chạy dự án trên máy tính của bạn:

**1. Clone dự án về máy**
```bash
git clone https://github.com/vanquan04/cris-store.git
cd cris-store
```

**2. Copy file cấu hình môi trường**
```bash
cp .env.example .env
```
Mở file `.env` và cập nhật các thông số kết nối Database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

**3. Cài đặt các gói thư viện (Dependencies)**
```bash
composer install
npm install
npm run dev
```

**4. Khởi tạo khóa bảo mật (App Key)**
```bash
php artisan key:generate
```

**5. Khởi tạo cơ sở dữ liệu (Migrations & Seeders)**
```bash
php artisan migrate
php artisan db:seed
```

**6. Chạy Server cục bộ**
```bash
php artisan serve
```
Truy cập dự án tại: `http://127.0.0.1:8000`

---
> **Lưu ý**: Bạn có thể tham khảo thêm tệp tin `HUONG_DAN_SU_DUNG.md` trong mã nguồn để biết thêm chi tiết về cách quản trị và xử lý lỗi thường gặp.
