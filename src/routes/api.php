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

/**
 * 店舗
 */
// 店舗一覧取得
Route::get('/shops', 'App\Http\Controllers\Api\ShopController@index');

// 店舗詳細取得
Route::get('/shops/{id}', 'App\Http\Controllers\Api\ShopController@show');

// 店舗登録
Route::post('/shop/store', 'App\Http\Controllers\Api\ShopController@store')->name('shop.store');

// 店舗更新
Route::post('/shop/update', 'App\Http\Controllers\Api\ShopController@update')->name('shop.update');

/**
 * ジャンル
 */
// ジャンル一覧取得
Route::get('/genres', 'App\Http\Controllers\Api\GenreController@index');

/**
 * エリア
 */
// エリア一覧取得
Route::get('/areas', 'App\Http\Controllers\Api\AreaController@index');

/**
 * お気に入り
 */
// お気に入り一覧取得
Route::get('/favorites/{userId}', 'App\Http\Controllers\Api\FavoriteController@index');

// お気に入り登録
Route::post('/favorite', 'App\Http\Controllers\Api\FavoriteController@store');

/**
 * 予約
 */
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

// 予約ステータスを来店済に更新
Route::post('/reservation/visited', 'App\Http\Controllers\Api\ReservationController@visited')->name('reservation.visited');

/**
 * 店舗評価
 */
// 店舗評価送信
Route::post('/rating', 'App\Http\Controllers\Api\RatingController@store');

/**
 * 決済
 */
// 決済実行
Route::post('/payment', 'App\Http\Controllers\Api\PaymentController@charge');

/**
 * 店舗代表者
 */
// 店舗代表者一覧取得
Route::get('/shop_users', 'App\Http\Controllers\Api\ShopUserController@index')->name('shop_user.index');

// 店舗代表者に紐づく店舗取得
Route::get('/shop_user/show/shop', 'App\Http\Controllers\Api\ShopUserController@showShop')->name('shop_user.show_shop');

// 店舗代表者に紐づく予約一覧取得

// 店舗代表者作成
Route::get('/shop_user/show/reservations', 'App\Http\Controllers\Api\ShopUserController@showReservations')->name('shop_user.show_reservations');

// 店舗代表者更新
Route::get('/shop_user/update', 'App\Http\Controllers\Api\ShopUserController@update')->name('shop_user.update');

// 店舗代表者有効/無効切り替え
Route::post('/shop_user/change_invalid', 'App\Http\Controllers\Api\ShopUserController@changeInvalid')->name('shop_user.change_invalid');

/**
 * メール関連
 */
// Emailテンプレート取得
Route::get('/email_templates/{userType}', 'App\Http\Controllers\Api\EmailTemplateController@index')->name('email_template.index');

// Email送信(管理者用)
Route::post('/admin/send_email', 'App\Http\Controllers\Api\SendEmailController@adminStore')->name('send_email.admin_store');

// Email送信(店舗代表者用)
Route::post('/agent/send_email', 'App\Http\Controllers\Api\SendEmailController@agentStore')->name('send_email.agent_store');
