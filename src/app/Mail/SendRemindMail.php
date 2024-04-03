<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRemindMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $name;
    public $reservationDate;
    public $shopName;
    public $partySize;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->subject  = '【Rese】本日予約当日になります';
        $this->name  = $reservation->user->name;
        $this->reservationDate = $reservation->reservation_date . ' ' . $reservation->reservation_time;
        $this->shopName = $reservation->shop->name;
        $this->partySize = $reservation->party_size;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return
            $this
            ->view('mail.remind')
            ->subject($this->subject)
            ->with([
                'name' => $this->name,
                'reservationDate' => $this->reservationDate,
                'shopName' => $this->shopName,
                'partySize' => $this->partySize,
            ]);;
    }
}
