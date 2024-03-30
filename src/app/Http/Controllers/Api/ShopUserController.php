<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use Illuminate\Http\Request;

class ShopUserController extends Controller
{
    public function index()
    {
        $shopUsers = ShopUser::with('shop')->get();
        return response()->json($shopUsers);
    }

    public function show($id)
    {
        $shopUser = ShopUser::find($id);
        return response()->json($shopUser);
    }

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
        // if ($request->shop_id) {
        //     // すでに登録されている店舗に新しい店舗代表者を登録する場合を想定
        //     // 更新の場合は別の店舗に変更することも想定
        //     $shopUser->shop_id = $request->shop_id;
        // } else {
        //     // 店舗IDがない場合はnullをセット
        //     // 初回登録してから店舗作成になるため
        //     $shopUser->shop_id = null;
        // }
        $shopUser->name = $request->name;
        $shopUser->email = $request->email;
        if ($request->password) {
            // パスワードが入力された場合のみ更新
            $shopUser->password = bcrypt($request->password);
        }
        $shopUser->save();

        return response()->json($shopUser, 200);
    }

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
}
