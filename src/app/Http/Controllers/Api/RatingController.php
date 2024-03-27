<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Reservation;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * 店舗評価送信
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'shop_id' => 'required|integer',
            'user_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        $rating = new Rating();
        $rating->shop_id = $request->shop_id;
        $rating->user_id = $request->user_id;
        $rating->rating = $request->rating;
        $rating->comment = $request->comment;

        // 予約を評価済みに更新
        $reservation = Reservation::where('id', $request->reservation_id)
            ->where('status', Reservation::PAYMENT_COMPLETED) // 決済完了の予約のみ評価可能
            ->firstOrFail();

        // 予約がない場合はエラーを返す
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->status = Reservation::EVALUATED;

        try {
            // 店舗評価を登録
            $rating->save();

            // 予約を評価済みに更新
            $reservation->save();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Rating faild'], 404);
        }

        return response()->json(['message' => 'Rating created'], 201);
    }
}
