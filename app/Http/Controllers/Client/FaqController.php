<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class FaqController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['client_module_active' => 'faq']);
            return $next($request);
        });
    }
    function index()
    {
        $banners = Banner::orderBy('sort', 'asc')->get();
        $bestseller = Product::orderBy('purchases', 'desc')->take(4)->get();
        return view('client.pages.faq', compact('banners', 'bestseller'));
    }
}
