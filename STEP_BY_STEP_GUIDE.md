# 🎓 Hướng Dẫn Sử Dụng Chi Tiết - Step by Step

## Phase 1: Cài Đặt Backend (15 phút)

### Step 1.1: Chạy Migration
```bash
cd d:\code\ website\cris-store-main\ (1)\cris-store-main
php artisan migrate
```

**Kết quả mong đợi:**
```
Migrating: 2026_06_23_000000_create_product_images_table
Migrated: 2026_06_23_000000_create_product_images_table (0.12s)
```

**Cách kiểm tra:**
```bash
php artisan tinker
>>> Schema::hasTable('product_images')
=> true
```

---

### Step 1.2: Migrate Ảnh Cũ (Tùy Chọn)
Nếu bạn có ảnh từ hệ thống cũ:

```bash
php artisan products:migrate-images
```

**Kết quả mong đợi:**
```
✓ Sản phẩm #75 (Nike Mercurial) - 5 ảnh
✓ Sản phẩm #76 (Real Madrid) - 3 ảnh
✓ Đã migrate: 50 sản phẩm
⊘ Bỏ qua: 5 sản phẩm

Hoàn thành!
```

---

### Step 1.3: Đồng Bộ Màu & Size
```bash
php artisan products:sync-colors-configs --all
```

**Kết quả mong đợi:**
```
Đang đồng bộ tất cả sản phẩm...
✓ Sản phẩm #75 (Nike Mercurial)
✓ Sản phẩm #76 (Real Madrid)
✓ Sản phẩm #77 (Barcelona)
...
✓ Đã đồng bộ 50 sản phẩm
```

---

## Phase 2: Cập Nhật Admin (5 phút)

### Step 2.1: Mở File Admin Product Update
**File:** `resources/views/admin/product/update.blade.php`

Tìm dòng cuối cùng của form (khoảng dòng 200-300):
```blade
</form>
```

### Step 2.2: Thêm Code Sau Form
```blade
<!-- CSRF Token cho AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Hidden Product ID -->
<input type="hidden" id="product-id" value="{{ $product->id }}" />

<!-- Image Manager Section -->
<div class="card mt-4">
    <div class="card-header">
        <h5>📸 Quản Lý Ảnh Theo Màu/Size</h5>
    </div>
    <div class="card-body">
        @include('admin.product.images-manager')
    </div>
</div>

@include('admin.product.images-manager')
```

### Step 2.3: Lưu File
```
Ctrl + S
```

### Step 2.4: Kiểm Tra
1. Vào trang Edit sản phẩm bất kỳ
2. Scroll xuống dưới
3. Bạn sẽ thấy phần **"Quản Lý Ảnh Theo Màu/Size"**

---

## Phase 3: Cập Nhật Frontend (5 phút)

### Step 3.1: Mở File Product Detail
**File:** `resources/views/client/product/detail.blade.php`

Tìm phần hiển thị ảnh (khoảng dòng 30-40):
```blade
<div class="list_thumb mt-3">
    <div class="owl-carousel owl-theme">
        @foreach ($thumb_detail as $thumb)
        <div class="item">
            <img src="{{ asset($thumb) }}" alt="">
        </div>
        @endforeach
    </div>
</div>
```

### Step 3.2: Thêm Script Động
Sau phần carousel, thêm:
```blade
<!-- Gọi script tự động load ảnh theo color/size -->
@include('client.product.dynamic-images')
```

### Step 3.3: Lưu File
```
Ctrl + S
```

---

## Phase 4: Testing (10 phút)

### Test 4.1: Test Admin Upload

**Bước 1:** Vào Admin → Product → Sửa một sản phẩm
```
http://localhost/admin/product/edit/75
```

**Bước 2:** Scroll xuống tìm **"Quản Lý Ảnh Theo Màu/Size"**

**Bước 3:** Chọn tab (ví dụ: "Màu: Đỏ + Size: 40")

**Bước 4:** Kéo thả ảnh vào upload area HOẶC click để chọn

**Bước 5:** Chọn 2-3 ảnh từ máy tính

**Bước 6:** Click "Tải lên ảnh"

**Kết quả mong đợi:**
```
✓ "Tải ảnh lên thành công"
Ảnh xuất hiện dưới dạng thumbnail
```

---

### Test 4.2: Test Frontend Display

**Bước 1:** Vào trang chi tiết sản phẩm
```
http://localhost/product/nike-mercurial-vapor-15
```

**Bước 2:** Mở Developer Tools (F12)
```
Tab: Console
```

**Bước 3:** Kiểm tra không có lỗi (sạch sẽ)

**Bước 4:** Chọn size khác
```
Click nút size mới
```

**Kết quả mong đợi:**
- Ảnh chính thay đổi
- Carousel ảnh cập nhật
- Không có lỗi trong console

---

### Test 4.3: Test API Direct

**Bước 1:** Mở Postman HOẶC Terminal

**Bước 2:** Request:
```bash
curl -X GET "http://localhost/api/product-images/75?color_id=1&config_id=6" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Kết quả mong đợi:**
```json
{
  "success": true,
  "images": [
    {
      "id": 1,
      "path": "uploads/...",
      "url": "http://...",
      "is_main": true
    }
  ]
}
```

---

## Phase 5: Sử Dụng Hàng Ngày (Admin)

### Workflow: Upload Ảnh Cho Product Mới

**Bước 1:** Tạo sản phẩm mới
```
Admin → Products → Add Product
- Điền name, price, etc.
- Save product
```

**Bước 2:** Mở sản phẩm vừa tạo
```
Admin → Products → Edit [New Product]
```

**Bước 3:** Scroll tới "Quản Lý Ảnh Theo Màu/Size"

**Bước 4:** Chọn tab combo
- Nếu là mặc định: chọn tab đầu tiên
- Nếu cụ thể: chọn tab "Màu: X + Size: Y"

**Bước 5:** Upload ảnh
```
Kéo thả 4-5 ảnh
Hoặc click để chọn file
```

**Bước 6:** Click "Tải lên ảnh"
```
Chờ loading...
Thấy preview ảnh
```

**Bước 7:** Đặt ảnh chính
```
Click button "Làm chính" trên ảnh muốn
Ảnh sẽ có dấu ✓
```

**Bước 8:** Hoàn thành!
```
Ảnh sẽ tự động hiển thị khi khách chọn color/size
```

---

## Phase 6: Troubleshooting

### Issue 1: Image Manager Không Hiển Thị

**Nguyên nhân:**
- Không có file `images-manager.blade.php`
- Không add `@include` vào template
- Browser cache

**Giải pháp:**
```bash
# Kiểm tra file tồn tại
ls resources/views/admin/product/images-manager.blade.php

# Clear cache
php artisan cache:clear
php artisan view:clear

# Refresh browser (Ctrl + Shift + R)
```

---

### Issue 2: Upload Ảnh Không Hoạt Động

**Nguyên nhân:**
- Token hết hạn
- CORS issues
- File too large

**Giải pháp:**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Check permissions
chmod 755 public/uploads

# Verify CSRF token exists
grep "csrf-token" resources/views/admin/product/update.blade.php
```

---

### Issue 3: Images Không Thay Đổi Khi Chọn Size

**Nguyên nhân:**
- JavaScript error
- API không trả dữ liệu
- Ảnh chưa upload

**Giải pháp:**
```javascript
// Mở console (F12) 
// Chạy test API:
fetch('/api/product-images/75?config_id=6')
  .then(r => r.json())
  .then(d => console.log(d))

// Kiểm tra output
```

---

### Issue 4: Admin Upload Thành Công Nhưng Không Thấy Ảnh

**Nguyên nhân:**
- Lỗi permission trên folder uploads
- File không được save
- Path sai

**Giải pháp:**
```bash
# Check folder exists
ls -la public/uploads/

# Fix permissions
chmod 777 public/uploads/

# Check database
php artisan tinker
>>> use App\ProductImage;
>>> ProductImage::latest()->first()

# Check file
ls -la public/uploads/[filename]
```

---

## Commands Nhanh

### Thường Dùng
```bash
# Check database
php artisan tinker
>>> ProductImage::count()

# Migrate images
php artisan products:migrate-images

# Sync colors/sizes
php artisan products:sync-colors-configs --all

# Fix cấu hình
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Debugging
```bash
# Check routes
php artisan route:list | grep product-images

# Check migrations
php artisan migrate:status

# Generate API documentation
php artisan tinker
>>> \App\Http\Controllers\ProductImageController::class
```

---

## Video/GIF Hướng Dẫn

### Admin Upload
```
1. Vào Edit Product
2. Scroll tới Image Manager
3. Chọn tab Màu/Size
4. Kéo thả ảnh
5. Click Upload
6. Xem preview
7. Click "Làm chính"
8. ✓ Xong
```

### Frontend View
```
1. Vào product detail
2. Thấy carousel ảnh
3. Click size button → Ảnh thay đổi
4. (Nếu có màu) Click màu → Ảnh thay đổi
5. Carousel cập nhật mượt mà
6. ✓ Hoàn hảo
```

---

## Keyboard Shortcuts

| Shortcut | Mục Đích |
|----------|---------|
| `Ctrl + S` | Lưu file |
| `Ctrl + Shift + R` | Hard refresh browser |
| `F12` | Mở developer tools |
| `Ctrl + Shift + Delete` | Clear browser cache |
| `Ctrl + D` | Bookmark |

---

## Performance Tips

1. **Image Size:** Giữ ảnh < 2MB mỗi file
2. **Format:** Dùng JPG hoặc WEBP
3. **Resolution:** 1200x1200px hoặc lớn hơn
4. **Upload:** Mỗi combo tối đa 5-10 ảnh

---

## Best Practices

### ✅ Nên Làm
- ✓ Đặt ảnh chính (is_main) cho mỗi combo
- ✓ Upload 3-4 ảnh chi tiết cho mỗi combo
- ✓ Organize: Ảnh mặc định + ảnh cụ thể
- ✓ Test trước khi đi live

### ❌ Không Nên Làm
- ✗ Upload ảnh > 5MB
- ✗ Ảnh chất lượng kém
- ✗ Quên đặt ảnh chính
- ✗ Upload test images lên production

---

**Version:** 1.0  
**Last Updated:** 2026-06-23  
**Status:** ✅ Sẵn sàng
