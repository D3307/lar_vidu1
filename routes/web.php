<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Customer\PageController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\CouponController as CustomerCouponController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;

// -------------------- Welcome Page --------------------
Route::get('/', function() {
    return view('welcomeweb');
})->name('welcomeweb');

// -------------------- Đăng ký --------------------
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// -------------------- Đăng nhập & Đăng xuất --------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -------------------- Đặt lại mật khẩu --------------------
Route::get('passwords/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('passwords/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('passwords/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('passwords/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// -------------------- Email Verification --------------------
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [VerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// -------------------- Customer routes (auth + verified) --------------------
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Tài khoản cá nhân
    Route::get('/account', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('accounts.update');

    // Sản phẩm
    Route::get('/products', [ProductController::class, 'index'])->name('customer.products');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('customer.product_detail');
    Route::post('/products/{id}/review', [\App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('customer.review');
    Route::get('/products/category/{category}', [ProductController::class, 'category'])->name('customer.products.category');
    Route::get('/search', [ProductController::class, 'search'])->name('customer.search');

    // Giỏ hàng
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/update/{key}', [CartController::class, 'update'])->name('cart.update');
        Route::get('/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::post('/remove-selected', [CartController::class, 'removeSelected'])->name('cart.removeSelected');
    });

    // Đặt hàng
    Route::get('/checkout', [\App\Http\Controllers\Customer\OrderController::class, 'showCheckoutForm'])
        ->name('checkout.form')
        ->middleware(['auth','verified']); // nếu bạn yêu cầu login
    Route::post('/checkout', [CustomerOrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [CustomerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cod-payment', [CustomerOrderController::class, 'codPayment'])->name('orders.codPayment');
    Route::post('/buy-now/{id}', [CustomerOrderController::class, 'buyNow'])->name('buy.now');
    Route::post('/coupon', [CouponController::class, 'coupon'])->name('customer.coupon');

    //Thanh toán
    Route::get('/payment/momo/{order}', [PaymentController::class, 'payWithMomo'])->name('payment.momo');
    Route::post('/payment/momo/callback', [PaymentController::class, 'momoCallback'])->name('payment.momo.callback');
    Route::get('/payment/momo/fake-callback/{orderId}', [PaymentController::class, 'fakeMomoCallback']);
    Route::get('/payment/momo/return', [PaymentController::class, 'momoReturn'])->name('payment.momo.return');
    Route::get('/success', function () {return view('customer.success');})->name('customer.success');

    //Đánh giá
    Route::get('/review/{order}', [CustomerReviewController::class, 'create'])->name('customer.review');
    Route::post('/review/{order}', [CustomerReviewController::class, 'store'])->name('customer.review.store');

    // Pages
    Route::get('/about', [PageController::class, 'about'])->name('customer.about');
    Route::get('/contact', [PageController::class, 'contact'])->name('customer.contact');

    // Lịch sử người dùng
    Route::get('/lich-su', [App\Http\Controllers\Customer\UserHistoryController::class, 'index'])->name('customer.histories.index')->middleware('auth');
});

// -------------------- Public pages --------------------
Route::get('/about', [PageController::class, 'about'])->name('customer.about');
Route::get('/contact', [PageController::class, 'contact'])->name('customer.contact');

// -------------------- Admin routes --------------------
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('inventories', InventoryController::class);
        Route::resource('users', UserController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::resource('reviews', AdminReviewController::class);
        Route::resource('coupons', AdminCouponController::class);
        
        //Route báo cáo - thống kê
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/summary', [ReportController::class, 'summary'])->name('reports.summary');
        Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
        Route::post('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');

        //Route quản lý đơn hàng
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.orders');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.orderdetail');
        Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('/orders/{id}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
    });

Route::get('/home', [HomeController::class, 'index'])->name('home');
