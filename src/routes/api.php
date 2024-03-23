<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 店舗一覧取得
Route::get('/shops', 'App\Http\Controllers\Api\ShopController@index');

// ジャンル一覧取得
Route::get('/genres', 'App\Http\Controllers\Api\GenreController@index');

// エリア一覧取得
Route::get('/areas', 'App\Http\Controllers\Api\AreaController@index');

// お気に入り登録
Route::post('/favorite', 'App\Http\Controllers\Api\FavoriteController@store');
