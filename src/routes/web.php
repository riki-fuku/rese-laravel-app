<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\AuthAgentController;
use App\Http\Controllers\Api\AuthAdminController;
use App\Http\Controllers\Auth\UserVerifyEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

// ユーザーログイン・ログアウト
Route::post('/login', [AuthUserController::class, 'login']);
Route::post('/logout', [AuthUserController::class, 'logout'])->middleware('auth:user');

// 店舗代表者ログイン・ログアウト
Route::post('/agent/login', [AuthAgentController::class, 'login']);
Route::post('/agent/logout', [AuthAgentController::class, 'logout'])->middleware('auth:agent');

// 管理者ログイン・ログアウト
Route::post('/admin/login', [AuthAdminController::class, 'login']);
Route::post('/admin/logout', [AuthAdminController::class, 'logout'])->middleware('auth:admin');

// ユーザーメール認証
Route::get('/auth/verify-email/{name}/{email}', [UserVerifyEmailController::class, 'verifyEmail']);
