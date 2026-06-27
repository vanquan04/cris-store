<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Product;

class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['client_module_active' => 'blog']);
            return $next($request);
        });
    }
    function index()
    {
        $banners = Banner::orderBy('sort', 'asc')->get();
        $posts = Blog::all();
        $bestseller = Product::orderBy('purchases', 'desc')->take(4)->get();
        return view('client.post.list', compact('posts', 'banners', 'bestseller'));
    }

    function blog_detail($slug)
    {
        $banners = Banner::orderBy('sort', 'asc')->get();
        $post = Blog::where('slug', $slug)->first();
        $bestseller = Product::orderBy('purchases', 'desc')->take(4)->get();
        return view('client.post.detail', compact('post', 'banners', 'bestseller'));
    }
}
