<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SegaEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Chúc mừng bạn đã mua hàng thành công";
        // $this->withSwiftMessage(function ($message) {
        //     $from = 'Sega-Group <sega-group@sega-group.com>';
        //     $message->getHeaders()->addTextHeader('From', 'Sega-Group <sega-group@sega-group.com>');
        //     $message->getHeaders()->addTextHeader('Reply-To', 'Sega-Group <sega-group@sega-group.com>');
        //     $message->getHeaders()->addTextHeader('Return-Path', 'Sega-Group <sega-group@sega-group.com>');
        //     $message->getHeaders()->addTextHeader('MIME-Version', '1.0');
        //     $message->getHeaders()->addTextHeader('Content-Type', 'text/html; charset=ISO-8859-1');
        //     $message->getHeaders()->addTextHeader('X-Priority', '3');
        //     $message->getHeaders()->addTextHeader('X-Mailer', 'PHP'.phpversion());
        // });
        $subject = "Chúc mừng bạn đã mua hàng thành công";
        $this
        ->subject($subject)
        ->view('email');


    }
}
