<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('genre', 'area', 'favorite')->get();
        return response()->json($shops);
    }

    public function show($id)
    {
        $shop = Shop::with('genre', 'area', 'favorite')->find($id);
        return response()->json($shop);
    }
}
