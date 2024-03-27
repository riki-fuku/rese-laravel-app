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

// 店舗詳細取得
Route::get('/shops/{id}', 'App\Http\Controllers\Api\ShopController@show');

// ジャンル一覧取得
Route::get('/genres', 'App\Http\Controllers\Api\GenreController@index');

// エリア一覧取得
Route::get('/areas', 'App\Http\Controllers\Api\AreaController@index');

// お気に入り一覧取得
Route::get('/favorites/{userId}', 'App\Http\Controllers\Api\FavoriteController@index');

// お気に入り登録
Route::post('/favorite', 'App\Http\Controllers\Api\FavoriteController@store');

// 予約一覧取得
Route::get('/reservations/{userId}', 'App\Http\Controllers\Api\ReservationController@index');

// 予約登録
Route::post('/reservation', 'App\Http\Controllers\Api\ReservationController@store');

// 予約詳細取得
Route::get('/reservation/{id}', 'App\Http\Controllers\Api\ReservationController@show');

// 予約更新
Route::put('/reservation', 'App\Http\Controllers\Api\ReservationController@update');

// 予約キャンセル
Route::delete('/reservation/cancel/{id}', 'App\Http\Controllers\Api\ReservationController@cancel');

// 店舗評価送信
Route::post('/rating', 'App\Http\Controllers\Api\RatingController@store');

// 決済実行
Route::post('/payment', 'App\Http\Controllers\Api\PaymentController@charge');
