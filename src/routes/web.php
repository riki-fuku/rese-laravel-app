<?php

use Illuminate\Support\Facades\Route;

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
Route::post('/login', 'App\Http\Controllers\Api\AuthUserController@login');
Route::post('/logout', 'App\Http\Controllers\Api\AuthUserController@logout')->middleware('auth:user');

// 店舗代表者ログイン・ログアウト
Route::post('/agent/login', 'App\Http\Controllers\Api\AuthAgentController@login');
Route::post('/agent/logout', 'App\Http\Controllers\Api\AuthAgentController@logout')->middleware('auth:agent');

// 管理者ログイン・ログアウト
Route::post('/admin/login', 'App\Http\Controllers\Api\AuthAdminController@login');
Route::post('/admin/logout', 'App\Http\Controllers\Api\AuthAdminController@logout')->middleware('auth:admin');
