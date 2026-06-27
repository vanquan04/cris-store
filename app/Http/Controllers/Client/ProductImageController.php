<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Color;
use App\Models\Config;

class ProductImageController extends Controller
{
    /**
     * Upload images for a specific product-color-config combination
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images' => 'required|array',
            'images.*' => 'required|image|max:5242880',
            'color_id' => 'nullable|exists:colors,id',
            'config_id' => 'nullable|exists:configs,id',
        ], [
            'product_id.required' => 'Sản phẩm không được để trống',
            'product_id.exists' => 'Sản phẩm không tồn tại',
            'images.required' => 'Vui lòng chọn ít nhất một ảnh',
            'images.*.required' => 'Vui lòng chọn ảnh',
            'images.*.image' => 'File phải là ảnh',
            'images.*.max' => 'Kích thước ảnh không vượt quá 5MB',
        ]);

        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');
        $configId = $request->input('config_id');

        // Get maximum display order for this product to append new images
        $maxOrder = ProductImage::where('product_id', $productId)->max('display_order') ?? -1;

        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image->isValid()) {
                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('uploads');
                    $image->move($destinationPath, $filename);

                    // Create product image record
                    $productImage = ProductImage::create([
                        'product_id' => $productId,
                        'color_id' => $colorId,
                        'config_id' => $configId,
                        'image_path' => 'uploads/' . $filename,
                        'display_order' => $maxOrder + $index + 1,
                        'is_main' => $index === 0, // First image is main
                    ]);

                    $uploadedImages[] = [
                        'id' => $productImage->id,
                        'path' => $productImage->image_path,
                        'color_id' => $productImage->color_id,
                        'config_id' => $productImage->config_id,
                        'is_main' => $productImage->is_main,
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Tải ảnh lên thành công',
            'images' => $uploadedImages,
        ]);
    }

    /**
     * Get images for a product with optional color/config filter
     */
    public function getProductImages(Request $request, $productId)
    {
        $colorId = $request->query('color_id');
        $configId = $request->query('config_id');

        $images = ProductImage::getImagesForProductColorConfig($productId, $colorId, $configId);

        return response()->json([
            'success' => true,
            'images' => $images->map(function ($img) {
                return [
                    'id' => $img->id,
                    'path' => $img->image_path,
                    'color_id' => $img->color_id,
                    'config_id' => $img->config_id,
                    'is_main' => $img->is_main,
                    'display_order' => $img->display_order,
                    'url' => asset($img->image_path),
                ];
            }),
        ]);
    }

    /**
     * Delete a product image
     */
    public function destroy($imageId)
    {
        $image = ProductImage::find($imageId);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Ảnh không tồn tại',
            ], 404);
        }

        // Delete from storage if file exists
        $filepath = public_path($image->image_path);
        if (file_exists($filepath)) {
            @unlink($filepath);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa ảnh thành công',
        ]);
    }

    /**
     * Update image display order
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'required|exists:product_images,id',
        ]);

        foreach ($request->input('image_ids') as $order => $imageId) {
            ProductImage::where('id', $imageId)->update(['display_order' => $order]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thứ tự ảnh thành công',
        ]);
    }

    /**
     * Set image as main for a combination
     */
    public function setAsMain(Request $request, $imageId)
    {
        $image = ProductImage::find($imageId);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Ảnh không tồn tại',
            ], 404);
        }

        // Unset other main images for the same color-config combination
        ProductImage::where('product_id', $image->product_id)
            ->where('color_id', $image->color_id)
            ->where('config_id', $image->config_id)
            ->where('id', '!=', $imageId)
            ->update(['is_main' => false]);

        $image->update(['is_main' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Đặt ảnh chính thành công',
        ]);
    }

    /**
     * Get available combinations (color-config pairs) for a product
     */
    public function getProductCombinations($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại',
            ], 404);
        }

        // Get all color-config combinations
        $combinations = [];

        // Get all colors and configs for this product
        $colors = $product->colors()->get();
        $configs = $product->configs()->get();

        // No color/config specified - for all
        $combinations[] = [
            'label' => 'Mặc định (tất cả màu/size)',
            'color_id' => null,
            'config_id' => null,
        ];

        // By color only
        foreach ($colors as $color) {
            $combinations[] = [
                'label' => 'Màu: ' . $color->name,
                'color_id' => $color->id,
                'config_id' => null,
            ];
        }

        // By config (size) only
        foreach ($configs as $config) {
            $combinations[] = [
                'label' => 'Size: ' . $config->name,
                'color_id' => null,
                'config_id' => $config->id,
            ];
        }

        // By color AND config
        foreach ($colors as $color) {
            foreach ($configs as $config) {
                $combinations[] = [
                    'label' => 'Màu: ' . $color->name . ' + Size: ' . $config->name,
                    'color_id' => $color->id,
                    'config_id' => $config->id,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'combinations' => $combinations,
        ]);
    }
}
