<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // 決済方法
    const CREDIT = 1; // クレジット決済
    const CASH = 2; // 現金決済
    const OTHER = 99; // その他

    // 決済ステータス
    const UNPAID = 0; // 支払い未
    const PAID = 1; // 支払い済
    const PAYMENT_ERROR = 2; // 決済エラー

    protected $fillable = [
        'reservation_id',
        'payment_date',
        'amount',
        'payment_method',
        'payment_status'
    ];
}
