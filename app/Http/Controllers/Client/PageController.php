<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Banner;
use App\Models\Cat_product;
use App\Models\Product;

class PageController extends Controller
{
    function __construct(Request $request)
    {
        $slug = $request->segment(1);
        $this->middleware(function ($request, $next) use ($slug) {
            session(['client_module_active' => $slug]);
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

    function index($slug)
    {

        $banners = Banner::orderBy('sort', 'asc')->get();
        $page = Page::where([
            ['slug', '=', $slug],
            ['status', '=', 1]
        ])->first();

        return view('client.pages.detailPage', compact('page', 'banners'));
    }
}
