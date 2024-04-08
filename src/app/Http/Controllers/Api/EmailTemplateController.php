<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    /**
     * ユーザータイプによるメールテンプレート一覧取得
     */
    public function index($userType)
    {
        $emailTemplateList = EmailTemplate::where('user_type', $userType)->get();

        if ($emailTemplateList->isEmpty()) {
            return response()->json(['message' => 'Email template not found'], 404);
        }

        return response()->json($emailTemplateList, 200);
    }
}
