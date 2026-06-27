<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'banner']);
            return $next($request);
        });
    }

    function index(Request $request)
    {
        if ($request->input('status') == 'active' && $request->input('status') != '' || $request->input('status') == '') {;
            $keyword = $request->input('key', '');
            $banners = Banner::where('name', 'LIKE', "%$keyword%")->orderBy('id', 'asc')->paginate(15);

            $list_act = [
                'disable' => 'Vô hiệu hóa'
            ];
            $url_delete = 'admin/banner/delete/';
            $url_btn_success = 'admin/banner/edit/';
        } else {
            $keyword = $request->input('key', '');
            $banners = Banner::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->orderBy('id', 'asc')->paginate(15);
            $list_act = [
                'restore' => 'Kích hoạt',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $url_delete = 'admin/banner/forcedelete/';
            $url_btn_success = 'admin/banner/restore/';
        }
        $numUsersActive = Banner::count();
        $numSoftDelete = Banner::onlyTrashed()->count();

        return view('admin.banner.list', compact('banners', 'keyword', 'numUsersActive', 'numSoftDelete', 'list_act', 'url_delete', 'url_btn_success'));
    }

    function add()
    {
        return view('admin.banner.add');
    }

    function handle_add(Request $request)
    {

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'unique:banners'],
                'file' => ['required', 'max:5242880', 'image', 'mimes:jpeg,jpg,png,gif'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute phải là một hình ảnh!',
                'mimes' => ':attribute phải có định dạng jpg, png, jpeg, gif',
            ],
            [
                'name' => 'Tên banner',
                'sort' => 'Thứ tự',
                'file' => 'Banner',
            ]
        );

        // return $request->input();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path('uploads');
                $file->move($destinationPath, $fileName);
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $link = $request->input('link') ? $request->input('link') : '#';
        $banner = Banner::create([
            'name' => $request->input('name'),
            'link' => $link,
            'thumb_banner' => 'uploads/' . $fileName,
            'sort' => $request->input('sort'),
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'status' => $request->input('status')
        ]);
        return redirect('admin/banner/add')->with('status', '▶Thêm banner thành công!');
    }

    function edit(Banner $banner)
    {
        $data = array(
            'id' => $banner->id,
            'name' => $banner->name,
            'url' => $banner->link,
            'link' => $banner->thumb_banner,
            'creator' => $banner->Users->name,
            'sort' => $banner->sort,
            'status' => $banner->status,
            'created_at' => $banner->created_at,
            'updated_at' => $banner->updated_at,
        );
        echo json_encode($data);
    }

    function update(Banner $banner, Request $request)
    {

        // return dd($request->all());
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'unique:banners,sort,' . $banner->id],
                'file' => ['max:5242880', 'image', 'mimes:jpeg,jpg,png,gif'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute phải là một hình ảnh!',
                'mimes' => ':attribute phải có định dạng jpg, png, jpeg, gif',
            ],
            [
                'name' => 'Tên banner',
                'sort' => 'Thứ tự',
                'file' => 'Banner',
            ]
        );

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                session(['file' => $fileName]);
                $destinationPath = public_path('uploads');
                $file->move($destinationPath, $fileName);

                $banner->update([
                    'name' => $request->input('name'),
                    'link' => $request->input('link'),
                    'thumb_banner' => 'uploads/' . $fileName,
                    'sort' => $request->input('sort'),
                    'status' => $request->input('status')
                ]);
                return redirect('admin/banner/list')->with('status', '▶Cập nhật thành công!');
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $banner->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'sort' => $request->input('sort'),
            'status' => $request->input('status')
        ]);

        return redirect('admin/banner/list')->with('status', '▶Cập nhật thành công!');
    }

    function delete(Banner $banner)
    {
        $banner->delete();
        toastr()->error('Đã thêm banner vào mục tạm xóa!');
        return redirect()->route('admin.banner.list');
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        // return $request->input();
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'disable') {
                Banner::destroy($list_check);
                toastr()->warning('Đã vô hiệu hóa banner!');
                return redirect()->route('admin.banner.list');
            } elseif ($act == 'restore') {
                Banner::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                toastr()->success('Đã khôi phục banner!');
                return redirect()->route('admin.banner.list');
            } elseif ($act == 'forceDelete') {
                Banner::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete($list_check);
                toastr()->error('Đã xóa banner!');
                return redirect()->route('admin.banner.list');
            }
        } else {
            toastr()->info('Bạn cần chọn phần tử trước khi thực thi!');
            return redirect()->route('admin.banner.list');
        }
    }

    public function restore($id)
    {
        Banner::withTrashed()->find($id)->restore();
        toastr()->success('Sản phẩm đã được kích hoạt lại!');
        return redirect()->route('product.view');
    }

    public function forceDelete($id)
    {
        Banner::withTrashed()->find($id)->forceDelete();
        toastr()->error('Đã xóa banner!');
        return redirect()->route('product.view');
    }
}
