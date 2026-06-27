<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cat_product;
use App\Models\Banner;
use App\Models\Config;
use App\Models\Color;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['client_module_active' => 'product']);
            return $next($request);
        });
    }

    function render_menu($data, $menu_id = 'main-menu', $menu_class = '', $slug_parent = '', $parent_id = 0, $lever = 0)
    {
        if ($lever == 0) {
            $result = "<ul id='{$menu_id}' class='{$menu_class}'>";
        } else {
            $result = "<ul class='sub-menu'>";
        }
        foreach ($data as $v) {
            if ($v['parent_id'] == $parent_id) {
                $result .= "<li>";
                $result .= "<a href='" . route('client.product.cat', ['slug' => $v['slug']]) . "'>" . $v['name'] . "</a>";
                $v['lever'] = $lever;
                foreach ($data as $item) {
                    if ($item['parent_id'] == $v['id']) {
                        $result .= $this->render_menu($data, '', 'sub-menu', $v['slug'], $v['id'], $lever + 1);
                    }
                }
                $result .= "</li>";
            }
        }
        $result .= "</ul>";
        return $result;
    }

    function list_product()
    {
        $data = Cat_product::all();
        $render_menu =  $this->render_menu($data, '', 'list-item');
        $banners = Banner::orderBy('sort', 'asc')->get();
        $baseQuery = Product::query();
        $sizes = Product::getAvailableSizes();
        $fieldTypes = Product::getAvailableFieldTypes();
        $colors = Color::orderBy('name')->get();
        $qtyProduct = (clone $baseQuery)->count();

        $products = $this->applyProductFilters(request(), $baseQuery)
            ->paginate(12)
            ->appends(request()->query());
        $cat_name = 'Sản phẩm';
        return view('client.product.cat', compact('products', 'cat_name', 'render_menu', 'banners', 'qtyProduct', 'sizes', 'fieldTypes', 'colors'));
    }


    protected function getProductsByParentId($cat_parent_id)
    {
        $catIds = [$cat_parent_id];
        // return dd($catIds);
        $list_cat = Cat_product::whereIn('parent_id', $catIds)->get();
        if ($list_cat->count() == 0) {
            return Product::where('cat_id', $cat_parent_id)->paginate(20);
        }

        $productIds = [];
        foreach ($list_cat as $cat) {
            // Đệ qui: Lấy sản phẩm của các danh mục con
            $subCatProducts = $this->getProductsByParentId($cat->id);
            $productIds = array_merge($productIds, $subCatProducts->pluck('id')->toArray());
        }
        // return dd($productIds);
        $products = Product::whereIn('id', $productIds)->paginate(20);
        return $products;
    }

    protected function getCategoryIds($catId)
    {
        $ids = [$catId];
        $children = Cat_product::where('parent_id', $catId)->get();
        foreach ($children as $child) {
            $ids = array_merge($ids, $this->getCategoryIds($child->id));
        }
        return $ids;
    }

    protected function applyProductFilters(Request $request, $query)
    {
        $sizes = (array) $request->input('size', []);
        $fieldTypes = (array) $request->input('field_type', []);
        $colors = (array) $request->input('color', []);
        $priceRange = $request->input('price_range');
        $sort = $request->input('sort');

        if (!empty($sizes)) {
            $query->where(function ($q) use ($sizes) {
                foreach ($sizes as $sizeValue) {
                    $q->orWhere('size', 'LIKE', '%' . $sizeValue . '%');
                }
                $q->orWhereHas('configs', function ($subQuery) use ($sizes) {
                    $subQuery->whereIn('configs.memory', $sizes);
                });
            });
        }

        if (!empty($fieldTypes)) {
            $query->whereIn('field_type', $fieldTypes);
        }

        if (!empty($colors)) {
            $query->whereHas('colors', function ($subQuery) use ($colors) {
                $subQuery->whereIn('colors.id', $colors);
            });
        }

        if (!empty($priceRange)) {
            if (strpos($priceRange, '+') !== false) {
                $min = (int) str_replace('+', '', $priceRange);
                $query->where('new_price', '>=', $min);
            } else {
                $parts = explode('-', $priceRange);
                if (count($parts) === 2) {
                    $min = (int) $parts[0];
                    $max = (int) $parts[1];
                    $query->whereBetween('new_price', [$min, $max]);
                }
            }
        }

        if ($sort === '1') {
            $query->orderBy('new_price', 'DESC');
        } elseif ($sort === '2') {
            $query->orderBy('new_price', 'ASC');
        }

        return $query;
    }

    function product_detail($slug)
    {
        // return $slug;
        $data = Cat_product::all();
        $render_menu =  $this->render_menu($data, '', 'list-item');

        $banners = Banner::orderBy('sort', 'asc')->get();
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            abort(404);
        }

        $configs = $product->configs()->get();
        $productColors = $product->colors()->get();
        $variants = Schema::hasTable('product_variants') ? $product->variants()->get() : collect();

        $variantData = [];
        foreach ($variants as $variant) {
            $variantData[] = [
                'color_id' => (int) $variant->color_id,
                'config_id' => (int) $variant->config_id,
                'price' => (float) $variant->price,
                'discount' => (int) $variant->discount,
                'stock' => (int) $variant->stock,
            ];
        }

        $colorImages = collect();
        $variantImages = [];
        if (Schema::hasTable('product_images')) {
            // Per-color images (config_id = null)
            $colorImages = ProductImage::where('product_id', $product->id)
                ->whereNull('config_id')
                ->orderBy('display_order')
                ->get()
                ->groupBy('color_id')
                ->map(function ($items) {
                    return $items->pluck('image_path')->values();
                });

            // Per-variant images (color_id + config_id) - use plain array to avoid Collection mutation issue
            $variantImagesData = ProductImage::where('product_id', $product->id)
                ->whereNotNull('config_id')
                ->orderBy('display_order')
                ->get();

            foreach ($variantImagesData as $img) {
                $key = $img->color_id . '_' . $img->config_id;
                if (!isset($variantImages[$key])) {
                    $variantImages[$key] = [];
                }
                $variantImages[$key][] = $img->image_path;
            }
        }

        // return dd($configs);
        $thumb_detail = $product->thumb_detail ? json_decode($product->thumb_detail, true) : [];
        $product->increment('views');

        // return $product->Cat_product->parent_id;
        $categoryProducts = $this->getProductsByParentId($product->Cat_product->parent_id);
        // return $categoryProducts;
        return view('client.product.detail', compact('product', 'banners', 'thumb_detail', 'render_menu', 'configs', 'categoryProducts', 'productColors', 'variantData', 'colorImages', 'variantImages'));
    }

    function product_option(Request $request)
    {
        $idOption = $request->input('idOption');
        $colorId = $request->input('colorId');
        $idProduct = $request->input('id');
        $product = Product::find($idProduct);

        if (!$product) {
            return response()->json([
                'price' => number_format(0, 0, '.', '.') . ' VNĐ',
                'stock' => 0,
                'is_out_of_stock' => true,
            ]);
        }

        $variant = null;
        if (Schema::hasTable('product_variants') && !empty($colorId) && !empty($idOption)) {
            $variant = $product->variants()
                ->where('color_id', $colorId)
                ->where('config_id', $idOption)
                ->first();
        }

        $oldPrice = null;
        $promo = $product->getActivePromotion();
        
        if ($variant) {
            $basePrice = $variant->price;
            $discount = (int) $variant->discount;
            if ($promo && $promo->discount_percent > $discount) {
                $discount = $promo->discount_percent;
            }
            if ($discount > 0) {
                $optionPrice = round($basePrice * (1 - $discount / 100));
                $oldPrice = number_format($basePrice, 0, '.', '.') . ' VNĐ';
            } else {
                $optionPrice = $basePrice;
            }
            $stock = (int) $variant->stock;
        } else {
            $configs = $product->configs()->get();
            $configMatch = $configs->find($idOption);
            $basePrice = $configMatch && !empty($configMatch->pivot->price)
                ? $configMatch->pivot->price
                : $product->attributes['old_price'] ?? $product->new_price;
            
            $discount = 0;
            if ($promo && $promo->discount_percent > 0) {
                $discount = $promo->discount_percent;
            }
            if ($discount > 0) {
                $optionPrice = round($basePrice * (1 - $discount / 100));
                $oldPrice = number_format($basePrice, 0, '.', '.') . ' VNĐ';
            } else {
                $optionPrice = $basePrice;
            }
            $stock = (int) $product->amount;
        }

        $price = number_format($optionPrice, 0, '.', '.') . ' VNĐ';
        $data = array(
            'price' => $price,
            'old_price' => $oldPrice,
            'stock' => $stock,
            'is_out_of_stock' => $stock <= 0,
        );
        return response()->json($data);
    }

    function product_cat($slug)
    {
        $data = Cat_product::all();
        $render_menu =  $this->render_menu($data, '', 'list-item');

        $banners = Banner::orderBy('sort', 'asc')->get();
        $cat_product = Cat_product::where('slug', $slug)->first();
        $cat_name = $cat_product->name;
        $categoryIds = $this->getCategoryIds($cat_product->id);
        $baseQuery = Product::whereIn('cat_id', $categoryIds);
        $sizes = Product::getAvailableSizes($baseQuery);
        $fieldTypes = Product::getAvailableFieldTypes($baseQuery);
        $colors = Color::orderBy('name')->get();
        $qtyProduct = (clone $baseQuery)->count();

        $products = $this->applyProductFilters(request(), $baseQuery)
            ->paginate(12)
            ->appends(request()->query());

        return view('client.product.cat', compact('products', 'cat_name', 'render_menu', 'banners', 'qtyProduct', 'sizes', 'fieldTypes', 'colors'));
    }



    function suggest(Request $request)
    {
        $keyword = $request->input('keyword');
        $listProduct = Product::where('name', 'LIKE', "%$keyword%")->get();
        // return $listProduct;
        if (!empty($keyword)) {
            $listProduct = $listProduct;
        } else {
            $listProduct = '';
        }
        $data = array(
            'listProduct' => $listProduct,
        );
        echo json_encode($data);
    }

    function sort(Request $request)
    {
        $options = $request->input('option');
        switch ($options) {
            case "1":
                $listProduct = Product::orderBy('new_price', 'DESC')->get();
                break;
            case "2":
                $listProduct = Product::orderBy('new_price', 'ASC')->get();
                break;
            case "3":
                $listProduct =  Product::where('new_price', '<', 500000)->get();
                break;
            case "4":
                $listProduct =  Product::where('new_price', '>=', 500000)->where('new_price', '<', 1000000)->get();
                break;
            case "5":
                $listProduct =  Product::where('new_price', '>=', 1000000)->where('new_price', '<=', 5000000)->get();
                break;
            case "6":
                $listProduct =  Product::where('new_price', '>=', 5000000)->where('new_price', '<=', 10000000)->get();
                break;
            case "7":
                $listProduct =  Product::where('new_price', '>=', 10000000)->get();
                break;
        }
        $str = "";

        foreach ($listProduct as $item) {
            $images = asset($item->thumb_main);
            $name = $item->name;
            $id = $item->id;
            $code = $item->code;
            $price = number_format($item->new_price, 0, '', ',') . 'đ';
            $url = route('client.product.detail', $item->slug);

            $str .= '<li class="item">';
            $str .= '<div class="thumb-product">';
            $str .= '<a href="' . $url . '"><img src="' . $images . '" alt=""></a>';
            $str .= '</div>';
            $str .= '<div class="view&code d-flex justify-content-between mb-2">';
            $str .= '<div class="code">';
            $str .= 'Mã SP <span>' . $code . '</span>';
            $str .= '</div>';
            $str .= '<div class="view d-flex">';
            $str .= '<div class="icon"><i class="fas fa-eye"></i></div>';
            $str .= $item->views;
            $str .= '</div>';
            $str .= '</div>';
            $str .= '<div class="name-product">';
            $str .= '<a href="' . $url . '">' . Str::limit($name, 35, '...') . '</a>';
            $str .= '</div>';
            $str .= '<div class="price">';
            $str .= '<div class="new-price d-inline-block">';
            $str .= $price;
            $str .= '</div>';
            if ($item->discount != 0) {
                $oldPrice = number_format($item->old_price, 0, '.', '.') . 'đ';
                $str .= '<small class="old-price d-inline-block">' . $oldPrice . '</small>';
            }
            $str .= '</div>';
            $str .= '<div class="action mt-2 d-flex justify-content-between">';
            $str .= '<a data-id="' . $id . '" title="" class="btn btn-style add-cart add-cart-ajax fl-left"><span>Thêm giỏ hàng</span></a>';
            $str .= '<a href="" title="" class="btn btn-style buy-now fl-right"><span>Mua ngay</span></a>';
            $str .= '</div>';
            $str .= '</li>';
        }

        // $paging = $query->appends(['sort' => $option])->links()->render();
        $data = array(
            'str' => $str
        );
        return json_encode($data);
    }
}
