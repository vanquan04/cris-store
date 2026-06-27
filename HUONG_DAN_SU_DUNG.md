# Hướng Dẫn Sử Dụng và Cài Đặt Dự Án (Cris Store)

Dự án này được xây dựng dựa trên framework **Laravel**. Dưới đây là các bước cơ bản để cài đặt và chạy dự án trên môi trường local (máy tính cá nhân), cũng như hướng dẫn đẩy code lên GitHub.

---

## 1. Yêu cầu hệ thống (Prerequisites)
Trước khi bắt đầu, đảm bảo máy tính của bạn đã cài đặt các phần mềm sau:
- **PHP** (Phiên bản >= 7.3 hoặc 8.x tuỳ theo cấu hình dự án của bạn)
- **Composer** (Trình quản lý package của PHP)
- **Node.js và npm** (Để biên dịch các tài nguyên frontend như CSS, JS)
- **MySQL** hoặc bất kỳ hệ quản trị cơ sở dữ liệu nào bạn muốn dùng (có thể dùng XAMPP, Laragon, hoặc Docker)
- **Git** (Để quản lý phiên bản và đẩy code lên GitHub)

---

## 2. Các bước cài đặt dự án chạy ở Local

### Bước 1: Copy file cấu hình môi trường
Mở terminal tại thư mục dự án và chạy lệnh sau để tạo file `.env` từ `.env.example`:
```bash
cp .env.example .env
```
*(Nếu dùng Windows CMD/PowerShell, bạn có thể copy và đổi tên file `.env.example` thành `.env` thủ công)*

### Bước 2: Cài đặt các thư viện PHP (Composer dependencies)
Chạy lệnh sau để tải về các gói thư viện cần thiết:
```bash
composer install
```

### Bước 3: Cài đặt các thư viện Frontend (NPM dependencies)
Cài đặt thư viện Node.js:
```bash
npm install
```
Sau đó biên dịch các tài nguyên (CSS, JS):
```bash
npm run dev
# Hoặc npm run watch để tự động biên dịch khi có thay đổi
```

### Bước 4: Tạo khoá ứng dụng (App Key)
Tạo Application Key cho Laravel bằng lệnh:
```bash
php artisan key:generate
```

### Bước 5: Cấu hình Cơ sở dữ liệu (Database)
Mở file `.env` vừa được tạo ra ở Bước 1, tìm đến các dòng có tiền tố `DB_` và sửa lại thông tin kết nối tới database của bạn. Ví dụ:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ten_database_cua_ban
DB_USERNAME=root
DB_PASSWORD=mat_khau_cua_ban
```
*(Lưu ý: Bạn cần phải tạo trước một database trống trong MySQL (ví dụ: `ten_database_cua_ban`) bằng phpMyAdmin hoặc DataGrip).*

### Bước 6: Chạy Migration và Seed dữ liệu (nếu có)
Tạo các bảng trong CSDL và thêm dữ liệu mẫu:
```bash
php artisan migrate
php artisan db:seed
```

### Bước 7: Khởi chạy Server
Bây giờ bạn có thể khởi chạy server local của Laravel bằng lệnh:
```bash
php artisan serve
```
Mở trình duyệt và truy cập vào đường dẫn: [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 3. Hướng dẫn Đưa Code lên GitHub

Do hệ thống tự động không thể truy cập trực tiếp vào tài khoản GitHub cá nhân của bạn để tạo repository, bạn hãy làm theo các bước đơn giản sau ở trên máy tính của bạn:

### Bước 1: Tạo Repository mới trên GitHub
1. Đăng nhập vào [GitHub.com](https://github.com/).
2. Nhấn vào nút **"New"** (hoặc dấu `+` góc trên bên phải > "New repository").
3. Nhập tên repository (ví dụ: `cris-store`), chọn Public/Private tuỳ ý.
4. Bỏ qua các tuỳ chọn "Add a README", "Add .gitignore" vì dự án này đã có sẵn.
5. Nhấn **"Create repository"**.

### Bước 2: Đẩy code từ máy tính lên GitHub
Mở Terminal (hoặc Git Bash) tại thư mục chứa dự án `cris-store-main` và chạy lần lượt các lệnh sau:

```bash
# 1. Khởi tạo Git (nếu chưa có)
git init

# 2. Thêm tất cả các file vào theo dõi của Git
git add .

# 3. Tạo commit đầu tiên
git commit -m "Khởi tạo dự án và cập nhật file Hướng dẫn sử dụng"

# 4. Thay đổi nhánh chính thành 'main' (nếu git của bạn đang dùng 'master')
git branch -M main

# 5. Kết nối với Repository trên GitHub của bạn
# (THAY THẾ ĐƯỜNG DẪN DƯỚI ĐÂY BẰNG ĐƯỜNG DẪN REPO CỦA BẠN)
git remote add origin https://github.com/TênNgườiDùngCủaBạn/TênRepoCủaBạn.git

# 6. Đẩy code lên GitHub
git push -u origin main
```

Chúc bạn thành công!
