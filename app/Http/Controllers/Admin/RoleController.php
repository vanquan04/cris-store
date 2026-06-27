<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }

    public function add()
    {
        // if (!Gate::allows('admin.add')) {
        //     abort(403);
        // }

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        // return dd(Permission::all()->toArray());
        return view('admin.role.add-role', compact('permissions'));
    }

    public function addHandle(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:roles'],
                'description' => ['required', 'string', 'max:255'],
                'permission_id' => 'nullable|array',
                // 'permission_id.*' => 'exists:pessmision,id',
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => 'Vai trò đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên người dùng',
                'description' => 'Mô tả'
            ]
        );
        // return dd($request->input());

        $role = Role::create([
            'name' => $request->input('name'),
            'description' =>  $request->input('description')
        ]);

        $role->Permissions()->attach($request->input('permission_id'));
        return redirect('admin/role/list')->with('status', 'Đã thêm vai trò thành công!');
    }

    public function list()
    {
        $roles = Role::all();
        return view('admin.role.list-role', compact('roles'));
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        return redirect('admin/role/list')->with('status', 'Đã xóa vai trò!');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.role.edit-role', compact('permissions', 'role'));
    }

    public function update(Request $request, Role $role)
    {

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
                'description' => ['required', 'string', 'max:255'],
                'permission_id' => 'nullable|array',
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => 'Vai trò đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên người dùng',
                'description' => 'Mô tả'
            ]
        );

        $role->update([
            'name' => $request->input('name'),
            'description' =>  $request->input('description')
        ]);


        $role->Permissions()->sync($request->input('permission_id', []));
        return redirect('admin/role/list')->with('status', 'Đã cập nhật vai trò thành công!');
    }
}
