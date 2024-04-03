<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SendRemindMail;
use App\Models\Reservation;
use Mail;

class SendRemindEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendRemindEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'リマインドメールを送信するバッチです。';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 当日予約しているユーザーのメールアドレス取得
        $reservationList = Reservation::with('user', 'shop')
            ->where('reservation_date', date('Y-m-d'))
            ->where('status', Reservation::RESERVED)
            ->get();

        try {
            // メール送信
            if (!empty($reservationList)) {
                foreach ($reservationList as $reservation) {
                    Mail::to($reservation->user->email)->send(new SendRemindMail($reservation));
                }
            }
        } catch (\Exception $e) {
            \Log::info(date('Y-m-d') . "のリマインドメールを送信失敗しました。");
            echo "メール送信に失敗しました。\n";
            return 1;
        }

        \Log::info(date('Y-m-d') . "のリマインドメールを送信完了しました。");
        echo "リマインドメールを送信しました。\n";
        return 0;
    }
}
