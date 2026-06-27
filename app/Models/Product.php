<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'code', 'size', 'field_type', 'desc_quick', 'desc_detail', 'thumb_main', 'thumb_detail', 'creator', 'amount', 'old_price', 'discount', 'new_price', 'cat_id', 'featured_products', 'status', 'slug'
    ];

    public function colors()
    {
        return $this->belongsToMany('App\Models\Color', 'product_color');
    }

    public function configs()
    {
        return $this->belongsToMany('App\Models\Config', 'product_config')->withPivot('price');
        //->withTimestamps()
    }

    public function Cat_product()
    {
        return $this->belongsTo('App\Models\Cat_product', 'cat_id');
    }
    public function Users()
    {
        return $this->belongsTo('App\Models\User', 'creator');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage')->orderBy('display_order');
    }

    public function getNewPriceAttribute($value)
    {
        $rawNewPrice = $this->attributes['new_price'] ?? 0;
        $price = $rawNewPrice;
        $basePrice = $this->attributes['old_price'] ?? 0;
        
        if ($basePrice == 0) {
            $basePrice = $rawNewPrice;
        }

        if ($this->variants()->exists()) {
            $variantMinBase = (float) $this->variants()->min('price');
            $variantMinNew = (float) $this->variants()
                ->selectRaw('MIN(price * (1 - discount / 100)) as min_price')
                ->value('min_price');
            if ($variantMinBase > 0) {
                $basePrice = $variantMinBase;
                $price = $variantMinNew;
            }
        } elseif ($this->configs()->exists()) {
            $pivotMin = (float) $this->configs()->min('product_config.price');
            if ($pivotMin > 0) {
                $basePrice = $pivotMin;
                $price = $pivotMin;
            }
        }

        // Apply global promotion discount if active
        $promo = $this->getActivePromotion();
        if ($promo && $promo->discount_percent > 0) {
            $promoPrice = $basePrice * (1 - $promo->discount_percent / 100);
            if ($price == 0 || $promoPrice < $price) {
                $price = $promoPrice;
            }
        }

        return $price;
    }

    public function getDiscountAttribute($value)
    {
        $discount = $value;
        $rawNewPrice = $this->attributes['new_price'] ?? 0;

        if ($this->variants()->exists()) {
            $variant = $this->variants()->orderByRaw('price * (1 - discount / 100) ASC')->first();
            if ($variant) {
                $discount = $variant->discount;
            }
        }

        $promo = $this->getActivePromotion();
        if ($promo && $promo->discount_percent > $discount) {
            $discount = $promo->discount_percent;
        }

        return $discount;
    }

    public function getOldPriceAttribute($value)
    {
        $rawNewPrice = $this->attributes['new_price'] ?? 0;
        $basePrice = $this->attributes['old_price'] ?? 0;

        if ($basePrice == 0) {
            $basePrice = $rawNewPrice;
        }

        if ($this->variants()->exists()) {
            $variantMinBase = (float) $this->variants()->min('price');
            if ($variantMinBase > 0) {
                $basePrice = $variantMinBase;
            }
        } elseif ($this->configs()->exists()) {
            $pivotMin = (float) $this->configs()->min('product_config.price');
            if ($pivotMin > 0) {
                $basePrice = $pivotMin;
            }
        }

        return $basePrice;
    }

    /**
     * Get images for a specific color and/or config combination
     * Falls back to images with null values (applies to all of that type)
     */
    public function getImagesForColorConfig($colorId = null, $configId = null)
    {
        return \App\Models\ProductImage::getImagesForProductColorConfig($this->id, $colorId, $configId);
    }

    /**
     * Get main image for this product, optionally filtered by color/config
     */
    public function getMainImageForColorConfig($colorId = null, $configId = null)
    {
        return \App\Models\ProductImage::getMainImageForCombination($this->id, $colorId, $configId);
    }

    public function variants()
    {
        return $this->hasMany('App\Models\\ProductVariant');
    }

    public function promotions()
    {
        return $this->belongsToMany('App\Models\Promotion', 'promotion_product', 'product_id', 'promotion_id');
    }

    public function getActivePromotion()
    {
        $now = now()->toDateString();
        // Promotion directly applied to product
        $promo = $this->promotions()
            ->where('status', 1)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->orderBy('discount_percent', 'desc')
            ->first();

        if ($promo) {
            return $promo;
        }

        // Promotion applied to category
        if ($this->cat_id) {
            $promoCat = \App\Models\Promotion::whereHas('categories', function($q) {
                    $q->where('cat_products.id', $this->cat_id);
                })
                ->where('status', 1)
                ->whereDate('start_date', '<=', $now)
                ->whereDate('end_date', '>=', $now)
                ->orderBy('discount_percent', 'desc')
                ->first();
            if ($promoCat) return $promoCat;
        }
        return null;
    }

    public static function getAvailableSizes($baseQuery = null)
    {
        $query1 = $baseQuery ? clone $baseQuery : self::query();
        $rawSizes = $query1->whereNotNull('size')->where('size', '!=', '')->pluck('size')->toArray();

        $productIds = $baseQuery ? (clone $baseQuery)->pluck('id')->toArray() : null;

        $sizesFromConfigs = \App\Models\Config::whereHas('products', function($q) use ($productIds) {
            $q->where('status', 1);
            if ($productIds !== null) {
                $q->whereIn('products.id', $productIds);
            }
        })->pluck('memory')->toArray();

        $mergedSizes = [];
        foreach(array_merge($rawSizes, $sizesFromConfigs) as $s) {
            $parts = explode(',', $s);
            foreach($parts as $p) {
                $p = trim($p);
                if ($p !== '' && !in_array($p, $mergedSizes)) {
                    $mergedSizes[] = $p;
                }
            }
        }
        sort($mergedSizes);
        return collect($mergedSizes);
    }

    public static function getAvailableFieldTypes($baseQuery = null)
    {
        $query = $baseQuery ? clone $baseQuery : self::query();
        return $query->whereNotNull('field_type')->where('field_type', '!=', '')->distinct()->orderBy('field_type')->pluck('field_type');
    }
}
