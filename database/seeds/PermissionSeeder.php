<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            'dashboard' => 'Dashboard',
            'user' => 'Quản trị viên',
            'role' => 'Vai trò',
            'permission' => 'Phân quyền',
            'blog' => 'Bài viết',
            'product' => 'Sản phẩm',
            'slider' => 'Slider',
            'banner' => 'Banner',
            'page' => 'Trang',
            'promotion' => 'Khuyến mãi',
            'chatbox' => 'Chatbox AI',
            'feedback' => 'Phản hồi',
            'customer' => 'Khách hàng',
            'customer_group' => 'Nhóm khách hàng',
            'subscriber' => 'Người đăng ký',
            'order' => 'Đơn hàng'
        ];

        $actions = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'update' => 'Sửa',
            'delete' => 'Xóa'
        ];

        // Ensure these basic permissions exist
        foreach ($modules as $moduleSlug => $moduleName) {
            foreach ($actions as $actionSlug => $actionName) {
                $permissionSlug = $moduleSlug . '.' . $actionSlug;
                
                Permission::firstOrCreate(
                    ['slug' => $permissionSlug],
                    [
                        'name' => "{$actionName} {$moduleName}",
                        'description' => "Cho phép {$actionName} {$moduleName}"
                    ]
                );
            }
        }
    }
}
