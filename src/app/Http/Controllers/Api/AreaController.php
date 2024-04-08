<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;

class AreaController extends Controller
{
    /**
     * エリア一覧取得
     */
    public function index()
    {
        $areas = Area::all();
        return response()->json($areas);
    }
}
