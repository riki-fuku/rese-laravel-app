<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    const RESERVED = 1;
    const VISITED = 2;
    const PAYMENT_COMPLETED = 3;
    const EVALUATED = 4;
    const CANCELED = 99;

    const STATUS = [
        self::RESERVED => ['label' => '予約済'],
        self::VISITED => ['label' => '来店中'],
        self::PAYMENT_COMPLETED => ['label' => '決済完了'],
        self::EVALUATED => ['label' => '評価済'],
        self::CANCELED => ['label' => 'キャンセル'],
    ];

    protected $fillable = [
        'shop_id',
        'user_id',
        'reservation_date',
        'reservation_time',
        'party_size',
        'status',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
