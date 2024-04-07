<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthUserController extends Controller
{
    /**
     * ログイン
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = auth()->guard('user')->getProvider()->retrieveByCredentials($credentials);

        if ($user && auth()->guard('user')->getProvider()->validateCredentials($user, $credentials)) {
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
     * ログアウト
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'ログアウトしました'
        ]);
    }

    /**
     * ユーザー登録
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'invalid_flag' => 1
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'ユーザー登録が完了しました',
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ユーザー登録に失敗しました'
            ], 500);
        }
    }
}