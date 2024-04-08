<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserVerifyEmailController extends Controller
{
    /**
     * ユーザーのユーザー認証日付を更新
     */
    public function verifyEmail($name, $email)
    {
        $user = User::where('email', $email)
            ->where('name', $name)
            ->first();

        $loginUrl = env('VUE_APP_URL');

        if ($user->email_verified_at !== null) {
            return view('verified-email', compact('loginUrl'));
        }

        $user->email_verified_at = now();
        $user->save();

        return view('verify-email-complete', compact('loginUrl'));
    }
}
