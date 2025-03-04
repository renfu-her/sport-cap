<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\LearningRecordController;

Route::get('/', function () {
    return view('welcome');
});

// 添加登入後重定向到 abouts 頁面的路由
Route::get('/backend', function () {
    return redirect('/backend/abouts');
});

// 學習記錄路由
// Route::prefix('backend')->group(function () {
//     // 學習記錄資源路由
//     Route::resource('learning-records', LearningRecordController::class);

//     // 會員學習記錄路由
//     Route::get('members/{member}/learning-records', [LearningRecordController::class, 'memberRecords'])
//         ->name('members.learning-records');
// });
