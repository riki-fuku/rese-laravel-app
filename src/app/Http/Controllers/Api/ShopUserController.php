<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ShopUserController extends Controller
{
    /**
     * 店舗代表者一覧取得
     */
    public function index()
    {
        $shopUsers = ShopUser::with('shop')->get();
        return response()->json($shopUsers);
    }

    /**
     * 店舗代表者詳細取得
     */
    public function show($id)
    {
        $shopUser = ShopUser::find($id);
        return response()->json($shopUser);
    }

    /**
     * 店舗代表者登録
     */
    public function store(Request $request)
    {
        // メールアドレスのユニークチェック
        $existEmail = ShopUser::where('email', $request->email)->exists();
        // エラー処理
        if ($existEmail) {
            return response()->json([
                'message' => 'メールアドレスがすでに登録されています。'
            ], 422);
        }

        // 店舗代表者作成
        $shopUser = new ShopUser();
        if ($request->shop_id) {
            // すでに登録されている店舗に新しい店舗代表者を登録する場合を想定
            $shopUser->shop_id = $request->shop_id;
        } else {
            // 店舗IDがない場合はnullをセット
            // 初回登録してから店舗作成になるため
            $shopUser->shop_id = null;
        }
        $shopUser->name = $request->name;
        $shopUser->email = $request->email;
        $shopUser->password = bcrypt($request->password);
        $shopUser->save();

        return response()->json($shopUser);
    }

    /**
     * 店舗代表者更新
     */
    public function update(Request $request)
    {
        // メールアドレスのユニークチェック
        $existEmail = ShopUser::where('email', $request->email)->where('id', '!=', $request->id)->exists();
        // エラー処理
        if ($existEmail) {
            return response()->json([
                'message' => 'メールアドレスがすでに登録されています。'
            ], 422);
        }

        // 店舗代表者更新
        $shopUser = ShopUser::find($request->id);
        $shopUser->name = $request->name;
        $shopUser->email = $request->email;
        if ($request->password) {
            // パスワードが入力された場合のみ更新
            $shopUser->password = bcrypt($request->password);
        }
        $shopUser->save();

        return response()->json($shopUser, 200);
    }

    /**
     * 店舗代表者のログインの有効・無効を切り替える
     */
    public function changeInvalid(Request $request)
    {
        $shopUser = ShopUser::find($request->id);
        if ($shopUser->invalid_flag == 0) {
            $shopUser->invalid_flag = 1;
        } elseif ($shopUser->invalid_flag == 1) {
            $shopUser->invalid_flag = 0;
        }
        $shopUser->save();

        return response()->json($shopUser);
    }

    /**
     * 店舗代表者と店舗の紐付け取得
     */
    public function showShop()
    {
        // ログイン中の店舗代表者のIDを取得
        $shopUserid = auth()->id();

        $shopUser = ShopUser::with(['shop' => function ($query) {
            $query->with('area', 'genre');
        }])
            ->find($shopUserid);

        return response()->json($shopUser->shop);
    }

    /**
     * 店舗代表者の予約一覧取得
     */
    public function showReservations()
    {
        // ログイン中の店舗代表者のIDを取得
        $shopUserid = auth()->id();

        $shopUser = ShopUser::with(['shop' => function ($query) {
            $query->with(['reservations' => function ($query) {
                $query->orderBy('status', 'asc');
                $query->orderBy('reservation_date', 'asc');
                $query->orderBy('reservation_time', 'asc');
                $query->with('user');
            }]);
        }])
            ->find($shopUserid);

        // statusを元にReservation::STATUSのlabelの値を取得してstatus_nameという項目に格納
        $shopUser->shop->reservations->map(function ($reservation) {
            $reservation->status_name = Reservation::STATUS[$reservation->status]['label'];
        });

        return response()->json($shopUser->shop->reservations);
    }
}
