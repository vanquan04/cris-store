# 🎨 Cập Nhật Hệ Thống Quản Lý Ảnh Sản Phẩm

## ✨ Tính Năng Mới

### ✅ Tải Ảnh Riêng Cho Từng Màu/Size
- Mỗi kombinasi **màu + size** có thể có ảnh riêng
- Ảnh "mặc định" áp dụng cho nhiều tổ hợp

### ✅ Hiển Thị Ảnh Động
- Khi khách hàng chọn **màu**, ảnh tự động thay đổi
- Khi khách hàng chọn **size**, ảnh tự động thay đổi
- Mượt mà, không cần refresh trang

### ✅ Quản Lý Admin Dễ Dàng
- Tab riêng cho mỗi tổ hợp màu/size
- Upload/xóa ảnh trực tiếp
- Đặt ảnh chính cho từng kombinasi

### ✅ Tương Thích Ngược
- Hệ thống cũ (`thumb_main`, `thumb_detail`) vẫn hoạt động
- Có thể chuyển đổi dần

---

## 🚀 Bắt Đầu Nhanh

### 1️⃣ Chạy Migration
```bash
php artisan migrate
```

### 2️⃣ Đồng Bộ Ảnh Cũ (Tùy Chọn)
Nếu có ảnh từ hệ thống cũ:
```bash
php artisan products:migrate-images
```

### 3️⃣ Đồng Bộ Màu & Size
```bash
php artisan products:sync-colors-configs --all
```

### 4️⃣ Sử Dụng Admin
- Vào trang **Sửa sản phẩm**
- Tìm phần **"Quản lý ảnh theo màu/size"**
- Chọn tab màu/size muốn upload
- Tải ảnh lên

### 5️⃣ Client Tự Động Cập Nhật
- Ảnh thay đổi tự động khi khách chọn màu/size
- Không cần làm gì thêm!

---

## 📊 Cơ Sở Dữ Liệu

### Bảng Mới
**`product_images`** - Lưu trữ ảnh sản phẩm
- Liên kết với sản phẩm, màu, size
- Hỗ trợ sắp xếp, đặt ảnh chính

### Không Thay Đổi
- `products` - Giữ `thumb_main`, `thumb_detail` (backward compatible)
- `colors` - Không thay đổi
- `configs` - Không thay đổi

---

## 🎯 Tính Năng Chi Tiết

### Admin Interface
| Tính Năng | Mô Tả |
|-----------|-------|
| 📑 **Tab Combo** | Mỗi màu/size combo có 1 tab |
| 📤 **Upload Ảnh** | Chọn nhiều file, tải cùng lúc |
| 🖼️ **Preview** | Xem ảnh đã tải |
| ⭐ **Ảnh Chính** | Chỉ định ảnh hiển thị đầu tiên |
| 🗑️ **Xóa** | Xóa ảnh không cần thiết |
| ⬆️⬇️ **Sắp Xếp** | Thay đổi thứ tự hiển thị |

### Client Interface  
- Ảnh thay đổi theo lựa chọn
- Carousel ảnh cập nhật
- Mượt mà, không delay

---

## 💻 API (Cho Developer)

### Upload Ảnh
```javascript
POST /api/product-images/upload
{
    product_id: 75,
    color_id: 1,        // Optional
    config_id: 6,       // Optional
    images: [file1, file2]
}
```

### Lấy Ảnh
```javascript
GET /api/product-images/75?color_id=1&config_id=6
```

### Xóa Ảnh
```javascript
DELETE /api/product-images/{imageId}
```

### Đặt Ảnh Chính
```javascript
POST /api/product-images/{imageId}/set-main
```

---

## 🛠️ Commands

### Migrate Ảnh Cũ
```bash
php artisan products:migrate-images
```

### Đồng Bộ Màu & Size
```bash
php artisan products:sync-colors-configs --all
php artisan products:sync-colors-configs --product-id=75
```

### Fix Ảnh (Legacy)
```bash
php artisan products:fix-images
```

---

## 📝 Cấu Trúc Ảnh

### Lựa Chọn Ảnh Theo Độ Ưu Tiên

```
1. Có màu AND size riêng
    ↓ (Không có)
2. Có màu riêng (tất cả size)
    ↓ (Không có)
3. Có size riêng (tất cả màu)
    ↓ (Không có)
4. Ảnh mặc định (tất cả màu/size)
```

**Ví dụ:**
- Khách chọn **Màu đỏ, Size 40**
- Hệ thống tìm ảnh:
  1. Ảnh (Đỏ + 40) ← **Tìm thấy**, sử dụng
  2. Nếu không có → Ảnh (Đỏ + bất kỳ)
  3. Nếu không có → Ảnh (bất kỳ + 40)
  4. Nếu không có → Ảnh mặc định

---

## 🧪 Kiểm Tra

### Xem Ảnh Sản Phẩm
```bash
php artisan tinker
>>> use App\ProductImage;
>>> ProductImage::where('product_id', 75)->count()
>>> ProductImage::getImagesForProductColorConfig(75, 1, 6)
```

### Test API
```bash
curl -X GET "http://localhost/api/product-images/75?color_id=1&config_id=6" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📚 Tài Liệu Đầy Đủ

Xem chi tiết: **`PRODUCT_IMAGES_COLOR_SIZE_SYSTEM.md`**

---

## ❓ Câu Hỏi Thường Gặp

**Q: Ảnh cũ có bị mất không?**
A: Không! `thumb_main` và `thumb_detail` vẫn tồn tại. Hệ thống cũ vẫn hoạt động.

**Q: Có bắt buộc sử dụng hệ thống mới không?**
A: Không. Hệ thống cũ vẫn hoạt động bình thường. Hãy migrate dần khi sẵn sàng.

**Q: Có ảnh hưởng đến performance không?**
A: Không. Sử dụng indexes để query nhanh. Thậm chí có thể nhanh hơn.

**Q: Làm sao để rollback?**
A: `php artisan migrate:rollback`

---

**Status:** ✅ Sẵn sàng sử dụng  
**Version:** 1.0  
**Updated:** 2026-06-23
