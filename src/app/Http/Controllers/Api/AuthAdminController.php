<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    /**
     * 管理者ログイン
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = auth()->guard('admin')->getProvider()->retrieveByCredentials($credentials);

        if ($user && auth()->guard('admin')->getProvider()->validateCredentials($user, $credentials)) {
            $request->session()->regenerate();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'ログインしました',
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'ログインに失敗しました。メールアドレスまたはパスワードが間違っています。'
        ], 401);
    }

    /**
     * 管理者ログアウト
     */
    public function logout(Request $request)
    {
        auth()->guard('admin')->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'ログアウトしました'
        ]);
    }
}
