<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }

    function index(Request $request)
    {
        if ($request->input('status') == 'active' && $request->input('status') != '' || $request->input('status') == '') {;
            $keyword = $request->input('key', '');
            $sliders = Slider::where('name', 'LIKE', "%$keyword%")->orderBy('id', 'asc')->paginate(15);

            $list_act = [
                'disable' => 'Vô hiệu hóa'
            ];
            $url_delete = 'admin/slider/delete/';
            $url_btn_success = 'admin/slider/edit/';
        } else {
            $keyword = $request->input('key', '');
            $sliders = Slider::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->orderBy('id', 'asc')->paginate(15);
            $list_act = [
                'restore' => 'Kích hoạt',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $url_delete = 'admin/slider/forcedelete/';
            $url_btn_success = 'admin/slider/restore/';
        }
        $numUsersActive = Slider::count();
        $numSoftDelete = Slider::onlyTrashed()->count();

        return view('admin.slider.list', compact('sliders', 'keyword', 'numUsersActive', 'numSoftDelete', 'list_act', 'url_delete', 'url_btn_success'));
    }

    function add()
    {
        return view('admin.slider.add');
    }

    function handle_add(Request $request)
    {

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'unique:sliders'],
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
                'name' => 'Tên slider',
                'sort' => 'Thứ tự',
                'file' => 'Slider',
            ]
        );

        // return $request->input();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                session(['file' => $fileName]);
                $destinationPath = public_path('uploads');
                $file->move($destinationPath, $fileName);
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $link = $request->input('link') ? $request->input('link') : '#';
        $slider = Slider::create([
            'name' => $request->input('name'),
            'link' => $link,
            'thumb_slider' => 'uploads/' . $fileName,
            'sort' => $request->input('sort'),
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'status' => $request->input('status')
        ]);
        return redirect('admin/slider/add')->with('status', '▶Đã thêm slider thành công!');
    }

    function edit(Slider $slider)
    {
        $data = array(
            'id' => $slider->id,
            'name' => $slider->name,
            'url' => $slider->link,
            'link' => $slider->thumb_slider,
            'creator' => $slider->Users->name,
            'sort' => $slider->sort,
            'status' => $slider->status,
            'created_at' => $slider->created_at,
            'updated_at' => $slider->updated_at,
        );
        echo json_encode($data);
    }

    function update(Slider $slider, Request $request)
    {

        // return dd($request->all());
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'sort' => ['required', 'unique:sliders,sort,' . $slider->id],
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
                'name' => 'Tên slider',
                'sort' => 'Thứ tự',
                'file' => 'Slider',
            ]
        );

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                session(['file' => $fileName]);
                $destinationPath = public_path('uploads');
                $file->move($destinationPath, $fileName);

                $slider->update([
                    'name' => $request->input('name'),
                    'link' => $request->input('link'),
                    'thumb_slider' => 'uploads/' . $fileName,
                    'sort' => $request->input('sort'),
                    'status' => $request->input('status')
                ]);
                return redirect('admin/slider/list')->with('status', '▶Cập nhật thành công!');
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $slider->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'sort' => $request->input('sort'),
            'status' => $request->input('status')
        ]);

        return redirect('admin/slider/list')->with('status', '▶Cập nhật thành công!');
    }

    function delete(Slider $slider)
    {
        $slider->delete();
        return redirect('admin/slider/list')->with('status', '▶Đã xóa slider!');
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        // return $request->input();
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'disable') {
                Slider::destroy($list_check);
                toastr()->warning('Đã vô hiệu hóa sản phẩm!');
                return redirect()->route('admin.slider.list');
            } elseif ($act == 'restore') {
                Slider::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                toastr()->success('Đã khôi phục sản phẩm!');
                return redirect()->route('admin.slider.list');
            } elseif ($act == 'forceDelete') {
                Slider::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete($list_check);
                toastr()->error('Đã xóa sản phẩm!');
                return redirect()->route('admin.slider.list');
            }
        } else {
            toastr()->info('Bạn cần chọn phần tử trước khi thực thi!');
            return redirect()->route('admin.slider.list');
        }
    }

    public function restore($id)
    {
        Slider::withTrashed()->find($id)->restore();
        toastr()->success('Sản phẩm đã được kích hoạt lại!');
        return redirect()->route('admin.slider.list');
    }

    public function forceDelete($id)
    {
        Slider::withTrashed()->find($id)->forceDelete();
        toastr()->success('Đã xóa sản phẩm!');
        return redirect()->route('admin.slider.list');
    }
}
