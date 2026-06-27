<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Cat_blog;
use App\Models\User;

class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'blog']);
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

    function index(Request $request)
    {
        if ($request->input('status') == 'active' && $request->input('status') != '' || $request->input('status') == '') {;
            $keyword = $request->input('key', '');
            $posts = Blog::where('name', 'LIKE', "%$keyword%")->orderBy('id', 'asc')->paginate(15);

            $list_act = [
                'disable' => 'Vô hiệu hóa'
            ];
            $url_delete = 'admin/post/delete/';
            $url_btn_success = 'admin/post/edit/';
        } else {
            $keyword = $request->input('key', '');
            $posts = Blog::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->orderBy('id', 'asc')->paginate(15);
            $list_act = [
                'restore' => 'Kích hoạt',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $url_delete = 'admin/post/forcedelete/';
            $url_btn_success = 'admin/post/restore/';
        }
        $numUsersActive = Blog::count();
        $numSoftDelete = Blog::onlyTrashed()->count();

        return view('admin.blog.list', compact('posts', 'keyword', 'numUsersActive', 'numSoftDelete', 'list_act', 'url_delete', 'url_btn_success'));
    }

    function add()
    {
        $categories = Cat_blog::all();
        $categoryOptions = $this->data_tree($categories);
        return view('admin.blog.add', compact('categoryOptions'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100', 'unique:blogs'],
                'slug' => ['required', 'string', 'max:100', 'unique:blogs'],
                'content-demo' => ['required', 'string', 'max:500'],
                'content' => ['required', 'string'],
                'cat_id' => ['required'],
                'file' => ['required', 'max:5242880', 'image'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
                'image' => ':attribute phải là một hình ảnh',
            ],
            [
                'name' => 'Tiêu đề bài viết',
                'slug' => 'Slug',
                'content-demo' => 'Nội dung demo',
                'content' => 'Nội dung bài viết',
                'cat_id' => 'Danh mục',
                'file' => 'Ảnh bài viết',
            ]
        );

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

        // return dd($request->input());
        Blog::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'thumb_main' => 'uploads/' . $fileName,
            'cat_parent' => $request->input('cat_id'),
            'content_demo' => $request->input('content-demo'),
            'content' => $request->input('content'),
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'status' => $request->input('status'),
        ]);

        toastr()->success('Thêm bài viết thành công!');
        return redirect()->route('admin.post.add');
    }
    function category()
    {
        $categories = Cat_blog::all();
        $categoryOptions = $this->data_tree($categories);

        return view('admin.blog.cat', compact('categoryOptions'));
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
        Cat_blog::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'parent_id' => $parentId,
            'creator' => Auth::guard('sanctum')->id() ?? 41,
            'status' => $request->input('status'),
        ]);
        toastr()->success('Đã thêm danh mục thành công!');
        return redirect('admin/post/cat');
    }

    function edit(Blog $post)
    {
        $categories = Cat_blog::all();
        $categoryOptions = $this->data_tree($categories);
        return view('admin.blog.edit', compact('categoryOptions', 'post'));
    }

    function update(Request $request, Blog $post)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100', 'unique:blogs,name,' . $post->id],
                'slug' => ['required', 'string', 'max:100', 'unique:blogs,slug,' . $post->id],
                'content-demo' => ['required', 'string', 'max:500'],
                'content' => ['required', 'string'],
                'cat_id' => ['required'],
                'file' => ['max:5242880', 'image'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
                'image' => ':attribute phải là một hình ảnh',
            ],
            [
                'name' => 'Tiêu đề bài viết',
                'slug' => 'Slug',
                'content-demo' => 'Nội dung demo',
                'content' => 'Nội dung bài viết',
                'cat_id' => 'Danh mục',
                'file' => 'Ảnh bài viết',
            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path('uploads');
                $file->move($destinationPath, $fileName);
            } else {
                echo 'Ảnh không hợp lệ';
            }  // return dd($request->input());
            $post->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'thumb_main' => 'uploads/' . $fileName,
                'cat_parent' => $request->input('cat_id'),
                'content_demo' => $request->input('content-demo'),
                'content' => $request->input('content'),
                'creator' => Auth::guard('sanctum')->id() ?? 41,
                'status' => $request->input('status'),
            ]);
        } else {
            $post->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'cat_parent' => $request->input('cat_id'),
                'content_demo' => $request->input('content-demo'),
                'content' => $request->input('content'),
                'creator' => Auth::guard('sanctum')->id() ?? 41,
                'status' => $request->input('status'),
            ]);
        }

        toastr()->success('Đã cập nhật bài viết thành công!');
        return redirect()->route('post.edit', $post->id);
    }

    function category_delete(Cat_blog $cat)
    {
        $cat->delete();
        toastr()->success('Đã xóa danh mục!');
        return redirect()->route('post.cat');
    }

    function category_edit(Cat_blog $cat)
    {
        $creator = getFieldbyID(User::class, 'name', $cat->cat_parent);
        $data = array(
            'id' => $cat->id,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'parent_id' => $cat->parent_id,
            'code' => $cat->code,
            'creator' => $creator,
            'status' => $cat->status,
            'created_at' => $cat->created_at,
            'updated_at' => $cat->updated_at,
        );
        echo json_encode($data);
    }

    function category_update(Request $request, Cat_blog $cat)
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

        $parentId = $request->input('parent_category') ?  $request->input('parent_category') : 0;

        $cat->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'parent_id' => $parentId,
            'status' => $request->input('status'),
        ]);
        toastr()->success('Cập nhật thành công!');
        return redirect()->route('post.cat');
    }

    function delete(Blog $post)
    {
        $post->delete();
        toastr()->success('Đã thêm bài viết vào mục tạm xóa!');
        return redirect()->route('post.list');
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        // return $request->input();
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'disable') {
                Blog::destroy($list_check);
                toastr()->warning('Đã vô hiệu hóa bài viết!');
                return redirect()->route('post.list');
            } elseif ($act == 'restore') {
                Blog::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                toastr()->success('Đã khôi phục bài viết!');
                return redirect()->route('post.list');
            } elseif ($act == 'forceDelete') {
                Blog::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete($list_check);
                toastr()->error('Đã xóa bài viết!');
                return redirect()->route('post.list');
            }
        } else {
            toastr()->info('Bạn cần chọn phần tử trước khi thực thi!');
            return redirect()->route('post.list');
        }
    }

    public function restore($id)
    {
        echo $id;
        Blog::withTrashed()->find($id)->restore();
        toastr()->success('Sản phẩm đã được kích hoạt lại!');
        return redirect()->route('post.list');
    }

    public function forceDelete($id)
    {
        Blog::withTrashed()->find($id)->forceDelete();
        toastr()->error('Đã xóa bài viết!');
        return redirect()->route('post.list');
    }
}
