<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'customer']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $groupId = $request->input('group_id', '');

        if ($request->input('status') == 'active' && $request->input('status') != '' || $request->input('status') == '') {
            $query = User::where('isAdmin', 0);
            if (!empty($groupId)) {
                $query->where('users.group_id', $groupId);
            }
            
            $customers = $query->where(function($q) use ($keyword) {
                    if (!empty($keyword)) {
                        $q->where('users.name', 'LIKE', "%{$keyword}%")
                          ->orWhere('users.username', 'LIKE', "%{$keyword}%")
                          ->orWhere('users.email', 'LIKE', "%{$keyword}%")
                          ->orWhere('users.phone', 'LIKE', "%{$keyword}%");
                    }
                })
                ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.username',
                    'users.email',
                    'users.phone',
                    'users.points',
                    'users.group_id',
                    'users.created_at',
                    'users.deleted_at',
                    DB::raw('COALESCE(SUM(orders.total), 0) as total_spent'),
                    DB::raw('COUNT(orders.id) as total_orders'),
                    DB::raw('COALESCE(SUM(orders.amount), 0) as total_qty')
                )
                ->groupBy(
                    'users.id',
                    'users.name',
                    'users.username',
                    'users.email',
                    'users.phone',
                    'users.points',
                    'users.group_id',
                    'users.created_at',
                    'users.deleted_at'
                )
                ->orderBy('users.id', 'desc')
                ->paginate(15);

            $list_act = [
                'disable' => 'Vô hiệu hóa'
            ];
            $status = 'active';
        } else {
            $query = User::onlyTrashed()->where('isAdmin', 0);
            if (!empty($groupId)) {
                $query->where('users.group_id', $groupId);
            }

            $customers = $query->where(function($q) use ($keyword) {
                    if (!empty($keyword)) {
                        $q->where('users.name', 'LIKE', "%{$keyword}%")
                          ->orWhere('users.username', 'LIKE', "%{$keyword}%")
                          ->orWhere('users.email', 'LIKE', "%{$keyword}%")
                          ->orWhere('users.phone', 'LIKE', "%{$keyword}%");
                    }
                })
                ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.username',
                    'users.email',
                    'users.phone',
                    'users.points',
                    'users.group_id',
                    'users.created_at',
                    'users.deleted_at',
                    DB::raw('COALESCE(SUM(orders.total), 0) as total_spent'),
                    DB::raw('COUNT(orders.id) as total_orders'),
                    DB::raw('COALESCE(SUM(orders.amount), 0) as total_qty')
                )
                ->groupBy(
                    'users.id',
                    'users.name',
                    'users.username',
                    'users.email',
                    'users.phone',
                    'users.points',
                    'users.group_id',
                    'users.created_at',
                    'users.deleted_at'
                )
                ->orderBy('users.id', 'desc')
                ->paginate(15);

            $list_act = [
                'restore' => 'Kích hoạt',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $status = 'trash';
        }
        
        $numActive = User::where('isAdmin', 0)->count();
        $numTrash = User::where('isAdmin', 0)->onlyTrashed()->count();
        $groups = \App\Models\CustomerGroup::all();

        return view('admin.customer.list', compact(
            'customers', 'keyword', 'numActive', 'numTrash', 'list_act', 'status', 'groups', 'groupId'
        ));
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return redirect('admin/customer/list')->with([
            'status' => 'Đã xóa khách hàng thành công!',
            'color' => 'alert-success'
        ]);
    }

    public function forceDelete($id)
    {
        User::withTrashed()->find($id)->forceDelete();
        return redirect('admin/customer/list')->with([
            'status' => 'Đã xóa vĩnh viễn khách hàng!',
            'color' => 'alert-success'
        ]);
    }

    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();
        return redirect('admin/customer/list')->with([
            'status' => 'Đã khôi phục khách hàng!',
            'color' => 'alert-success'
        ]);
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'disable') {
                User::destroy($list_check);
                return redirect('admin/customer/list')->with([
                    'status' => 'Đã vô hiệu hóa thành công!',
                    'color' => 'alert-danger'
                ]);
            } elseif ($act == 'restore') {
                User::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                return redirect('admin/customer/list')->with([
                    'status' => 'Đã khôi phục thành công!',
                    'color' => 'alert-success'
                ]);
            } elseif ($act == 'forceDelete') {
                User::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete();
                return redirect('admin/customer/list')->with([
                    'status' => 'Đã xóa vĩnh viễn!',
                    'color' => 'alert-danger'
                ]);
            }
        } else {
            return redirect('admin/customer/list')->with([
                'status' => 'Bạn cần chọn phần tử trước khi thực thi!',
                'color' => 'alert-danger'
            ]);
        }
    }

    public function edit($id)
    {
        $customer = User::find($id);
        if (!$customer) {
            return redirect('admin/customer/list')->with([
                'status' => 'Không tìm thấy khách hàng!',
                'color' => 'alert-danger'
            ]);
        }
        $groups = \App\Models\CustomerGroup::all();
        return view('admin.customer.edit', compact('customer', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $customer = User::find($id);
        if (!$customer) {
            return redirect('admin/customer/list')->with([
                'status' => 'Không tìm thấy khách hàng!',
                'color' => 'alert-danger'
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'group_id' => 'nullable|exists:customer_groups,id'
        ]);

        $customer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'group_id' => $request->input('group_id')
        ]);

        return redirect('admin/customer/list')->with([
            'status' => 'Cập nhật thông tin khách hàng thành công!',
            'color' => 'alert-success'
        ]);
    }
}
