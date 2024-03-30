<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailSendHistory;
use App\Mail\SendNewsMail;
use Mail;

class SendEmailController extends Controller
{
    public function adminStore(Request $request)
    {
        // 全一般ユーザー取得
        $userEmailList = User::whereNotNull('email_verified_at')->where('invalid_flag', 1)->pluck('email');

        foreach ($userEmailList as $userEmail) {
            // メール送信処理
            Mail::to($userEmail)->send(new SendNewsMail($request));
        }

        $adminUserId = 1;

        // メール送信履歴登録
        $emailSendHistory = new EmailSendHistory();
        $emailSendHistory->send_user_id = $adminUserId;
        $emailSendHistory->email_template_id = $request->email_template_id;
        $emailSendHistory->success_flag = 1;
        $emailSendHistory->sent_datetime = now();
        $emailSendHistory->user_type = EmailSendHistory::ADMIN_USER; // 管理者
        $emailSendHistory->save();

        return response()->json(['message' => 'メールを送信しました'], 200);
    }

    public function agentStore(Request $request)
    {
        // 全一般ユーザー取得
        $userEmailList = User::whereNotNull('email_verified_at')->pluck('email');

        foreach ($userEmailList as $userEmail) {
            // メール送信処理
            Mail::to($userEmail)->send(new SendNewsMail($request));
        }

        // メール送信履歴登録
        $emailSendHistory = new EmailSendHistory();
        $emailSendHistory->send_user_id = $request->user_id;
        $emailSendHistory->send_shop_id = $request->shop_id;
        $emailSendHistory->success_flag = 1;
        $emailSendHistory->sent_datetime = now();
        $emailSendHistory->user_type = EmailSendHistory::AGENT_USER; // 店舗代表者
        $emailSendHistory->save();

        return response()->json(['message' => 'メールを送信しました'], 200);
    }
}
