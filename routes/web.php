<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\LearningRecordController;

Route::get('/', function () {
    return view('home');
});

// 添加登入後重定向到 abouts 頁面的路由
Route::get('/backend', function () {
    return redirect('/backend/abouts');
});

// 商店相關路由
Route::get('/shop', function () {
    return view('shop.index');
});

Route::get('/shop/categories', function () {
    return view('shop.categories');
});

Route::get('/shop/categories/{category}', function ($category) {
    return view('shop.category', ['category' => $category]);
});

Route::get('/shop/categories/{category}/{subcategory}', function ($category, $subcategory) {
    return view('shop.subcategory', ['category' => $category, 'subcategory' => $subcategory]);
});

Route::get('/shop/product/{id}', function ($id) {
    return view('shop.product', ['id' => $id]);
});

Route::get('/cart', function () {
    return view('shop.cart');
});

Route::get('/checkout', function () {
    return view('shop.checkout');
});

// 其他頁面路由
Route::get('/about', function () {
    return view('about');
});

Route::get('/teaching-methods', function () {
    return view('teaching-methods.index');
});

Route::get('/training-camps', function () {
    return view('training-camps.index');
});

Route::get('/tournaments', function () {
    return view('tournaments.index');
});

Route::get('/butler-services', function () {
    return view('butler-services.index');
});

Route::get('/contact', function () {
    return view('contact');
});

// 會員相關路由
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// 電子報訂閱
Route::post('/newsletter', function () {
    // 處理電子報訂閱邏輯
    return redirect()->back()->with('success', '感謝您的訂閱！');
});

