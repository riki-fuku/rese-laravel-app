<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    /**
     * 予約一覧取得
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($userId)
    {
        $reservations = Reservation::with(['shop'])
            ->where('user_id', $userId)
            ->where('status', '!=', Reservation::EVALUATED) // 評価済は含めない
            ->where('status', '!=', Reservation::CANCELED) // キャンセルは含めない
            ->orderBy('status', 'asc')
            ->orderBy('reservation_date', 'asc')
            ->orderBy('reservation_time', 'asc')
            ->get();

        // statusを元にReservation::STATUSのlabelの値を取得してstatus_nameという項目に格納
        $reservations->transform(function ($reservation) {
            $reservation->status_name = Reservation::STATUS[$reservation->status]['label'];
            return $reservation;
        });


        return response()->json($reservations);
    }

    /**
     * 予約詳細取得
     *
     * @param $reservationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($reservationId)
    {
        $reservation = Reservation::with(['shop' => function ($query) {
            $query->with('area', 'genre');
        }, 'user'])
            ->find($reservationId);

        if (!$reservation) {
            return response()->json(['message' => '予約が見つかりません'], 404);
        }

        // statusを元にReservation::STATUSのlabelの値を取得してstatus_nameという項目に格納
        $reservation->status_name = Reservation::STATUS[$reservation->status]['label'];

        return response()->json($reservation);
    }

    /**
     * 予約登録
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReservationRequest $request)
    {
        $reservation = new Reservation();
        $reservation->shop_id = $request->shop_id;
        $reservation->user_id = $request->user_id;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->reservation_time = $request->reservation_time;
        $reservation->party_size = $request->party_size;
        $reservation->status = Reservation::RESERVED;

        try {
            $reservation->save();
        } catch (\Exception $e) {
            return response()->json(['message' => '予約登録に失敗しました'], 500);
        }

        return response()->json($reservation, 201);
    }

    /**
     * 予約更新
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $reservation = Reservation::where('status', Reservation::RESERVED)->find($request->id); // 予約済のみ更新可能

        if (!$reservation) {
            return response()->json(['message' => '予約が見つかりません'], 404);
        }

        $reservation->reservation_date = $request->reservation_date;
        $reservation->reservation_time = $request->reservation_time;
        $reservation->party_size = $request->party_size;

        try {
            $reservation->save();
        } catch (\Exception $e) {
            return response()->json(['message' => '予約更新に失敗しました'], 500);
        }

        return response()->json($reservation);
    }

    /**
     * 予約キャンセル
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($id)
    {
        $reservation = Reservation::where('status', Reservation::RESERVED)->find($id); // 予約済のみ削除可能

        if (!$reservation) {
            return response()->json(['message' => '予約が見つかりません'], 404);
        }

        $reservation->status = Reservation::CANCELED; // キャンセルステータスに変更

        try {
            $reservation->save();
        } catch (\Exception $e) {
            return response()->json(['message' => '予約キャンセルに失敗しました'], 500);
        }

        return response()->json($reservation);
    }

    /**
     * 予約ステータスを来店済に更新
     */
    public function visited(Request $request)
    {
        $id = $request->reservation_id;
        $reservation = Reservation::find($id);
        // statusを来店済(2)に変更
        $reservation->status = Reservation::VISITED;
        $reservation->save();
        return response()->json($reservation);
    }
}
