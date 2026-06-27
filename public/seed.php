<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

try {
    \Illuminate\Support\Facades\DB::statement('ALTER TABLE permissions MODIFY id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT');
} catch (\Exception $e) {
    // ignore
}

try {
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

    foreach ($modules as $moduleSlug => $moduleName) {
        foreach ($actions as $actionSlug => $actionName) {
            $slug = $moduleSlug . '.' . $actionSlug;
            $exists = \Illuminate\Support\Facades\DB::table('permissions')->where('slug', $slug)->exists();
            if (!$exists) {
                $maxId = \Illuminate\Support\Facades\DB::table('permissions')->max('id');
                \Illuminate\Support\Facades\DB::table('permissions')->insert([
                    'id' => $maxId + 1,
                    'slug' => $slug,
                    'name' => "{$actionName} {$moduleName}",
                    'description' => "Cho phép {$actionName} {$moduleName}",
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
    echo "Seeded successfully";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
