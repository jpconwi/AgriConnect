<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated routes (any role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cart & checkout (buyers, but any authenticated user may browse/buy)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/track', [DeliveryController::class, 'track'])->name('orders.track');
});

/*
|--------------------------------------------------------------------------
| Farmer & Supplier (sellers) routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:farmer,supplier'])->prefix('seller')->group(function () {
    Route::get('/manage/products', [ProductController::class, 'manage'])->name('products.manage');
    Route::get('/manage/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/manage/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/manage/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/manage/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/manage/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/manage/sales', [OrderController::class, 'sales'])->name('orders.sales');
    Route::patch('/manage/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/manage/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');
});

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::patch('/users/{user}/activate', [AdminUserController::class, 'activate'])->name('users.activate');

    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::patch('/products/{product}/approve', [AdminProductController::class, 'approve'])->name('products.approve');
    Route::patch('/products/{product}/reject', [AdminProductController::class, 'reject'])->name('products.reject');

    Route::get('/categories', [AdminProductController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminProductController::class, 'storeCategory'])->name('categories.store');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');

    Route::patch('/deliveries/{delivery}', [DeliveryController::class, 'update'])->name('deliveries.update');
});
