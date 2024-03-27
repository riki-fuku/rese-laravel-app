<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * お気に入り一覧取得
     */
    public function index($userId)
    {
        // お気に入り一覧取得
        $favorites = Favorite::with(['shop' => function ($query) {
                $query->with('area', 'genre');
            }])
            ->where('user_id', $userId)
            ->get();

        // 成功レスポンス
        return response()->json($favorites);
    }


    /**
     * お気に入り登録(axios)
     * 登録済みの場合は削除、未登録の場合は登録
     */
    public function store(Request $request)
    {
        // リクエスト取得
        $shopId = $request->shop_id;
        $userId = $request->user_id;

        // お気に入り登録済みか確認
        $favoriteFlg = Favorite::where('shop_id', $shopId)->where('user_id', $userId)->exists();

        if (!$favoriteFlg) {
            // 登録処理
            Favorite::create([
                'shop_id' => $shopId,
                'user_id' => $userId,
            ]);
        } else {
            // 削除処理
            Favorite::where('shop_id', $shopId)->where('user_id', $userId)->delete();
        }

        // 成功レスポンス
        return response()->json(['success' => 'お気に入り登録しました']);
    }
}
