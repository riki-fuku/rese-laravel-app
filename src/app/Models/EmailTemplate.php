<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    const ADMIN_USER = 1; // 管理者
    const AGENT_USER = 2; // 店舗代表者
    const REMIND_MAIL = 3; // リマインドメール

    protected $fillable = [
        'name',
        'subject',
        'body',
        'user_type',
    ];
}
