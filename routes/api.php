<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\TeachingMethodController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\LearningRecordController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\TrainingCampController;
use App\Http\Controllers\Api\TournamentController;
use App\Http\Controllers\Api\ButlerServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 會員相關
Route::post('/register', [MemberController::class, 'register']);
Route::post('/login', [MemberController::class, 'login']);
Route::post('/logout', [MemberController::class, 'logout']);
Route::get('/profile', [MemberController::class, 'profile']);
Route::put('/profile', [MemberController::class, 'updateProfile']);
Route::put('/password', [MemberController::class, 'updatePassword']);

// 教學方式相關
Route::get('/teaching-methods', [TeachingMethodController::class, 'index']);
Route::get('/teaching-methods/popular', [TeachingMethodController::class, 'popular']);
Route::get('/teaching-methods/{id}', [TeachingMethodController::class, 'show']);

// 訂單相關
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel']);

// 學習記錄相關
Route::get('/learning-records', [LearningRecordController::class, 'index']);
Route::get('/learning-records/{id}', [LearningRecordController::class, 'show']);

// 教練相關
Route::get('/teachers', [AboutController::class, 'index']);
Route::get('/teachers/{id}', [AboutController::class, 'show']);

// 訓練營相關
Route::get('/training-camps', [TrainingCampController::class, 'index']);
Route::get('/training-camps/upcoming', [TrainingCampController::class, 'upcoming']);
Route::get('/training-camps/{id}', [TrainingCampController::class, 'show']);

// 比賽相關
Route::get('/tournaments', [TournamentController::class, 'index']);
Route::get('/tournaments/upcoming', [TournamentController::class, 'upcoming']);
Route::get('/tournaments/{id}', [TournamentController::class, 'show']);

// 管家服務相關
Route::get('/butler-services', [ButlerServiceController::class, 'index']);
Route::get('/butler-services/{id}', [ButlerServiceController::class, 'show']); 