<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 添加登入後重定向到 abouts 頁面的路由
Route::get('/backend', function () {
    return redirect('/backend/abouts');
});
