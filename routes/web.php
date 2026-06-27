<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


//================ADMIN==================
// Route::get('/home', 'Client\HomeController@index')->name('home');

Route::get('login', 'Admin\AuthController@login')->name('login');
Route::get('logout', 'Admin\AuthController@logout')->name('logout');
Route::post('handle', 'Admin\AuthController@handle')->name('handle.login');

Route::get('/run-seeder', function() {
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
            \App\Models\Permission::firstOrCreate(
                ['slug' => $moduleSlug . '.' . $actionSlug],
                [
                    'name' => "{$actionName} {$moduleName}",
                    'description' => "Cho phép {$actionName} {$moduleName}"
                ]
            );
        }
    }
    return 'Seeded successfully';
});


Route::middleware('CheckLogin')->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('dashboard', 'Admin\DashboardController@dashboard')->name('admin.dashboard')->middleware('CheckPermission:dashboard.view');
    Route::post('dashboard/detail/{order}', 'Admin\DashboardController@detail')->middleware('CheckPermission:order.view');
    Route::post('dashboard/update/{order}', 'Admin\DashboardController@update')->middleware('CheckPermission:order.update');
    Route::get('dashboard/delete/{order}', 'Admin\DashboardController@delete')->name('admin.dashboard.delete')->middleware('CheckPermission:order.delete');

    Route::get('user/list', 'Admin\UserController@list')->middleware('CheckPermission:user.view');
    Route::get('user/add', 'Admin\UserController@add')->name('admin.user.add')->middleware('CheckPermission:user.add');
    Route::post('user/store', 'Admin\UserController@store')->middleware('CheckPermission:user.add');
    Route::get('user/delete/{id}', 'Admin\UserController@delete')->middleware('CheckPermission:user.delete');
    Route::get('user/forcedelete/{id}', 'Admin\UserController@forceDelete')->middleware('CheckPermission:user.delete');
    Route::get('user/restore/{id}', 'Admin\UserController@restore')->middleware('CheckPermission:user.delete');
    Route::post('user/action', 'Admin\UserController@action');
    Route::get('user/edit/{id}', 'Admin\UserController@edit')->name('user.edit')->middleware('CheckPermission:user.update');
    Route::post('user/update/{id}', 'Admin\UserController@update')->name('user.update')->middleware('CheckPermission:user.update');
    Route::get('account/profile', 'Admin\UserController@profile')->name('admin.account.profile');
    Route::post('account/profile', 'Admin\UserController@updateProfile')->name('admin.account.update');
    Route::post('account/change-password', 'Admin\UserController@updatePassword')->name('admin.account.password');

    Route::get('role/add', 'Admin\RoleController@add')->name('admin.role.add')->middleware('CheckPermission:role.add');
    Route::post('role/addHandle', 'Admin\RoleController@addHandle')->name('role.addHandle')->middleware('CheckPermission:role.add');
    Route::get('role/list', 'Admin\RoleController@list')->name('role.list')->middleware('CheckPermission:role.view');
    Route::get('role/delete/{id}', 'Admin\RoleController@delete')->middleware('CheckPermission:role.delete');
    Route::get('role/edit/{role}', 'Admin\RoleController@edit')->name('role.edit')->middleware('CheckPermission:role.update');
    Route::post('role/update/{role}', 'Admin\RoleController@update')->name('role.update')->middleware('CheckPermission:role.update');

    Route::get('permission/add', 'Admin\PermissionController@add')->name('permission.add')->middleware('CheckPermission:permission.add');
    Route::post('permission/store', 'Admin\PermissionController@store')->name('permission.store')->middleware('CheckPermission:permission.add');
    Route::get('permission/update/{id}', 'Admin\PermissionController@update')->name('permission.update')->middleware('CheckPermission:permission.update');
    Route::post('permission/handleUpdate/{id}', 'Admin\PermissionController@handleUpdate')->name('permission.handleUpdate')->middleware('CheckPermission:permission.update');
    Route::get('permission/delete/{id}', 'Admin\PermissionController@delete')->name('permission.delete')->middleware('CheckPermission:permission.delete');

    Route::get('post/list', 'Admin\BlogController@index')->name('post.list')->middleware('CheckPermission:blog.view');
    Route::get('post/add', 'Admin\BlogController@add')->name('admin.post.add')->middleware('CheckPermission:blog.add');
    Route::post('post/store', 'Admin\BlogController@store')->name('post.store')->middleware('CheckPermission:blog.add');
    Route::get('post/edit/{post}', 'Admin\BlogController@edit')->name('post.edit')->middleware('CheckPermission:blog.update');
    Route::post('post/update/{post}', 'Admin\BlogController@update')->name('post.update')->middleware('CheckPermission:blog.update');
    Route::get('post/delete/{post}', 'Admin\BlogController@delete')->name('post.delete')->middleware('CheckPermission:blog.delete');
    Route::get('post/restore/{id}', 'Admin\BlogController@restore')->middleware('CheckPermission:blog.delete');
    Route::get('post/forcedelete/{post}', 'Admin\BlogController@forceDelete')->middleware('CheckPermission:blog.delete');
    Route::post('post/action', 'Admin\BlogController@action')->name('post.action')->middleware('CheckPermission:blog.delete');
    Route::get('post/cat', 'Admin\BlogController@category')->name('post.cat')->middleware('CheckPermission:post.add');
    Route::post('post/cat/add', 'Admin\BlogController@category_add')->name('post.cat.add')->middleware('CheckPermission:blog.add');
    Route::get('post/cat/delete/{cat}', 'Admin\BlogController@category_delete')->name('post.cat.delete')->middleware('CheckPermission:blog.delete');
    Route::post('post/cat/edit/{cat}', 'Admin\BlogController@category_edit')->name('post.cat.edit')->middleware('CheckPermission:blog.update');
    Route::post('post/cat/update/{cat}', 'Admin\BlogController@category_update')->name('post.cat.update')->middleware('CheckPermission:blog.update');

    Route::get('product/list', 'Admin\ProductController@list')->name('product.view')->middleware('CheckPermission:product.view');
    Route::get('product/add', 'Admin\ProductController@add')->name('product.add')->middleware('CheckPermission:product.add');
    Route::post('product/handle_add', 'Admin\ProductController@handle_add')->name('product.handle.add')->middleware('CheckPermission:product.add');
    Route::get('product/edit/{product}', 'Admin\ProductController@product_edit')->name('product.edit')->middleware('CheckPermission:product.update');
    Route::post('product/update/{product}', 'Admin\ProductController@product_update')->name('product.update')->middleware('CheckPermission:product.update');
    Route::get('product/delete/{product}', 'Admin\ProductController@product_delete')->name('product.delete')->middleware('CheckPermission:product.delete');
    Route::get('product/restore/{id}', 'Admin\ProductController@restore')->middleware('CheckPermission:product.delete');
    Route::get('product/forcedelete/{product}', 'Admin\ProductController@forceDelete')->middleware('CheckPermission:product.delete');
    Route::post('product/action', 'Admin\ProductController@action')->name('product.action')->middleware('CheckPermission:product.delete');
    Route::get('product/cat', 'Admin\ProductController@category')->name('product.cat')->middleware('CheckPermission:product.add');
    Route::post('product/cat/add', 'Admin\ProductController@category_add')->name('product.cat.add')->middleware('CheckPermission:product.add');
    Route::post('product/cat/edit/{cat}', 'Admin\ProductController@cat_edit')->name('product.cat.edit')->middleware('CheckPermission:product.update');
    Route::post('product/cat/update/{cat}', 'Admin\ProductController@cat_update')->name('product.cat.update')->middleware('CheckPermission:product.update');
    Route::get('product/cat/delete/{cat}', 'Admin\ProductController@cat_delete')->name('product.cat.delete')->middleware('CheckPermission:product.delete');
    Route::get('product/color', 'Admin\ProductController@color')->name('product.color')->middleware('CheckPermission:product.add');
    Route::get('product/config', 'Admin\ProductController@config')->name('product.config')->middleware('CheckPermission:product.add');
    Route::post('product/config/edit/{config}', 'Admin\ProductController@config_edit')->name('product.config.edit')->middleware('CheckPermission:product.update');
    Route::post('product/config/update/{config}', 'Admin\ProductController@config_update')->name('product.config.update')->middleware('CheckPermission:product.update');
    Route::post('product/config/add', 'Admin\ProductController@config_add')->name('product.config.add')->middleware('CheckPermission:product.add');
    Route::get('product/config/delete/{config}', 'Admin\ProductController@config_delete')->name('product.config.delete')->middleware('CheckPermission:product.delete');
    Route::post('product/col/add', 'Admin\ProductController@color_add')->name('product.color.add')->middleware('CheckPermission:product.add');
    Route::post('product/col/edit/{color}', 'Admin\ProductController@edit')->name('product.color.edit')->middleware('CheckPermission:product.update');
    Route::post('product/col/update/{color}', 'Admin\ProductController@color_update')->name('product.color.update')->middleware('CheckPermission:product.update');
    Route::get('product/col/delete/{color}', 'Admin\ProductController@color_delete')->name('product.color.delete')->middleware('CheckPermission:product.delete');

    Route::get('slider/list', 'Admin\SliderController@index')->name('admin.slider.list')->middleware('CheckPermission:slider.view');
    Route::get('slider/add', 'Admin\SliderController@add')->name('admin.slider.add')->middleware('CheckPermission:slider.add');
    Route::post('slider/handle_add', 'Admin\SliderController@handle_add')->name('admin.slider.handle_add')->middleware('CheckPermission:slider.add');
    Route::post('slider/edit/{slider}', 'Admin\SliderController@edit')->name('admin.slider.edit')->middleware('CheckPermission:slider.update');
    Route::post('slider/update/{slider}', 'Admin\SliderController@update')->name('admin.slider.update')->middleware('CheckPermission:slider.update');
    Route::get('slider/delete/{slider}', 'Admin\SliderController@delete')->name('admin.slider.delete')->middleware('CheckPermission:slider.delete');
    Route::get('slider/forcedelete/{slider}', 'Admin\SliderController@forcedelete')->name('admin.slider.forcedelete')->middleware('CheckPermission:slider.delete');
    Route::post('slider/action', 'Admin\SliderController@action')->name('admin.slider.action')->middleware('CheckPermission:slider.delete');

    Route::get('banner/list', 'Admin\BannerController@index')->name('admin.banner.list')->middleware('CheckPermission:banner.view');
    Route::get('banner/add', 'Admin\BannerController@add')->name('admin.banner.add')->middleware('CheckPermission:banner.add');
    Route::post('banner/handle_add', 'Admin\BannerController@handle_add')->name('admin.banner.handle_add')->middleware('CheckPermission:banner.add');
    Route::post('banner/edit/{banner}', 'Admin\BannerController@edit')->name('admin.banner.edit')->middleware('CheckPermission:banner.update');
    Route::post('banner/update/{banner}', 'Admin\BannerController@update')->name('admin.banner.update')->middleware('CheckPermission:banner.update');
    Route::get('banner/delete/{banner}', 'Admin\BannerController@delete')->name('admin.banner.delete')->middleware('CheckPermission:banner.delete');
    Route::post('banner/action', 'Admin\BannerController@action')->name('admin.banner.action')->middleware('CheckPermission:banner.delete');

    Route::get('page/show', 'Admin\PageController@index')->name('admin.page.show')->middleware('CheckPermission:page.view');
    
    // Promotions (middleware added)
    Route::get('promotion/list', 'Admin\PromotionController@index')->name('admin.promotion.index')->middleware('CheckPermission:promotion.view');
    Route::get('promotion/create', 'Admin\PromotionController@create')->name('admin.promotion.create')->middleware('CheckPermission:promotion.add');
    Route::post('promotion/store', 'Admin\PromotionController@store')->name('admin.promotion.store')->middleware('CheckPermission:promotion.add');
    Route::get('promotion/edit/{promotion}', 'Admin\PromotionController@edit')->name('admin.promotion.edit')->middleware('CheckPermission:promotion.update');
    Route::post('promotion/update/{promotion}', 'Admin\PromotionController@update')->name('admin.promotion.update')->middleware('CheckPermission:promotion.update');
    Route::get('promotion/delete/{promotion}', 'Admin\PromotionController@delete')->name('admin.promotion.delete')->middleware('CheckPermission:promotion.delete');
    Route::get('page/add', 'Admin\PageController@add')->name('admin.page.add')->middleware('CheckPermission:page.add');
    Route::post('page/handle_add', 'Admin\PageController@handle_add')->name('admin.page.handle_add')->middleware('CheckPermission:page.add');
    Route::get('page/edit/{page}', 'Admin\PageController@edit')->name('admin.page.edit')->middleware('CheckPermission:page.update');
    Route::post('page/update/{page}', 'Admin\PageController@update')->name('admin.page.update')->middleware('CheckPermission:page.update');
    Route::get('page/delete/{page}', 'Admin\PageController@delete')->name('admin.page.delete')->middleware('CheckPermission:page.delete');

    Route::get('chatbox/list', 'Admin\ChatboxController@index')->name('admin.chatbox.list')->middleware('CheckPermission:chatbox.view');
    Route::post('chatbox/add', 'Admin\ChatboxController@add')->name('admin.chatbox.add')->middleware('CheckPermission:chatbox.add');
    Route::get('chatbox/delete/{knowledge}', 'Admin\ChatboxController@delete')->name('admin.chatbox.delete')->middleware('CheckPermission:chatbox.delete');
    // Route::post('chatbox/detail/{knowledge}', 'Admin\ChatboxController@detail')->name('admin.chatbox.detail');
    Route::post('chatbox/detail/{knowledge}', 'Admin\ChatboxController@detail')->name('admin.chatbox.detail')->middleware('CheckPermission:chatbox.view');
    Route::post('chatbox/update/{knowledge}', 'Admin\ChatboxController@update')->name('admin.chatbox.update')->middleware('CheckPermission:chatbox.update');
    Route::get('chatbox/conversation', 'Admin\ChatboxController@conversation')->name('admin.chatbox.conversation')->middleware('CheckPermission:chatbox.view');
    Route::get('chatbox/session/{id}', 'Admin\ChatboxController@getSessionMessages')->name('admin.chatbox.SessionMessages')->middleware('CheckPermission:chatbox.view');
    Route::get('chatbox/deleteSession/{id}', 'Admin\ChatboxController@deleteSession')->name('admin.chatbox.deleteSession')->middleware('CheckPermission:chatbox.delete');
    Route::get('chatbox/export/{session}', 'Admin\ChatboxController@export')->name('admin.chatbox.export')->middleware('CheckPermission:chatbox.view');

    Route::get('feedback/list', 'Admin\FeedbackController@list')->name('admin.feedback.list')->middleware('CheckPermission:feedback.view');
    Route::post('feedback/detail/{id}', 'Admin\FeedbackController@show')->name('admin.feedback.detail')->middleware('CheckPermission:feedback.view');
    Route::post('feedback/action', 'Admin\FeedbackController@action')->name('admin.feedback.action')->middleware('CheckPermission:feedback.update');
    Route::get('feedback/delete/{id}', 'Admin\FeedbackController@delete')->name('admin.feedback.delete')->middleware('CheckPermission:feedback.delete');
    Route::get('feedback/forcedelete/{id}', 'Admin\FeedbackController@forceDelete')->name('admin.feedback.forcedelete')->middleware('CheckPermission:feedback.delete');
    Route::get('feedback/restore/{id}', 'Admin\FeedbackController@restore')->name('admin.feedback.restore')->middleware('CheckPermission:feedback.update');
    Route::get('feedback/export', 'Admin\FeedbackController@export')->name('admin.feedback.export')->middleware('CheckPermission:feedback.view');

    Route::get('customer/list', 'Admin\CustomerController@list')->name('admin.customer.list')->middleware('CheckPermission:customer.view');
    Route::post('customer/action', 'Admin\CustomerController@action')->name('admin.customer.action')->middleware('CheckPermission:customer.update');
    Route::get('customer/delete/{id}', 'Admin\CustomerController@delete')->name('admin.customer.delete')->middleware('CheckPermission:customer.delete');
    Route::get('customer/forcedelete/{id}', 'Admin\CustomerController@forceDelete')->name('admin.customer.forcedelete')->middleware('CheckPermission:customer.delete');
    Route::get('customer/restore/{id}', 'Admin\CustomerController@restore')->name('admin.customer.restore')->middleware('CheckPermission:customer.update');
    Route::get('customer/edit/{id}', 'Admin\CustomerController@edit')->name('admin.customer.edit')->middleware('CheckPermission:customer.update');
    Route::post('customer/update/{id}', 'Admin\CustomerController@update')->name('admin.customer.update')->middleware('CheckPermission:customer.update');

    // Quản lý nhóm khách hàng
    Route::get('customer-group/list', 'Admin\CustomerGroupController@list')->name('admin.customer_group.list')->middleware('CheckPermission:customer_group.view');
    Route::post('customer-group/add', 'Admin\CustomerGroupController@add')->name('admin.customer_group.add')->middleware('CheckPermission:customer_group.add');
    Route::get('customer-group/delete/{id}', 'Admin\CustomerGroupController@delete')->name('admin.customer_group.delete')->middleware('CheckPermission:customer_group.delete');
    Route::get('customer-group/edit/{id}', 'Admin\CustomerGroupController@edit')->name('admin.customer_group.edit')->middleware('CheckPermission:customer_group.update');
    Route::post('customer-group/update/{id}', 'Admin\CustomerGroupController@update')->name('admin.customer_group.update')->middleware('CheckPermission:customer_group.update');

    Route::get('subscriber/list', 'Admin\SubscriberController@list')->name('admin.subscriber.list')->middleware('CheckPermission:subscriber.view');
    Route::get('subscriber/detail/{id}', 'Admin\SubscriberController@detail')->name('admin.subscriber.detail')->middleware('CheckPermission:subscriber.view');
    Route::post('subscriber/status/{id}', 'Admin\SubscriberController@updateStatus')->name('admin.subscriber.status')->middleware('CheckPermission:subscriber.update');
    Route::get('subscriber/delete/{id}', 'Admin\SubscriberController@delete')->name('admin.subscriber.delete')->middleware('CheckPermission:subscriber.delete');

    Route::get('order/show', 'Admin\OrderController@index')->name('admin.order.show')->middleware('CheckPermission:order.view');
    Route::get('order/report', 'Admin\OrderController@report')->name('admin.order.report')->middleware('CheckPermission:order.view');
    Route::post('order/detail/{order}', 'Admin\OrderController@detail')->name('admin.order.detail')->middleware('CheckPermission:order.view');
    Route::post('order/update/{order}', 'Admin\OrderController@update')->name('admin.order.update')->middleware('CheckPermission:order.update');
    Route::get('order/delete/{order}', 'Admin\OrderController@delete')->name('admin.order.delete')->middleware('CheckPermission:order.delete');
    Route::get('order/changePoints', 'Admin\OrderController@changePoints')->name('admin.order.changePoints');
    Route::get('order/changePoints/delete/{changePoint}', 'Admin\OrderController@changePoints_delete')->name('admin.order.changePoints.delete');
    Route::get('order/changePoints/check/{changePoint}', 'Admin\OrderController@changePoints_checkSuccess')->name('admin.order.changePoints.check');
    Route::get('order/changeGifts', 'Admin\OrderController@changeGifts')->name('admin.order.changeGifts');
    Route::get('order/changeGifts/delete/{userGift}', 'Admin\OrderController@changeGifts_delete')->name('admin.order.changeGifts.delete');
    Route::get('order/changeGifts/checkSuccess/{userGift}', 'Admin\OrderController@changeGifts_checkSuccess')->name('admin.order.changeGifts.check');
});
Route::post('chatbox/ask', 'Admin\ChatboxController@ask')->name('admin.chatbox.ask');
Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//===================CLIENT==================
Route::get('/', 'Client\HomeController@index')->name('home');
Route::get('trang-chu', 'Client\HomeController@index')->name('home');

Route::get('danh-muc/{slug}', 'Client\ProductController@product_cat')->name('client.product.cat');

Route::prefix('bai-viet')->group(function () {
    Route::get('', 'Client\BlogController@index')->name('client.blog.show');
    Route::get('{slug}', 'Client\BlogController@blog_detail')->name('client.blog.detail');
});

Route::get('dang-ki', 'Client\UserController@register')->name('client.register');
Route::post('dang-ki/handle', 'Client\UserController@registerHandle')->name('client.register.handle');
Route::get('dang-nhap', 'Client\UserController@login')->name('client.login');
Route::post('dang-nhap/handle', 'Client\UserController@loginHandle')->name('client.login.handle');
Route::get('client/logout', 'Client\UserController@logout')->name('client.logout');

Route::prefix('san-pham')->group(function () {
    Route::get('', 'Client\ProductController@list_product')->name('client.product.show');
    Route::get('{slug}', 'Client\ProductController@product_detail')->name('client.product.detail');
    Route::post('add/option', 'Client\ProductController@product_option')->name('client.product.option');
});
Route::post('catProduct/sort', 'Client\ProductController@sort')->name('client.product.sort');
Route::post('search/suggest/', 'Client\ProductController@suggest')->name('client.product.suggest');

Route::get('gio-hang', 'Client\CartController@index')->name('client.cart.show');
Route::get('gio-hang/{slug}', 'Client\CartController@add')->name('client.cart.add');
Route::post('gio-hang-ajax/{id}', 'Client\CartController@add_ajax')->name('client.cart.ajax');
Route::post('cart/update', 'Client\CartController@update_ajax')->name('client.cart.update');
Route::get('xoa-san-pham/{rowId}', 'Client\CartController@delete')->name('client.cart.delete');
Route::get('xoa-gio-hang', 'Client\CartController@destroy')->name('client.cart.destroy');
Route::post('cart/checkoutHandle', 'Client\CartController@checkoutHandle')->name('client.cart.checkoutHandle');
Route::get('thanh-toan', 'Client\CartController@checkout')->name('client.cart.checkout');
Route::get('mua-ngay/{slug}', 'Client\CartController@handleBuyNow')->name('client.buynow');
Route::get('dat-hang-thanh-cong/{codeBill}', 'Client\CartController@success')->name('client.cart.success');
Route::get('vnpay-return', 'Client\CartController@vnpayReturn')->name('client.cart.vnpayReturn');
Route::get('don-hang-cua-toi/', 'Client\CartController@myOrder')->name('client.cart.myOrder');
Route::get('chi-tiet-don-hang/{id}', 'Client\CartController@detailOrder')->name('client.cart.detailOrder');
Route::post('don-hang-cua-toi/huy/{id}', 'Client\CartController@cancelOrderByUser')->name('client.cart.cancelOrder');

Route::get('minigame/doi-diem-lay-cay', 'Client\ChangePointsController@index')->name('client.changePoints');
Route::post('minigame/handle', 'Client\ChangePointsController@handle')->name('client.changePoints.handle');
Route::post('minigame/changeGift/{gift}', 'Client\ChangePointsController@changeGift')->name('client.changePoints.changeGift');
Route::get('page/cau-hoi-thuong-gap', 'Client\FaqController@index')->name('client.page.faq');
Route::get('page/phan-hoi-khach-hang', 'Client\FeedbackController@index')->name('client.feedback');
Route::post('page/feedback/add', 'Client\FeedbackController@add')->name('client.feedback.add');


// Support request routes (must be BEFORE catch-all route)
Route::get('ho-tro', 'Client\PromotionController@index')->name('client.support.index');
Route::post('ho-tro/submit', 'Client\PromotionController@subscribe')->name('client.support.submit');

// Legacy aliases for backward compatibility
Route::get('dang-ky-khuyen-mai', 'Client\PromotionController@index')->name('client.promotion.index');
Route::post('dang-ky-khuyen-mai/submit', 'Client\PromotionController@subscribe')->name('client.promotion.subscribe');

// Customer profile routes
Route::get('tai-khoan/profile', 'Client\UserController@profile')->name('client.profile');
Route::post('tai-khoan/update', 'Client\UserController@updateProfile')->name('client.profile.update');
Route::post('tai-khoan/change-password', 'Client\UserController@updatePassword')->name('client.profile.password');

// Forgot password routes
Route::get('quen-mat-khau', 'Client\ForgotPasswordController@showForm')->name('client.forgot-password');
Route::post('quen-mat-khau/submit', 'Client\ForgotPasswordController@submit')->name('client.forgot-password.submit');

Route::get('admin/order/export',  'Admin\OrderController@export')->name('admin.order.export');

// Catch-all route for pages (MUST BE LAST)
Route::get('{slug}', 'Client\PageController@index')->name('client.page.show');

Route::get('{slug}', 'Client\PageController@index')->name('client.page.show');
