# Hệ Thống Quản Lý Ảnh Sản Phẩm Theo Màu/Size

## 📋 Tổng Quan

Hệ thống mới cho phép:
1. **Tải ảnh khác nhau cho mỗi tổ hợp màu/size**
2. **Tự động hiển thị ảnh phù hợp khi khách chọn màu/size**
3. **Quản lý toàn bộ ảnh sản phẩm trong admin**
4. **Tương thích với hệ thống ảnh cũ (thumb_main, thumb_detail)**

---

## 🗄️ Cơ Sở Dữ Liệu

### Bảng Mới: `product_images`

```sql
CREATE TABLE product_images (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL,
    color_id BIGINT NULLABLE,           -- NULL = áp dụng cho tất cả màu
    config_id BIGINT NULLABLE,          -- NULL = áp dụng cho tất cả size
    image_path VARCHAR(255),            -- ví dụ: uploads/sp1-main.jpg
    display_order INT DEFAULT 0,        -- Thứ tự hiển thị
    is_main BOOLEAN DEFAULT FALSE,      -- Ảnh chính
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (color_id) REFERENCES colors(id) ON DELETE CASCADE,
    FOREIGN KEY (config_id) REFERENCES configs(id) ON DELETE CASCADE,
    
    INDEX idx_product (product_id),
    INDEX idx_product_color (product_id, color_id),
    INDEX idx_product_config (product_id, config_id),
    INDEX idx_combination (product_id, color_id, config_id)
);
```

### Quan Hệ Dữ Liệu

```
Products
  ↓
ProductImages (many)
  ├─→ Colors (optional)
  └─→ Configs (Sizes) (optional)
```

---

## 📦 Models

### ProductImage Model
**File:** `app/ProductImage.php`

**Methods Chính:**
```php
// Lấy ảnh cho sản phẩm/màu/size
ProductImage::getImagesForProductColorConfig($productId, $colorId, $configId)

// Lấy ảnh chính
ProductImage::getMainImageForCombination($productId, $colorId, $configId)

// Queries
$product->images()                           // Tất cả ảnh của sản phẩm
$product->getImagesForColorConfig(1, 2)    // Ảnh cho màu 1, size 2
```

### Product Model Updates
**File:** `app/Product.php`

```php
// New relationships
$product->images()                           // hasMany ProductImages
$product->getImagesForColorConfig($colorId, $configId)
$product->getMainImageForColorConfig($colorId, $configId)
```

---

## 🔌 API Endpoints

### 1. Upload Images
```
POST /api/product-images/upload

Parameters:
- product_id (required)
- color_id (optional)
- config_id (optional)
- images[] (required, multiple files)

Response:
{
    "success": true,
    "message": "Tải ảnh lên thành công",
    "images": [...]
}
```

### 2. Get Product Images
```
GET /api/product-images/{productId}?color_id={colorId}&config_id={configId}

Response:
{
    "success": true,
    "images": [
        {
            "id": 1,
            "path": "uploads/...",
            "color_id": null,
            "config_id": null,
            "is_main": true,
            "display_order": 0,
            "url": "http://..."
        }
    ]
}
```

### 3. Delete Image
```
DELETE /api/product-images/{imageId}
```

### 4. Set as Main
```
POST /api/product-images/{imageId}/set-main
```

### 5. Get Product Combinations
```
GET /api/products/{productId}/combinations

Response:
{
    "success": true,
    "combinations": [
        {
            "label": "Mặc định (tất cả màu/size)",
            "color_id": null,
            "config_id": null
        },
        {
            "label": "Màu: Đỏ",
            "color_id": 1,
            "config_id": null
        },
        ...
    ]
}
```

---

## 🛠️ Artisan Commands

### 1. Migrate Old Images
Chuyển ảnh từ `thumb_main` và `thumb_detail` sang bảng mới:

```bash
php artisan products:migrate-images
```

**Output:**
```
✓ Sản phẩm #75 (Nike Mercurial) - 5 ảnh
✓ Sản phẩm #76 (Real Madrid) - 3 ảnh
⊘ Sản phẩm #77 - không có ảnh để migrate

✓ Đã migrate: 50 sản phẩm
⊘ Bỏ qua: 5 sản phẩm
```

### 2. Sync Colors & Configs
Tự động liên kết màu/size cho sản phẩm:

```bash
# Đồng bộ tất cả sản phẩm
php artisan products:sync-colors-configs --all

# Đồng bộ sản phẩm cụ thể
php artisan products:sync-colors-configs --product-id=75
```

### 3. Fix Product Images (Legacy)
```bash
php artisan products:fix-images
```

---

## 📱 Frontend Integration

### 1. Thêm vào Product Detail View

**File:** `resources/views/client/product/detail.blade.php`

```blade
<!-- Existing code ... -->

<!-- Thêm phần này để load ảnh động -->
@include('client.product.dynamic-images')
```

### 2. Script Tự Động Tải Ảnh

**File:** `resources/views/client/product/dynamic-images.blade.php`

Tự động:
- Lắng nghe sự kiện chọn size/màu
- Load ảnh từ API
- Cập nhật ảnh chính và carousel

---

## 🎯 Admin Interface

### Thêm Manager Ảnh vào Product Edit

**File:** `resources/views/admin/product/update.blade.php`

```blade
<!-- Existing form fields ... -->

<!-- Thêm phần quản lý ảnh -->
<div class="card mt-4">
    <input type="hidden" id="product-id" value="{{ $product->id }}" />
    @include('admin.product.images-manager')
</div>

<!-- Thêm token CSRF -->
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### Tính Năng Manager

- 📑 Tabs cho mỗi tổ hợp màu/size
- 📤 Upload nhiều ảnh
- 🖼️ Preview thumbnail
- ⭐ Đặt ảnh chính
- 🗑️ Xóa ảnh
- ⬆️⬇️ Sắp xếp thứ tự

---

## 🚀 Hướng Dẫn Sử Dụng

### Step 1: Chạy Migration
```bash
php artisan migrate
```

### Step 2: Đồng Bộ Ảnh Cũ (Nếu Có)
```bash
php artisan products:migrate-images
```

### Step 3: Đồng Bộ Màu & Size
```bash
php artisan products:sync-colors-configs --all
```

### Step 4: Cập Nhật Admin View
Thêm `images-manager` vào trang edit sản phẩm

### Step 5: Cập Nhật Client View
Thêm `dynamic-images` vào trang chi tiết sản phẩm

---

## 💡 Ví Dụ Thực Tế

### Tải Ảnh Cho Một Tổ Hợp Cụ Thể

```javascript
// Giả sử: Sản phẩm #75, Màu đỏ (ID=1), Size 40 (ID=6)
const formData = new FormData();
formData.append('product_id', 75);
formData.append('color_id', 1);
formData.append('config_id', 6);
formData.append('images[]', file1);
formData.append('images[]', file2);

fetch('/api/product-images/upload', {
    method: 'POST',
    body: formData,
    headers: {
        'Authorization': `Bearer ${token}`,
        'X-CSRF-TOKEN': csrfToken
    }
}).then(res => res.json()).then(data => {
    if (data.success) {
        console.log('Tải thành công:', data.images);
    }
});
```

### Lấy Ảnh Khi Khách Chọn Màu/Size

```javascript
// Khi khách chọn màu đỏ và size 40
fetch('/api/product-images/75?color_id=1&config_id=6')
    .then(res => res.json())
    .then(data => {
        // data.images chứa ảnh phù hợp
        // Nếu không có ảnh cụ thể cho màu 1:
        //   - Sẽ lấy ảnh của (null, 6) - size 40 chung
        //   - Hoặc ảnh của (1, null) - màu 1 chung
        //   - Hoặc ảnh của (null, null) - ảnh mặc định
    });
```

---

## 🔍 Logic Lựa Chọn Ảnh

Khi lấy ảnh cho kombinasi (màu X, size Y):

1. **Ưu tiên 1**: Ảnh có `color_id = X AND config_id = Y`
2. **Ưu tiên 2**: Ảnh có `color_id = X AND config_id = NULL` (tất cả size)
3. **Ưu tiên 3**: Ảnh có `color_id = NULL AND config_id = Y` (tất cả màu)
4. **Ưu tiên 4**: Ảnh có `color_id = NULL AND config_id = NULL` (ảnh mặc định)

---

## ⚠️ Lưu Ý

- **Tương thích ngược**: `thumb_main` và `thumb_detail` vẫn tồn tại, không bị xóa
- **Migration không bắt buộc**: Hệ thống cũ vẫn hoạt động bình thường
- **Performance**: Sử dụng indexes để query nhanh
- **File Management**: Ảnh cũ không bị xóa tự động khi xóa ProductImage record

---

## 🧪 Testing

### Test Upload
```php
$response = $this->post('/api/product-images/upload', [
    'product_id' => 75,
    'color_id' => 1,
    'config_id' => 6,
    'images' => [
        UploadedFile::fake()->image('image1.jpg'),
        UploadedFile::fake()->image('image2.jpg'),
    ]
]);

$response->assertJsonStructure(['success', 'images']);
```

### Test Get Images
```php
$response = $this->get('/api/product-images/75?color_id=1&config_id=6');
$response->assertJsonStructure(['success', 'images']);
```

---

## 📚 Files Tạo/Cập Nhật

| File | Loại | Mô Tả |
|------|------|-------|
| `database/migrations/2026_06_23_000000_create_product_images_table.php` | Migration | Tạo bảng product_images |
| `app/ProductImage.php` | Model | Model ProductImage |
| `app/Http/Controllers/ProductImageController.php` | Controller | API endpoints |
| `app/Console/Commands/MigrateProductImagesToNewTable.php` | Command | Migrate ảnh cũ |
| `app/Console/Commands/SyncProductColorsAndConfigs.php` | Command | Sync màu/size |
| `resources/views/admin/product/images-manager.blade.php` | View | Admin image manager |
| `resources/views/client/product/dynamic-images.blade.php` | View | Frontend dynamic images |
| `routes/api.php` | Routes | API routes (updated) |
| `app/Product.php` | Model | Updated với relationships |

---

**Phiên bản:** 1.0  
**Ngày cập nhật:** 2026-06-23  
**Status:** ✅ Sẵn sàng sử dụng
