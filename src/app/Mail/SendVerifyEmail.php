<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $url;
    public $name;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->subject  = '【Rese初回ログイン】メールアドレスの確認メール';
        $this->url      = url('/auth/verify-email/' . $user->name . '/' . $user->email);
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
            ->view('mail.verify-email')
            ->subject($this->subject);
    }
}
