<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index($userType)
    {
        $emailTemplateList = EmailTemplate::where('user_type', $userType)->get();

        if ($emailTemplateList->isEmpty()) {
            return response()->json(['message' => 'Email template not found'], 404);
        }

        return response()->json($emailTemplateList, 200);
    }
}
