<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * ジャンル一覧取得
     */
    public function index()
    {
        $genres = Genre::all();
        return response()->json($genres);
    }
}
