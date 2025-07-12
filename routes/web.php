<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ApiController;

// ---------------- ROUTE UTAMA (Public) ----------------
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('product.show');
Route::get('categories', [HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);

Route::get('cart', [HomepageController::class, 'cart'])->name('cart.index');

// ---------------- ROUTE CUSTOMER ----------------
Route::group(['middleware' => ['is_customer_login']], function () {

    // ✅ Route checkout (GET + POST)
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // ✅ Cart routes
    Route::controller(CartController::class)->group(function () {
        Route::post('cart/add', 'add')->name('cart.add');
        Route::delete('cart/remove/{id}', 'remove')->name('cart.remove');
        Route::patch('cart/update/{id}', 'update')->name('cart.update');
    });

    // ✅ Order routes
    Route::controller(OrderController::class)->group(function () {
        Route::get('my-orders', 'index')->name('orders.index');
        Route::get('my-orders/{id}', 'show')->name('customer.order_details');
         Route::get('/my-orders/{id}/invoice', [OrderController::class, 'invoice'])->name('customer.order_invoice');
    Route::post('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])->name('customer.order_cancel');
    });
});

// ---------------- AUTH CUSTOMER ----------------
Route::group(['prefix'=>'customer'], function(){
    Route::controller(CustomerAuthController::class)->group(function(){
        Route::group(['middleware'=>'check_customer_login'], function(){
            Route::get('login','login')->name('customer.login');
            Route::post('login','store_login')->name('customer.store_login');
            Route::get('register','register')->name('customer.register');
            Route::post('register','store_register')->name('customer.store_register');
        });

        Route::post('logout','logout')->name('customer.logout');
    });
});

// ---------------- ROUTE ADMIN DASHBOARD ----------------
Route::group(['prefix'=>'dashboard','middleware'=>['auth','verified']], function(){
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('themes', ThemeController::class);
    Route::post('products/sync/{id}', [ProductController::class, 'sync'])->name('products.sync');
    Route::post('category/sync/{id}', [ProductCategoryController::class, 'sync'])->name('category.sync');
});

// ---------------- PENGATURAN USER (Volt) ----------------
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
