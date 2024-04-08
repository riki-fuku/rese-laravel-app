<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ShopUserController;
use App\Http\Controllers\Api\EmailTemplateController;
use App\Http\Controllers\Api\SendEmailController;

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

// ユーザー登録
Route::post('/register/user', [AuthUserController::class, 'register']);

/**
 * 店舗
 */
// 店舗一覧取得
Route::get('/shops', [ShopController::class, 'index'])->middleware('auth:user');


// 店舗詳細取得
Route::get('/shops/{shopId}', [ShopController::class, 'show']);

// 店舗登録
Route::post('/shop/store', 'App\Http\Controllers\Api\ShopController@store')->middleware('auth:agent');

// 店舗更新
Route::post('/shop/update', 'App\Http\Controllers\Api\ShopController@update');

/**
 * ジャンル
 */
// ジャンル一覧取得
Route::get('/genres', [GenreController::class, 'index']);

/**
 * エリア
 */
// エリア一覧取得
Route::get('/areas', [AreaController::class, 'index']);

/**
 * お気に入り
 */
// お気に入り一覧取得
Route::get('/favorites/{userId}', [FavoriteController::class, 'index']);

// お気に入り登録
Route::post('/favorite', [FavoriteController::class, 'store']);

/**
 * 予約
 */
// 予約一覧取得
Route::get('/reservations/{userId}', [ReservationController::class, 'index']);

// 予約登録
Route::post('/reservation', [ReservationController::class, 'store']);

// 予約詳細取得
Route::get('/reservation/{reservationId}', [ReservationController::class, 'show']);

// 予約更新
Route::put('/reservation', [ReservationController::class, 'update']);

// 予約キャンセル
Route::delete('/reservation/cancel/{id}', [ReservationController::class, 'cancel']);

// 予約ステータスを来店済に更新
Route::post('/reservation/visited', [ReservationController::class, 'visited']);

/**
 * 店舗評価
 */
// 店舗評価送信
Route::post('/rating', [RatingController::class, 'store']);

/**
 * 決済
 */
// 決済実行
Route::post('/payment', [PaymentController::class, 'charge']);

/**
 * 店舗代表者
 */
// 店舗代表者一覧取得
Route::get('/shop_users', [ShopUserController::class, 'index']);

// 店舗代表者に紐づく店舗取得
Route::get('/shop_user/show/shop', [ShopUserController::class, 'showShop'])->middleware('auth:agent');

// 店舗代表者に紐づく予約一覧取得
Route::get('/shop_user/show/reservations', [ShopUserController::class, 'showReservations'])->middleware('auth:agent');

// 店舗代表者作成
Route::post('/shop_user/store', [ShopUserController::class, 'store']);

// 店舗代表者更新
Route::put('/shop_user/update', [ShopUserController::class, 'update']);

// 店舗代表者有効/無効切り替え
Route::post('/shop_user/change_invalid', [ShopUserController::class, 'changeInvalid']);

/**
 * メール関連
 */
// Emailテンプレート取得
Route::get('/email_templates/{userType}', [EmailTemplateController::class, 'index']);

// Email送信(店舗代表者用)
Route::post('/agent/send_email', [SendEmailController::class, 'agentStore']);

// Email送信(管理者用)
Route::post('/admin/send_email', [SendEmailController::class, 'adminStore']);
