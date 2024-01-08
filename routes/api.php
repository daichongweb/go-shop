<?php

use App\Http\Controllers\ApplyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Response\Rsp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return Rsp::success($request->user());
    });


    // 订单
    Route::prefix('order')->group(function () {
        Route::get('/index', [OrderController::class, 'index']);
        Route::post('/create', [OrderController::class, 'create']);
    });

    // 商品
    Route::prefix('product')->group(function () {
        Route::get('/index', [ProductController::class, 'index']);
    });

    // Vip申请
    Route::prefix('apply')->group(function () {
        Route::post('/create', [ApplyController::class, 'create']);
    });

    // 用户
    Route::prefix('member')->group(function () {
        Route::get('/getParent', [MemberController::class, 'getParent']);
        Route::post('/bind', [MemberController::class, 'bind']);
    });
});

Route::post('/login', [LoginController::class, 'index']);
Route::post('/reg', [LoginController::class, 'reg']);
Route::post('/smsLogin', [LoginController::class, 'smsLogin']);

Route::middleware('throttle:1,1')->group(function () {
    Route::post('/genSmsCode', [LoginController::class, 'genSmsCode']);
});
