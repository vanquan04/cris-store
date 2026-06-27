<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Cat_product;
use App\Models\Product;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'promotion']);
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $promotions = Promotion::orderBy('id', 'desc')->paginate(15);
        $numActive = Promotion::count();
        $numSoftDelete = 0; // no soft deletes for now
        $list_act = [
            'delete' => 'Xóa'
        ];
        return view('admin.promotion.index', compact('promotions', 'numActive', 'numSoftDelete', 'list_act'));
    }

    public function create()
    {
        $categories = Cat_product::all();
        $products = Product::orderBy('name')->get();
        return view('admin.promotion.add', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:promotions,slug',
            'discount_percent' => 'nullable|integer|min:0|max:100'
        ]);

        Promotion::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('slug')),
            'description' => $request->input('description'),
            'discount_percent' => $request->input('discount_percent') ?: 0,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'status' => $request->input('status') ? 1 : 0,
        ]);

        $promotion = Promotion::where('slug', Str::slug($request->input('slug')))->first();
        if ($promotion) {
            $cats = $request->input('categories', []);
            $prods = $request->input('products', []);
            $promotion->categories()->sync($cats);
            $promotion->products()->sync($prods);
        }

        toastr()->success('Đã thêm khuyến mãi thành công!');
        return redirect()->route('admin.promotion.index');
    }

    public function edit(Promotion $promotion)
    {
        $categories = Cat_product::all();
        $products = Product::orderBy('name')->get();
        return view('admin.promotion.edit', compact('promotion', 'categories', 'products'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:promotions,slug,' . $promotion->id,
            'discount_percent' => 'nullable|integer|min:0|max:100'
        ]);

        $promotion->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('slug')),
            'description' => $request->input('description'),
            'discount_percent' => $request->input('discount_percent') ?: 0,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => $request->input('status') ? 1 : 0,
        ]);

        $cats = $request->input('categories', []);
        $prods = $request->input('products', []);
        $promotion->categories()->sync($cats);
        $promotion->products()->sync($prods);

        toastr()->success('Cập nhật khuyến mãi thành công!');
        return redirect()->route('admin.promotion.index');
    }

    public function delete(Promotion $promotion)
    {
        $promotion->delete();
        toastr()->success('Đã xóa khuyến mãi!');
        return redirect()->route('admin.promotion.index');
    }
}
