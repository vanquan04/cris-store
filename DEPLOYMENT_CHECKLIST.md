# ✅ Deployment Checklist - Product Image Color/Size System

## Phase 1: Database & Backend (CLI)

### Step 1: Create Database Table
```bash
php artisan migrate
```

- ✅ Creates `product_images` table with all necessary indexes and foreign keys
- ✅ All relationships configured

### Step 2: Migrate Existing Images (Optional)
```bash
php artisan products:migrate-images
```

- ✅ Moves images from `thumb_main`/`thumb_detail` to new table
- ✅ Preserves all existing data
- ✅ Skips products already migrated

### Step 3: Sync Colors & Sizes
```bash
php artisan products:sync-colors-configs --all
```

- ✅ Links colors to products
- ✅ Links configs (sizes) to products
- ✅ Sets default prices for sizes

---

## Phase 2: Admin Backend Integration

### Step 1: Update Product Edit Form
**File:** `resources/views/admin/product/update.blade.php`

Add after the form closing tag:

```blade
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Hidden Product ID -->
<input type="hidden" id="product-id" value="{{ $product->id }}" />

<!-- Image Manager Component -->
<div class="card mt-4">
    @include('admin.product.images-manager')
</div>

<!-- Include Manager Scripts -->
@include('admin.product.images-manager')
```

### Step 2: Verify Admin Routes
Ensure API routes are accessible:
```bash
php artisan route:list | grep product-images
```

Expected routes:
- `POST /api/product-images/upload`
- `GET /api/product-images/{id}`
- `DELETE /api/product-images/{id}`
- `POST /api/product-images/{id}/set-main`
- `GET /api/products/{id}/combinations`

---

## Phase 3: Frontend Client Integration

### Step 1: Update Product Detail View
**File:** `resources/views/client/product/detail.blade.php`

Add after thumbnail carousel section:

```blade
<!-- Include dynamic image loading script -->
@include('client.product.dynamic-images')
```

### Step 2: Ensure jQuery Owl Carousel
If using owl-carousel for thumbnails:

```blade
<!-- In detail.blade.php head or scripts -->
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
```

### Step 3: Test on Frontend
1. Go to any product detail page
2. Select different sizes
3. Images should update automatically
4. ✅ No page refresh needed

---

## Phase 4: Testing & Verification

### Test 1: Admin Upload
```bash
1. Go to admin product edit page
2. Scroll to "Quản lý ảnh theo màu/size"
3. Select a color/size tab
4. Upload test images
5. ✅ Images should appear immediately
```

### Test 2: Frontend Display
```bash
1. Go to product detail page
2. Click size button → images change
3. If colors exist, click color → images change
4. ✅ Carousel updates smoothly
```

### Test 3: Database
```bash
php artisan tinker
>>> use App\ProductImage;
>>> ProductImage::count()              // Should show uploaded images
>>> ProductImage::where('product_id', 75)->count()
>>> App\ProductImage::getImagesForProductColorConfig(75, 1, 6)
>>> exit()
```

### Test 4: API
```bash
# Get images for product 75, color 1, size 6
curl -X GET "http://localhost:8000/api/product-images/75?color_id=1&config_id=6" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

---

## Phase 5: Production Deployment

### Before Going Live

- ✅ Run all tests locally
- ✅ Test with real data
- ✅ Backup database
- ✅ Test all API endpoints
- ✅ Clear cache: `php artisan cache:clear`
- ✅ Restart queue/workers if applicable

### Deployment Steps

1. **Pull latest code**
   ```bash
   git pull origin main
   ```

2. **Install/update dependencies** (if needed)
   ```bash
   composer update
   ```

3. **Run migrations**
   ```bash
   php artisan migrate --force
   ```

4. **Migrate old images**
   ```bash
   php artisan products:migrate-images
   ```

5. **Sync colors/sizes**
   ```bash
   php artisan products:sync-colors-configs --all
   ```

6. **Clear cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

7. **Restart services** (if using supervisor/services)
   ```bash
   sudo service supervisor restart
   ```

---

## Phase 6: Monitoring & Maintenance

### Daily Checks
- [ ] Admin uploads working
- [ ] Frontend images loading
- [ ] No console errors
- [ ] API responding correctly

### Weekly Checks
- [ ] Database size normal
- [ ] Slow queries log
- [ ] Storage usage reasonable

### Monthly Maintenance
- [ ] Clean up orphaned images (if any)
- [ ] Verify data integrity
- [ ] Check API performance

---

## Troubleshooting

### Issue: Images Not Showing on Frontend
**Solution:**
1. Check browser console for errors
2. Verify API token in LocalStorage
3. Check CORS settings
4. Verify image files exist in `/public/uploads/`

### Issue: Upload Returns 401 Unauthorized
**Solution:**
1. Verify user is logged in
2. Check API token validity
3. Ensure CSRF token is correct
4. Check `auth:sanctum` middleware

### Issue: No Images in product_images Table
**Solution:**
1. Run migration: `php artisan migrate`
2. Run migration command: `php artisan products:migrate-images`
3. Check if images exist in `thumb_main`/`thumb_detail`

### Issue: Colors/Sizes Not Linked
**Solution:**
1. Run sync command: `php artisan products:sync-colors-configs --all`
2. Verify colors/configs exist in database
3. Check product relationships

---

## Rollback Plan

If something goes wrong:

```bash
# Rollback migrations
php artisan migrate:rollback

# This will:
# - Drop product_images table
# - Keep thumb_main/thumb_detail intact
# - Keep all data safe
```

---

## Files Modified/Created

| File | Type | Status |
|------|------|--------|
| `database/migrations/2026_06_23_000000_create_product_images_table.php` | Migration | ✅ Created |
| `app/ProductImage.php` | Model | ✅ Created |
| `app/Http/Controllers/ProductImageController.php` | Controller | ✅ Created |
| `app/Console/Commands/MigrateProductImagesToNewTable.php` | Command | ✅ Created |
| `app/Console/Commands/SyncProductColorsAndConfigs.php` | Command | ✅ Created |
| `app/Product.php` | Model | ✅ Updated |
| `resources/views/admin/product/images-manager.blade.php` | View | ✅ Created |
| `resources/views/client/product/dynamic-images.blade.php` | View | ✅ Created |
| `routes/api.php` | Routes | ✅ Updated |

---

## Support & Documentation

- **Full Docs:** `PRODUCT_IMAGES_COLOR_SIZE_SYSTEM.md`
- **Quick Start:** `SETUP_NEW_IMAGE_SYSTEM.md`
- **API Reference:** Inline comments in `ProductImageController.php`

---

**Last Updated:** 2026-06-23  
**Status:** ✅ Ready for Deployment
