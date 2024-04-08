<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /**
     * 決済処理
     */
    public function charge(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // 予約情報を取得
        $reservation = Reservation::where('status', Reservation::VISITED) // 来店中のみ決済可能
            ->where('shop_id', $request->shop_id)
            ->where('user_id', 1) // TODO: ログイン機能実装後に修正
            ->first();

        if (!$reservation) {
            return response()->json([
                'message' => '予約情報が見つかりません',
            ], 404);
        }

        $payment = new Payment();
        $payment->reservation_id = $reservation->id;
        $payment->payment_date = now();
        $payment->amount = $request->amount;
        $payment->payment_method = Payment::CREDIT;
        $payment->payment_status = Payment::PAID;


        try {
            // 決済情報を登録
            $payment->save();

            // 決済処理
            $charge = \Stripe\Charge::create([
                'amount' => $request->amount,
                'currency' => 'jpy',
                'description' => 'Example charge',
                'source' => $request->stripeToken,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => '決済情報の登録に失敗しました',
            ], 500);
        }

        return response()->json([
            'charge' => $charge,
        ]);
    }
}
