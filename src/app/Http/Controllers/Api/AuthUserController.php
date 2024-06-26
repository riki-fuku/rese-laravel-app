<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendVerifyEmail;
use Mail;
use App\Http\Requests\LoginRequest;

class AuthUserController extends Controller
{
    /**
     * ログイン
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = auth()->guard('user')->getProvider()->retrieveByCredentials($credentials);

        if ($user  && auth()->guard('user')->getProvider()->validateCredentials($user, $credentials)) {

            // メール認証が完了していない場合ログインできないようにする
            if ($user->email_verified_at === null) {
                return response()->json([
                    'message' => 'メール認証が完了していません'
                ], 401);
            }

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
            // ユーザー登録
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->invalid_flag = 1;

            $user->save();

            // ユーザー確認用メール送信処理
            Mail::to($user->email)->send(new SendVerifyEmail($user));

            return response()->json([
                'message' => 'ユーザー登録が完了しました',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ユーザー登録に失敗しました'
            ], 500);
        }
    }
}
