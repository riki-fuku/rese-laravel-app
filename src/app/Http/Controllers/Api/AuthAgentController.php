<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthAgentController extends Controller
{
    /**
     * ログイン
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = auth()->guard('agent')->getProvider()->retrieveByCredentials($credentials);

        if ($user && auth()->guard('agent')->getProvider()->validateCredentials($user, $credentials)) {
            $request->session()->regenerate();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => '店舗代表者ログインしました',
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'ログインに失敗しました。メールアドレスまたはパスワードが間違っています。'
        ], 401);
    }

    /**
     * ログアウト
     */
    public function logout(Request $request)
    {
        auth()->guard('agent')->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => '店舗代表者ログアウトしました'
        ]);
    }
}