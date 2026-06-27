<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'customer']);
            return $next($request);
        });
    }

    public function list()
    {
        $groups = CustomerGroup::withCount('users')->get();
        return view('admin.customer_group.list', compact('groups'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:customer_groups,name',
            'description' => 'nullable|string'
        ]);

        CustomerGroup::create([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        return redirect()->route('admin.customer_group.list')->with([
            'status' => 'Thêm nhóm khách hàng mới thành công!',
            'color' => 'alert-success'
        ]);
    }

    public function edit($id)
    {
        $group = CustomerGroup::findOrFail($id);
        return view('admin.customer_group.edit', compact('group'));
    }

    public function update(Request $request, $id)
    {
        $group = CustomerGroup::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:customer_groups,name,' . $id,
            'description' => 'nullable|string'
        ]);

        $group->update([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        return redirect()->route('admin.customer_group.list')->with([
            'status' => 'Cập nhật nhóm khách hàng thành công!',
            'color' => 'alert-success'
        ]);
    }

    public function delete($id)
    {
        $group = CustomerGroup::findOrFail($id);
        
        // Prevent deleting critical groups
        if (in_array($group->id, [1, 2, 3])) {
            return redirect()->route('admin.customer_group.list')->with([
                'status' => 'Không thể xóa các nhóm khách hàng mặc định của hệ thống!',
                'color' => 'alert-danger'
            ]);
        }

        $group->delete();

        return redirect()->route('admin.customer_group.list')->with([
            'status' => 'Xóa nhóm khách hàng thành công!',
            'color' => 'alert-success'
        ]);
    }
}
