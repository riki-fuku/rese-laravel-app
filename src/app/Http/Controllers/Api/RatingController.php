<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * 店舗評価一覧取得(店舗ID指定)
     *
     * @return \Illuminate\Http\Response
     */
    public function index($shopId)
    {
        // 店舗IDが指定されていない場合はエラーを返す
        if (!$shopId) {
            return response()->json(['message' => 'Shop ID not found'], 404);
        }

        $ratings = Rating::where('shop_id', $shopId)->get();

        return response()->json($ratings);
    }

    /**
     * 店舗評価一覧取得(ユーザーIDと店舗ID指定)
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByUser($userId, $shopId)
    {
        // ユーザーIDと店舗IDが指定されていない場合はエラーを返す
        if (!$userId || !$shopId) {
            return response()->json(['message' => 'User ID or Shop ID not found'], 404);
        }

        $rating = Rating::where('shop_id', $shopId)
            ->where('user_id', $userId)
            ->first();

        return response()->json($rating);
    }

    /**
     * 店舗評価送信
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // すでに登録されているか確認
        $rating = Rating::where('shop_id', $request->shop_id)
            ->where('user_id', $request->user_id)
            ->first();

        if (!$rating) {
            // 登録されていない場合は新規登録
            $rating = new Rating();
            $rating->shop_id = $request->shop_id;
            $rating->user_id = $request->user_id;
        }

        $rating->rating = $request->rating;
        $rating->comment = $request->comment;

        // 画像をS3にアップロードする
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('ratings', 's3');
            $imageUrl = \Storage::disk('s3')->url($imagePath);
            $rating->image_url = $imageUrl;
        } else {
            $rating->image_url = '';
        }

        try {
            // 店舗評価を登録
            $rating->save();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Rating faild'], 404);
        }

        return response()->json(['message' => 'Rating created'], 201);
    }

    /**
     * 店舗評価削除
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rating = Rating::find($id);

        // 該当の店舗評価がない場合はエラーを返す
        if (!$rating) {
            return response()->json(['message' => 'Rating not found'], 404);
        }

        $rating->delete();

        return response()->json(['message' => 'Rating deleted'], 200);
    }
}
