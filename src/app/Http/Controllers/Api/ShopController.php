<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopUser;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('genre', 'area', 'favorite')->get();
        return response()->json($shops);
    }

    public function show($shopId)
    {
        $shop = Shop::with('genre', 'area', 'favorite')->find($shopId);
        return response()->json($shop);
    }

    public function store(Request $request)
    {
        // user_idは仮で1を入れる
        $userId = 1;

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
