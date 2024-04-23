<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\ShopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

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
     * 店舗一覧登録(CSVアップロード)
     */
    public function storeCsv(Request $request)
    {
        // アップロードされたCSVファイルの中身を取得する
        $file = $request->file('csv');
        $file_path = $file->store('csv');
        // Storage::path()を使用して絶対パスを取得
        $absolute_path = Storage::path($file_path);

        try {
            \DB::beginTransaction();

            $csv = array_map('str_getcsv', file($absolute_path));

            foreach ($csv as $key => $value) {
                if ($key === 0) {
                    // ヘッダー行はスキップ
                    continue;
                }

                $shop = new Shop();

                // 項目数チェック
                if (count($value) !== 5) {
                    throw new Exception('CSVファイルの項目数が不正です');
                }

                // 店舗名チェック
                if (empty($value[0])) {
                    throw new Exception('店舗名が入力されていません');
                } else {
                    $shop->name = $value[0];
                }

                // エリア名チェック
                if (empty($value[1])) {
                    throw new Exception('エリア名が入力されていません');
                } else {
                    // エリア名が存在するかチェック
                    $area = Area::where('name', $value[1])->first();
                    if (!$area) {
                        throw new Exception('エリアが見つかりませんでした');
                    } else {
                        $shop->area_id = $area->id;
                    }
                }

                // ジャンル名チェック
                if (empty($value[2])) {
                    throw new Exception('ジャンル名が入力されていません');
                } else {
                    // ジャンル名が存在するかチェック
                    $genre = Genre::where('name', $value[2])->first();
                    if (!$genre) {
                        throw new Exception('ジャンルが見つかりませんでした');
                    } else {
                        $shop->genre_id = $genre->id;
                    }
                }

                // 店舗概要チェック
                if (empty($value[3])) {
                    throw new Exception('店舗概要が入力されていません');
                } else {
                    $shop->description = $value[3];
                }

                // 画像URLチェック
                if (empty($value[4])) {
                    throw new Exception('画像URLが入力されていません');
                } else {
                    $shop->image_url = $value[4];
                }

                // 店舗情報を登録
                $shop->opening_time = '00:00:00';
                $shop->closing_time = '23:59:59';
                $shop->save();
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Shops created'], 201);
    }

    /**
     * 店舗更新
     */
    public function update(Request $request)
    {
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
