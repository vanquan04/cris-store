<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'color_id',
        'config_id',
        'image_path',
        'display_order',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the product this image belongs to
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * Get the color this image is associated with (if any)
     */
    public function color()
    {
        return $this->belongsTo('App\Models\Color');
    }

    /**
     * Get the config (size) this image is associated with (if any)
     */
    public function config()
    {
        return $this->belongsTo('App\Models\Config');
    }

    /**
     * Scope: Get images for a specific product
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope: Get images for a specific color
     */
    public function scopeForColor($query, $colorId)
    {
        return $query->whereNull('color_id')
            ->orWhere('color_id', $colorId);
    }

    /**
     * Scope: Get images for a specific size/config
     */
    public function scopeForConfig($query, $configId)
    {
        return $query->whereNull('config_id')
            ->orWhere('config_id', $configId);
    }

    /**
     * Scope: Get main images
     */
    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }

    /**
     * Get images for a specific product, color, and config combination
     * Falls back to images with null values (applies to all of that type)
     */
    public static function getImagesForProductColorConfig($productId, $colorId = null, $configId = null)
    {
        $baseQuery = static::where('product_id', $productId)->orderBy('display_order');

        if ($colorId && $configId) {
            $exact = (clone $baseQuery)
                ->where('color_id', $colorId)
                ->where('config_id', $configId)
                ->get();
            if ($exact->isNotEmpty()) {
                return $exact;
            }
        }

        if ($colorId) {
            $colorOnly = (clone $baseQuery)
                ->where('color_id', $colorId)
                ->whereNull('config_id')
                ->get();
            if ($colorOnly->isNotEmpty()) {
                return $colorOnly;
            }
        }

        if ($configId) {
            $configOnly = (clone $baseQuery)
                ->whereNull('color_id')
                ->where('config_id', $configId)
                ->get();
            if ($configOnly->isNotEmpty()) {
                return $configOnly;
            }
        }

        return (clone $baseQuery)
            ->whereNull('color_id')
            ->whereNull('config_id')
            ->get();
    }

    /**
     * Get main image for a product-color-config combination
     */
    public static function getMainImageForCombination($productId, $colorId = null, $configId = null)
    {
        $images = static::getImagesForProductColorConfig($productId, $colorId, $configId);
        return $images->firstWhere('is_main', true) ?? $images->first();
    }
}
