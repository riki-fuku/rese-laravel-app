<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->subject  = $request['subject'];
        $this->body  = $request['body'];
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
            ->view('mail.contact')
            ->subject($this->subject)
            ->with([
                'body' => $this->body,
            ]);;
    }
}
