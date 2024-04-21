<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopUser;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * 店舗一覧取得(ログイン中のユーザーのお気に入りも取得)
     */
    public function index()
    {
        $userId = auth()->id();
        $shops = Shop::with(['area', 'genre', 'ratings', 'favorite' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get();
        return response()->json($shops);
    }

    /**
     * 店舗一覧取得(口コミ情報も取得)
     */
    public function indexRatings()
    {
        $shops = Shop::with('area', 'genre', 'ratings')->get();
        return response()->json($shops);
    }

    /**
     * 店舗詳細取得
     */
    public function show($shopId)
    {
        $shop = Shop::with('genre', 'area', 'favorite')->find($shopId);
        return response()->json($shop);
    }

    /**
     * 店舗登録
     */
    public function store(Request $request)
    {
        $userId = auth()->id();

        $shop = new Shop();
        $shopId = $shop->id;
        $shop->name = $request->name;
        $shop->genre_id = $request->genre_id;
        $shop->area_id = $request->area_id;
        $shop->description = $request->description;
        $shop->opening_time = $request->opening_time;
        $shop->closing_time = $request->closing_time;

        // 画像をS3にアップロードする
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 's3');
            $imageUrl = \Storage::disk('s3')->url($imagePath);
            $shop->image_url = $imageUrl;
        }

        $shop->save();

        // 作成したshopのidを取得する
        $shopId = $shop->id;

        // 店舗代表者に店舗IDを紐づける
        $shopUser = ShopUser::find($userId);
        $shopUser->shop_id = $shopId;
        $shopUser->save();

        return response()->json($shop);
    }

    /**
     * 店舗更新
     */
    public function update(Request $request)
    {
        \Log::info($request);

        $shop = Shop::find($request->id);

        if (!$shop) {
            return response()->json(['message' => 'Shop not found'], 404);
        }

        $shop->name = $request->name;
        $shop->genre_id = $request->genre_id;
        $shop->area_id = $request->area_id;
        $shop->description = $request->description;
        $shop->opening_time = $request->opening_time;
        $shop->closing_time = $request->closing_time;

        // 画像をS3にアップロードする
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 's3');
            $imageUrl = \Storage::disk('s3')->url($imagePath);
            $shop->image_url = $imageUrl;
        }

        $shop->save();

        return response()->json($shop);
    }
}
