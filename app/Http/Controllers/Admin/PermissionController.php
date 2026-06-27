<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Permission;

class PermissionController extends Controller
{

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }
    public function show_array($data)
    {
        echo '<pre>';
        print_r($data->toArray());
        echo '</pre>';
    }

    function add()
    {
        // $permission = Permission::all();
        $permission = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        // dd($permission);
        // return dd($permission);

        return view('admin.permission.add', compact('permission'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'string', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống!',
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Slug',
            ]
        );
        Permission::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ]);
        return redirect('admin/permission/add')->with('status', 'Đã thêm quyền thành công!');
    }

    function update($id)
    {
        $permission = Permission::find($id);
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        // $this->show_array($permission);
        return view('admin.permission.update', compact('permissions', 'permission'));
    }

    function handleUpdate(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'string', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống!',
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Slug',
            ]
        );
        Permission::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ]);
        return redirect('admin/permission/add')->with('status', 'Cập nhật thành công!');
    }

    function delete($id)
    {
        Permission::where('id', $id)->delete();
        return redirect('admin/permission/add')->with('status', 'Đã xóa quyền thành công!');
    }
}
