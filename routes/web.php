<?php

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
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================
// 1️⃣ PUBLIC ROUTES
// ==========================
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('product.show');
Route::get('categories', [HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);
Route::get('cart', [HomepageController::class, 'cart'])->name('cart.index');

// ==========================
// 2️⃣ CUSTOMER AUTH ROUTES
// ==========================
Route::prefix('customer')->controller(CustomerAuthController::class)->group(function () {
    Route::middleware('check_customer_login')->group(function () {
        Route::get('login', 'login')->name('customer.login');
        Route::post('login', 'store_login')->name('customer.store_login');
        Route::get('register', 'register')->name('customer.register');
        Route::post('register', 'store_register')->name('customer.store_register');
    });

    Route::post('logout', 'logout')->name('customer.logout');
});

// ==========================
// 3️⃣ CUSTOMER PROTECTED ROUTES
// ==========================
Route::middleware(['is_customer_login'])->group(function () {

    // ✅ Checkout Routes
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // ✅ My Orders Routes
    Route::prefix('my-orders')->name('orders.')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');             // orders.index
        Route::get('/{id}', 'show')->name('show');           // orders.show
        Route::get('/{id}/invoice', 'invoice')->name('invoice'); // orders.invoice
        Route::post('/{id}/cancel', 'cancel')->name('cancel');   // orders.cancel
    });

    // ✅ Cart Routes
    Route::controller(CartController::class)->group(function () {
        Route::post('cart/add', 'add')->name('cart.add');
        Route::delete('cart/remove/{id}', 'remove')->name('cart.remove');
        Route::patch('cart/update/{id}', 'update')->name('cart.update');
    });
});

// ==========================
// 4️⃣ ADMIN DASHBOARD ROUTES
// ==========================
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('themes', ThemeController::class);

    Route::post('products/sync/{id}', [ProductController::class, 'sync'])->name('products.sync');
    Route::post('category/sync/{id}', [ProductCategoryController::class, 'sync'])->name('category.sync');
});

// ==========================
// 5️⃣ SETTINGS (Livewire Volt)
// ==========================
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// ==========================
// 6️⃣ FALLBACK ROUTE
// ==========================
Route::fallback(function () {
    return redirect()->route('home')->with('error', 'Halaman tidak ditemukan.');
});

require __DIR__.'/auth.php';
