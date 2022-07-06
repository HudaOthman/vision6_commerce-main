<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SiteController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::prefix(LaravelLocalization::setLocale())->group(function() {
// Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'check_user'])->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::get('categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::get('categories/forcedelete/{id}', [CategoryController::class, 'forcedelete'])->name('categories.forcedelete');
        Route::resource('categories', CategoryController::class);

        Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
        Route::get('products/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');
        Route::get('products/forcedelete/{id}', [ProductController::class, 'forcedelete'])->name('products.forcedelete');
        Route::resource('products', ProductController::class);

        Route::get('coupons/trash', [CouponController::class, 'trash'])->name('coupons.trash');
        Route::get('coupons/restore/{id}', [CouponController::class, 'restore'])->name('coupons.restore');
        Route::get('coupons/forcedelete/{id}', [CouponController::class, 'forcedelete'])->name('coupons.forcedelete');
        Route::resource('coupons', CouponController::class);

        Route::get('order/{id}', [AdminController::class, 'order'])->name('order');
    });

    Route::view('not-allowed', 'not-allowed')->name('not-allowed');

    Auth::routes(['verify' => true]);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    // Main Website Routes
    Route::get('/', [SiteController::class, 'index'])->name('site.index');
    Route::get('/contact', [SiteController::class, 'contact'])->name('site.contact');
    Route::get('category/{slug}', [SiteController::class, 'category'])->name('site.category');
    Route::get('product/{slug}', [SiteController::class, 'product'])->name('site.product');

    Route::controller(CartController::class)->name('site.')->middleware('auth')->group(function() {
        Route::get('cart', 'cart')->name('cart');
        Route::post('add-cart', 'add_cart')->name('add_cart');
        Route::get('remove-cart/{id}', 'remove_cart')->name('remove_cart');
        Route::post('update-cart', 'update_cart')->name('update_cart');
        Route::get('checkout', 'checkout')->name('checkout');
        Route::get('thanks', 'thanks')->name('thanks');
    });

});

Route::get('send-notification', [SiteController::class, 'send_notification'])->name('send_notification');
Route::get('notification', [SiteController::class, 'notification'])->name('notification');
Route::get('notification/{id}', [SiteController::class, 'read_notification'])->name('read_notification');

Route::get('posts-api', [SiteController::class, 'posts_api']);
