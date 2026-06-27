# 🏗️ Kiến Trúc Hệ Thống - Diagram

## Sơ Đồ Mối Quan Hệ Dữ Liệu

```
┌─────────────────────────────────────────────────────────────────┐
│                      PRODUCTS TABLE                             │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │ id, name, thumb_main, thumb_detail, ... (cũ vẫn tồn tại)│   │
│  └──────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
         │                           │                    │
         │ 1:N                       │ 1:N            1:N
         ▼                           ▼                    ▼
    ┌─────────────┐     ┌──────────────────┐    ┌─────────────────┐
    │   COLORS    │     │  PRODUCT_IMAGES  │    │     CONFIGS     │
    │  (định nghĩa│     │   (MỚI - TẠO)   │    │    (SIZES)      │
    │  từng màu)  │     │                  │    │  (định nghĩa    │
    └─────────────┘     │  - product_id   │    │   từng kích cỡ) │
                        │  - color_id     │    └─────────────────┘
                        │  - config_id    │
                        │  - image_path   │
                        │  - display_order│
                        │  - is_main      │
                        └──────────────────┘
         │      ▲              │      ▲
         │      │              │      │
         └──────┴──────────────┴──────┘
         M:N Relationships (via pivot)
```

---

## Luồng Dữ Liệu - Upload Ảnh

```
ADMIN INTERFACE
     │
     ├─ Select Color/Size Tab
     │     │
     │     ▼
     ├─ Choose Images
     │     │
     │     ▼
     ├─ Click "Upload"
     │     │
     │     ▼
     ├─ FormData {
     │    product_id: 75,
     │    color_id: 1,
     │    config_id: 6,
     │    images: [file1, file2]
     │  }
     │
     ▼
  API: POST /api/product-images/upload
     │
     ▼
  ProductImageController@store
     │
     ├─ Validate files
     │  ├─ Check product exists
     │  ├─ Check color_id (if set)
     │  └─ Check config_id (if set)
     │
     ├─ Save files to /public/uploads/
     │  └─ Generate unique filenames
     │
     ├─ Create ProductImage records
     │     │
     │     ├─ product_id = 75
     │     ├─ color_id = 1
     │     ├─ config_id = 6
     │     ├─ image_path = "uploads/..."
     │     ├─ display_order = auto increment
     │     └─ is_main = true (first image only)
     │
     ▼
  Database: product_images table
     │
     ▼
  Response JSON back to Admin
     │
     ▼
  UI: Show uploaded images with preview
```

---

## Luồng Dữ Liệu - Display Images Frontend

```
PRODUCT DETAIL PAGE LOADS
     │
     ▼
  Include dynamic-images.blade.php
     │
     ├─ Get initial size
     │     │
     │     ▼
     ├─ API: GET /api/product-images/75?config_id=40
     │
     ▼
  Load Images for (product=75, color=null, config=40)
     │
     ├─ Query priority:
     │  1. (color_id=null, config_id=40)
     │  2. (color_id=null, config_id=null) ← default
     │
     ▼
  Display main image in .thumb_main
  Display rest in carousel .list_thumb
     │
     ▼
  USER SELECTS SIZE
     │
     ├─ Event: click .option-button
     │     │
     │     ▼
     ├─ Extract config_id
     │
     ▼
  API: GET /api/product-images/75?config_id=NEW_ID
     │
     ▼
  Update Images
     │
     ├─ .thumb_main img src = new main image
     └─ .list_thumb carousel = new images
```

---

## Admin Interface - Image Manager

```
┌─────────────────────────────────────────────────────────┐
│         QUẢN LÝ ẢNH THEO MÀU/SIZE                       │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  [Mặc định] [Màu: Đỏ] [Size: 40] [Màu: Đỏ + Size: 40] │
│     ▲                                                   │
│     │ Active Tab                                        │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌──────────────────────────────────────┐               │
│  │ Drop files here or click to select   │               │
│  │ Supported: JPG, PNG, GIF, WEBP       │               │
│  └──────────────────────────────────────┘               │
│           [Upload Images Button]                        │
│                                                         │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐              │
│  │ Image 1  │  │ Image 2  │  │ Image 3  │              │
│  │ 📷 Main  │  │          │  │          │              │
│  │ pic      │  │          │  │          │              │
│  ├──────────┤  ├──────────┤  ├──────────┤              │
│  │[Làm chính]  │[Làm chính]  │[Làm chính]             │
│  │  [Xóa]    │  [Xóa]    │  [Xóa]    │              │
│  └──────────┘  └──────────┘  └──────────┘              │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

## API Request/Response Examples

### 1. Upload Images
```
REQUEST:
POST /api/product-images/upload
Content-Type: multipart/form-data
Authorization: Bearer TOKEN

{
  "product_id": 75,
  "color_id": 1,
  "config_id": 6,
  "images": [file1, file2, file3]
}

RESPONSE:
{
  "success": true,
  "message": "Tải ảnh lên thành công",
  "images": [
    {
      "id": 101,
      "path": "uploads/1719129600_507a8b9c1.jpg",
      "color_id": 1,
      "config_id": 6,
      "is_main": true
    },
    {
      "id": 102,
      "path": "uploads/1719129601_6c2d7e4f2.jpg",
      "color_id": 1,
      "config_id": 6,
      "is_main": false
    }
  ]
}
```

### 2. Get Product Images
```
REQUEST:
GET /api/product-images/75?color_id=1&config_id=6
Authorization: Bearer TOKEN

RESPONSE:
{
  "success": true,
  "images": [
    {
      "id": 101,
      "path": "uploads/1719129600_507a8b9c1.jpg",
      "color_id": 1,
      "config_id": 6,
      "is_main": true,
      "display_order": 0,
      "url": "http://localhost/uploads/1719129600_507a8b9c1.jpg"
    },
    {
      "id": 102,
      "path": "uploads/1719129601_6c2d7e4f2.jpg",
      "color_id": 1,
      "config_id": 6,
      "is_main": false,
      "display_order": 1,
      "url": "http://localhost/uploads/1719129601_6c2d7e4f2.jpg"
    }
  ]
}
```

### 3. Get Product Combinations
```
REQUEST:
GET /api/products/75/combinations
Authorization: Bearer TOKEN

RESPONSE:
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
    {
      "label": "Size: 40",
      "color_id": null,
      "config_id": 6
    },
    {
      "label": "Màu: Đỏ + Size: 40",
      "color_id": 1,
      "config_id": 6
    }
  ]
}
```

---

## File Structure

```
cris-store-main/
├── app/
│   ├── ProductImage.php                           (NEW)
│   ├── Product.php                                (UPDATED)
│   ├── Http/Controllers/
│   │   └── ProductImageController.php             (NEW)
│   └── Console/Commands/
│       ├── MigrateProductImagesToNewTable.php     (NEW)
│       └── SyncProductColorsAndConfigs.php        (NEW)
│
├── database/
│   └── migrations/
│       └── 2026_06_23_000000_create_product_images_table.php (NEW)
│
├── resources/
│   ├── views/
│   │   ├── admin/product/
│   │   │   ├── images-manager.blade.php           (NEW)
│   │   │   └── update.blade.php                   (NEEDS 1 line added)
│   │   └── client/product/
│   │       ├── dynamic-images.blade.php           (NEW)
│   │       └── detail.blade.php                   (NEEDS 1 line added)
│
├── routes/
│   └── api.php                                    (UPDATED)
│
└── docs/
    ├── PRODUCT_IMAGES_COLOR_SIZE_SYSTEM.md        (NEW)
    ├── SETUP_NEW_IMAGE_SYSTEM.md                  (NEW)
    ├── DEPLOYMENT_CHECKLIST.md                    (NEW)
    ├── IMPLEMENTATION_SUMMARY.md                  (NEW)
    └── PRODUCT_IMAGES_FIX.md                      (PREVIOUS)
```

---

## Command Execution Flow

```
php artisan products:migrate-images
     │
     ├─ Load all products
     │
     ├─ For each product:
     │  ├─ Check if already in product_images
     │  ├─ If yes: skip
     │  ├─ If no: read thumb_main
     │  │          ├─ Create ProductImage record
     │  │          │  (color_id=null, config_id=null, is_main=true)
     │  │
     │  ├─ Read thumb_detail (JSON)
     │  │  ├─ For each image:
     │  │  │  └─ Create ProductImage record
     │  │  │     (color_id=null, config_id=null, is_main=false)
     │  │
     │  └─ Output: ✓ Product #75 - 5 images
     │
     ▼
  DONE: Printed summary
```

---

## Image Selection Priority Tree

```
ProductImage::getImagesForProductColorConfig(product_id, color_id, config_id)

IF color_id = 1 AND config_id = 6:
    ├─ Check: (product_id=X, color_id=1, config_id=6)
    │   ├─ Found? ✓ Return these images
    │   └─ Not found? Continue...
    │
    ├─ Check: (product_id=X, color_id=1, config_id=NULL)
    │   ├─ Found? ✓ Return these images
    │   └─ Not found? Continue...
    │
    ├─ Check: (product_id=X, color_id=NULL, config_id=6)
    │   ├─ Found? ✓ Return these images
    │   └─ Not found? Continue...
    │
    └─ Check: (product_id=X, color_id=NULL, config_id=NULL)
        ├─ Found? ✓ Return these images (default)
        └─ Not found? Return empty array
```

---

## Database Query Examples

```sql
-- Get all images for product 75
SELECT * FROM product_images WHERE product_id = 75;

-- Get images for product 75, color 1, any size
SELECT * FROM product_images 
WHERE product_id = 75 AND (color_id = 1 OR color_id IS NULL);

-- Get main images
SELECT * FROM product_images WHERE product_id = 75 AND is_main = true;

-- Count images by color
SELECT color_id, COUNT(*) as count 
FROM product_images 
WHERE product_id = 75 
GROUP BY color_id;

-- Get with relationships (using Eloquent)
ProductImage::where('product_id', 75)
    ->with('color', 'config')
    ->orderBy('display_order')
    ->get();
```

---

**Diagram Version:** 1.0  
**Updated:** 2026-06-23
