<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use App\Models\Config;
use App\Models\Product;
use App\Models\Cat_product;
use App\Models\User;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    function data_tree($data, $parent_id = 0, $lever = 0)
    {
        $result = array();
        foreach ($data as $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['lever'] = $lever;
                $result[] = $v;
                $result_child = $this->data_tree($data, $v['id'], $lever + 1);
                $result = array_merge($result, $result_child);
            }
        }
        return $result;
    }

    function list(Request $request)
    {
        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        $cat_id = $request->input('cat_id', '');
        $keyword = $request->input('key', '');

        if ($request->input('status') == 'active' && $request->input('status') != '' || $request->input('status') == '') {;
            $query = Product::where('name', 'LIKE', "%$keyword%");
            $list_act = [
                'disable' => 'Vô hiệu hóa'
            ];
            $url_delete = 'admin/product/delete/';
            $url_btn_success = 'admin/product/edit/';
        } else {
            $query = Product::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%");
            $list_act = [
                'restore' => 'Kích hoạt',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $url_delete = 'admin/product/forcedelete/';
            $url_btn_success = 'admin/product/restore/';
        }

        if (!empty($cat_id)) {
            $childCats = $this->data_tree($categories, $cat_id);
            $catIds = [$cat_id];
            foreach($childCats as $c) {
                $catIds[] = $c['id'];
            }
            $query->whereIn('cat_id', $catIds);
        }

        $products = $query->orderBy('id', 'asc')->paginate(15);
        // append query string to pagination links
        $products->appends(['key' => $keyword, 'cat_id' => $cat_id, 'status' => $request->input('status')]);

        $numUsersActive = Product::count();
        $numSoftDelete = Product::onlyTrashed()->count();

        return view('admin.product.list', compact('products', 'keyword', 'numUsersActive', 'numSoftDelete', 'list_act', 'url_delete', 'url_btn_success', 'categoryOptions', 'cat_id'));
    }

    function add()
    {
        $colors = Color::all();
        $configs = Config::all();

        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        // return dd($categoryOptions);
        return view('admin.product.add', compact('colors', 'configs', 'categoryOptions'));
    }

    function handle_add(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'size' => ['nullable', 'string', 'max:50'],
            'field_type' => ['nullable', 'string', 'max:50'],
            'slug' => ['required', 'unique:products'],
            'cat_id' => ['required'],
            'file' => ['required', 'max:5242880', 'image'],
        ], [
            'required' => ':attribute không được để trống!',
            'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
            'max' => ':attribute có độ dài lớn nhất :max ký tự!',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
            'image' => ':attribute phải là một hình ảnh',
            'mimes' => ':attribute phải có định dạng jpg, png, jpeg, gif',
        ], [
            'name' => 'Tên sản phẩm',
            'size' => 'Size giày',
            'field_type' => 'Loại sân',
            'slug' => 'Slug',
            'file' => 'Ảnh chính',
            'cat_id' => 'Danh mục cha'
        ]);

        $mainImagePath = '';
        if ($request->hasFile('file')) {
            $mainImagePath = $this->uploadFileToPublicUploads($request->file('file'));
        }

        $result = [];
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $image) {
                $imagePath = $this->uploadFileToPublicUploads($image);
                if (!empty($imagePath)) {
                    $result[] = $imagePath;
                }
            }
        }

        // return dd($request->input());
        if ($result) {
            $thumb_detail = json_encode($result);
        } else {
            $thumb_detail = '';
        }
        $featured_products = $request->input('featured_products') ? 1 : 0;
        // return $request->input();
        $product = Product::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'size' => $request->input('size'),
            'field_type' => $request->input('field_type'),
            'desc_quick' => $request->input('des_quick'),
            'desc_detail' => $request->input('des_detail'),
            'thumb_main' => $mainImagePath,
            'thumb_detail' => $thumb_detail,
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'amount' => 0, // Will be calculated from variant stock
            'old_price' => 0,
            'new_price' => 0,
            'cat_id' => $request->input('cat_id'),
            'featured_products' => $featured_products,
            'status' => $request->input('status'),
        ]);

        $colorIds = (array) $request->input('color', []);
        $configIds = (array) $request->input('config', []);

        $product->colors()->sync($colorIds);
        $this->syncConfigsWithPrices($product, $configIds, (array) $request->input('priceInput', []));
        $this->syncVariants($product, $request->input('variant_price', []), $request->input('variant_stock', []), $request->input('variant_discount', []));
        $this->syncColorImages($product, $request);

        if ($this->hasProductVariantsTable()) {
            $product->amount = $product->variants()->sum('stock');
        }
        $product->code = 'TQ#' . $product->id;
        $product->save();
        toastr()->success('Đã thêm sản phẩm thành công!');
        return redirect('admin/product/add');
    }

    function product_edit(Product $product)
    {
        $status0 = $product->status == 0;
        $status1 = $product->status == 1;
        $colors = Color::all();
        $configs = Config::all();
        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        $thumb_detail = $product->thumb_detail ? json_decode($product->thumb_detail, true) : [];
        $variants = collect();
        if ($this->hasProductVariantsTable()) {
            $variants = $product->variants()->get()->keyBy(function ($item) {
                return $item->color_id . '_' . $item->config_id;
            });
        }

        $colorImages = collect();
        if ($this->hasProductImagesTable()) {
            $colorImages = ProductImage::where('product_id', $product->id)
                ->whereNull('config_id')
                ->orderBy('display_order')
                ->get()
                ->groupBy('color_id');
        }
        // return dd($product);

        return view('admin.product.update', compact('thumb_detail', 'product', 'colors', 'configs', 'categoryOptions', 'status0', 'status1', 'variants', 'colorImages'));
    }

    function product_update(Request $request, Product $product)
    {
        // return dd($request->input());
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' . $product->id],
            'slug' => ['required', 'unique:products,slug,' . $product->id],
            'size' => ['nullable', 'string', 'max:50'],
            'field_type' => ['nullable', 'string', 'max:50'],
            'cat_id' => ['required'],
        ], [
            'required' => ':attribute không được để trống!',
            'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
            'max' => ':attribute có độ dài lớn nhất :max ký tự!',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
        ], [
            'name' => 'Tên sản phẩm',
            'size' => 'Size giày',
            'field_type' => 'Loại sân',
            'slug' => 'Slug',
            'cat_id' => 'Danh mục cha'
        ]);

        $mainImagePath = '';
        if ($request->hasFile('file')) {
            $mainImagePath = $this->uploadFileToPublicUploads($request->file('file'));
        }

        $result = [];
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $image) {
                $imagePath = $this->uploadFileToPublicUploads($image);
                if (!empty($imagePath)) {
                    $result[] = $imagePath;
                }
            }
        }

        if ($request->has('existing_files')) {
            foreach ($request->input('existing_files') as $existing) {
                if (!empty($existing)) {
                    $result[] = $existing;
                }
            }
        }

        // Always encode result, if empty it means they removed all detail images
        $thumb_detail = empty($result) ? '' : json_encode(array_values(array_filter($result)));

        $resolvedOldPrice = $request->filled('old_price')
            ? (float) str_replace(',', '', $request->input('old_price'))
            : (float) ($product->old_price ?? 0);
        $resolvedNewPrice = $request->filled('new_price')
            ? (float) str_replace(',', '', $request->input('new_price'))
            : (float) ($product->new_price ?? $resolvedOldPrice);

        $updateData = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'size' => $request->input('size'),
            'field_type' => $request->input('field_type'),
            'desc_quick' => $request->input('des_quick'),
            'desc_detail' => $request->input('des_detail'),
            'cat_id' => $request->input('cat_id'),
            'featured_products' => $request->input('featured_products') ? 1 : 0,
            'status' => $request->input('status'),
            'discount' => $request->input('discount'),
            'amount' => (int) ($request->input('amount') ?? $product->amount ?? 0),
            'old_price' => $resolvedOldPrice,
            'new_price' => $resolvedNewPrice,
            'thumb_detail' => $thumb_detail,
        ];

        if ($mainImagePath) {
            $updateData['thumb_main'] = $mainImagePath;
        }

        $product->update($updateData);

        $colorIds = (array) $request->input('color', []);
        $configIds = (array) $request->input('config', []);

        $product->colors()->sync($colorIds);
        $this->syncConfigsWithPrices($product, $configIds, (array) $request->input('priceInput', []));
        $this->syncVariants($product, $request->input('variant_price', []), $request->input('variant_stock', []), $request->input('variant_discount', []));
        $this->syncColorImages($product, $request);

        if ($this->hasProductVariantsTable()) {
            $product->amount = $product->variants()->sum('stock');
        }
        $product->save();

        toastr()->success('Cập nhật sản phẩm thành công!');
        return redirect()->route('product.edit', $product->id);
    }

    protected function uploadFileToPublicUploads($file)
    {
        if (!$file || !$file->isValid()) {
            return '';
        }

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads');
        $file->move($destinationPath, $fileName);

        return 'uploads/' . $fileName;
    }

    protected function syncConfigsWithPrices(Product $product, array $configIds, array $priceInput)
    {
        $syncData = [];
        foreach ($configIds as $index => $configId) {
            $price = isset($priceInput[$index]) && $priceInput[$index] !== ''
                ? (float) str_replace(',', '', $priceInput[$index])
                : (float) $product->new_price;
            $syncData[$configId] = ['price' => $price];
        }
        $product->configs()->sync($syncData);
    }

    protected function syncVariants(Product $product, $variantPriceRows, $variantStockRows, $variantDiscountRows = [])
    {
        if (!$this->hasProductVariantsTable()) {
            return;
        }

        $product->variants()->delete();

        if (!is_array($variantStockRows)) {
            return;
        }

        $minNewPrice = null;
        $correspondingOldPrice = 0;
        $correspondingDiscount = 0;

        foreach ($variantStockRows as $colorId => $sizeRows) {
            if (!is_array($sizeRows)) {
                continue;
            }

            foreach ($sizeRows as $configId => $stockValue) {
                $stock = is_numeric($stockValue) ? (int) $stockValue : 0;
                $price = isset($variantPriceRows[$colorId][$configId]) && $variantPriceRows[$colorId][$configId] !== ''
                    ? (float) str_replace(',', '', $variantPriceRows[$colorId][$configId])
                    : (float) $product->new_price;
                $discount = isset($variantDiscountRows[$colorId][$configId]) && $variantDiscountRows[$colorId][$configId] !== ''
                    ? (int) $variantDiscountRows[$colorId][$configId]
                    : 0;

                $newPrice = $price * (1 - $discount / 100);

                if ($minNewPrice === null || $newPrice < $minNewPrice) {
                    $minNewPrice = $newPrice;
                    $correspondingOldPrice = $price;
                    $correspondingDiscount = $discount;
                }

                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => (int) $colorId,
                    'config_id' => (int) $configId,
                    'price' => $price,
                    'stock' => $stock,
                    'discount' => $discount,
                ]);
            }
        }

        if ($minNewPrice !== null) {
            $product->new_price = $minNewPrice;
            $product->old_price = $correspondingOldPrice;
            $product->discount = $correspondingDiscount;
        }
    }

    protected function syncColorImages(Product $product, Request $request)
    {
        if (!$this->hasProductImagesTable()) {
            return;
        }

        if (!$request->hasFile('color_images')) {
            return;
        }

        $colorImages = $request->file('color_images');
        foreach ($colorImages as $colorId => $files) {
            if (!is_array($files)) {
                continue;
            }

            $maxOrder = ProductImage::where('product_id', $product->id)
                ->where('color_id', $colorId)
                ->whereNull('config_id')
                ->max('display_order');
            $nextOrder = is_null($maxOrder) ? 0 : $maxOrder + 1;

            $hasMain = ProductImage::where('product_id', $product->id)
                ->where('color_id', $colorId)
                ->whereNull('config_id')
                ->where('is_main', true)
                ->exists();

            foreach ($files as $index => $file) {
                $imagePath = $this->uploadFileToPublicUploads($file);
                if (empty($imagePath)) {
                    continue;
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => (int) $colorId,
                    'config_id' => null,
                    'image_path' => $imagePath,
                    'display_order' => $nextOrder + $index,
                    'is_main' => !$hasMain && $index === 0,
                ]);
            }
        }
    }

    protected function syncVariantImages(Product $product, Request $request)
    {
        if (!$this->hasProductImagesTable()) {
            return;
        }

        if (!$request->hasFile('variant_images')) {
            return;
        }

        $variantImages = $request->file('variant_images');
        
        foreach ($variantImages as $colorId => $sizeData) {
            foreach ($sizeData as $configId => $files) {
                if (!is_array($files)) {
                    continue;
                }

                // Get max display order for this variant
                $maxOrder = ProductImage::where('product_id', $product->id)
                    ->where('color_id', $colorId)
                    ->where('config_id', $configId)
                    ->max('display_order');
                $nextOrder = is_null($maxOrder) ? 0 : $maxOrder + 1;

                // Check if this variant already has a main image
                $hasMain = ProductImage::where('product_id', $product->id)
                    ->where('color_id', $colorId)
                    ->where('config_id', $configId)
                    ->where('is_main', true)
                    ->exists();

                foreach ($files as $index => $file) {
                    $imagePath = $this->uploadFileToPublicUploads($file);
                    if (empty($imagePath)) {
                        continue;
                    }

                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id' => (int) $colorId,
                        'config_id' => (int) $configId,
                        'image_path' => $imagePath,
                        'display_order' => $nextOrder + $index,
                        'is_main' => !$hasMain && $index === 0,
                    ]);
                }
            }
        }
    }

    protected function hasProductVariantsTable()
    {
        return Schema::hasTable('product_variants');
    }

    protected function hasProductImagesTable()
    {
        return Schema::hasTable('product_images');
    }

    function category()
    {
        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        // return dd($categories->toArray());

        return view('admin.product.cat', compact('categoryOptions'));
    }

    function category_add(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => 'Vai trò đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên danh mục',
                'slug' => 'Slug',
            ]
        );

        $parentId = $request->input('parent_category') ? $request->input('parent_category') : 0;
        Cat_product::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'parent_id' => $parentId,
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'status' => $request->input('status'),
        ]);
        toastr()->success('Đã thêm danh mục thành công!');
        return redirect('admin/product/cat');
    }

    function cat_edit(Cat_product $cat)
    {
        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        $creator = getFieldbyID(User::class, 'name', $cat->creator);
        $data = array(
            'id' => $cat->id,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'parent_id' => $cat->parent_id,
            'status' => $cat->status,
            'creator' => $creator,
            'dataTree' => $categoryOptions,
            'created_at' => $cat->created_at,
            'updated_at' => $cat->updated_at,
        );
        echo json_encode($data);
    }

    function cat_update(Request $request, Cat_product $cat)
    {
        $parentId = $request->input('parent_category') ?  $request->input('parent_category') : 0;

        $cat->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'parent_id' => $parentId,
            'status' => $request->input('status'),
        ]);
        toastr()->success('Cập nhật thành công!');
        return redirect('admin/product/cat');
    }

    function cat_delete(Cat_product $cat)
    {
        $cat_products = Cat_product::all();
        $cat->delete();
        $cat_products->where('parent_id', $cat->id)->each(function ($item) {
            $item->delete();
        });
        toastr()->success('Đã xóa danh mục!');
        return redirect('admin/product/cat');
    }


    function color()
    {
        $colors = Color::all();

        return view('admin.product.color', compact('colors'));
    }

    function edit(Color $color)
    {
        $creator = getFieldbyID(User::class, 'name', $color->creator);
        $data = array(
            'id' => $color->id,
            'name' => $color->name,
            'slug' => $color->slug,
            'code' => $color->code,
            'creator' => $creator,
            'status' => $color->status,
            'created_at' => $color->created_at,
            'updated_at' => $color->updated_at,
        );
        echo json_encode($data);
    }

    function color_add(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:colors'],
                'slug' => ['required', 'string', 'max:20'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Màu sắc',
                'slug' => 'Slug',
            ]
        );

        Color::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'code' => $request->input('code'),
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'status' => $request->input('status'),
        ]);
        // return dd($request->input());
        toastr()->success('Đã thêm màu sắc thành công!');
        return redirect('admin/product/color');
    }

    function color_update(Request $request, Color $color)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:colors,name,' . $color->id],
                'slug' => ['required', 'string', 'max:20'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Màu sắc',
                'slug' => 'Slug',
            ]
        );
        $color->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'code' => $request->input('code'),
            'status' => $request->input('status'),
        ]);
        toastr()->success('Cập nhật màu sắc thành công!');
        return redirect('admin/product/color');
    }

    function config(Request $request)
    {
        $configs = Config::all();
        return view('admin.product.config', compact('configs'));
    }

    function config_add(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:configs'],
                'slug' => ['required'],
                'storage' => ['required', 'string', 'max:20'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Màu sắc',
                'slug' => 'Slug',
                'storage' => 'Kích cỡ',
            ]
        );

        // return $request->input();
        Config::create([
            'name' => $request->input('name'),
            'memory' => $request->input('storage'),
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'status' => $request->input('status')
        ]);
        toastr()->success('Đã thêm kích cỡ thành công!');
        return redirect('admin/product/config');
    }

    function config_edit(Config $config)
    {
        $creator = getFieldbyID(User::class, 'name', $config->creator);
        $data = array(
            'id' => $config->id,
            'name' => $config->name,
            'storage' => $config->memory,
            'creator' => $creator,
            'status' => $config->status,
            'created_at' => $config->created_at,
            'updated_at' => $config->updated_at,
        );
        echo json_encode($data);
    }

    function config_update(Request $request, Config $config)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:configs,name,' . $config->id],
                'storage' => ['required', 'string', 'max:20'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Màu sắc',
                'storage' => 'Khả năng lữu trữ',
            ]
        );

        // return $request->input();
        $config->update([
            'name' => $request->input('name'),
            'memory' => $request->input('storage'),
            'status' => $request->input('status')
        ]);
        toastr()->success('Cập nhật thành công!');

        return redirect('admin/product/config');
    }

    function config_delete(Config $config)
    {
        $config->delete();
        toastr()->success('Đã xóa kích cỡ!');
        return redirect()->route('product.config');
    }

    function color_delete(Color $color)
    {
        $color->delete();
        toastr()->success('Đã xóa màu sắc!');
        return redirect()->route('product.color');
    }

    function product_delete(Product $product)
    {
        $product->delete();
        toastr()->error('Đã thêm sản phẩm vào mục tạm xóa!');
        return redirect()->route('product.view');
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        // return $request->input();
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'disable') {
                Product::destroy($list_check);
                toastr()->warning('Đã vô hiệu hóa sản phẩm!');
                return redirect()->route('product.view');
            } elseif ($act == 'restore') {
                Product::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                toastr()->success('Đã khôi phục sản phẩm!');
                return redirect()->route('product.view');
            } elseif ($act == 'forceDelete') {
                Product::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete($list_check);
                toastr()->error('Đã xóa sản phẩm!');
                return redirect()->route('product.view');
            }
        } else {
            toastr()->info('Bạn cần chọn phần tử trước khi thực thi!');
            return redirect()->route('product.view');
        }
    }

    public function restore($id)
    {
        Product::withTrashed()->find($id)->restore();
        toastr()->success('Sản phẩm đã được kích hoạt lại!');
        return redirect()->route('product.view');
    }

    public function forceDelete($id)
    {
        Product::withTrashed()->find($id)->forceDelete();
        toastr()->error('Đã xóa sản phẩm!');
        return redirect()->route('product.view');
    }
}
