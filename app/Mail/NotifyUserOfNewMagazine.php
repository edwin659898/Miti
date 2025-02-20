<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfNewMagazine extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $intro, $content, $credentials;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($intro, $content, $credentials)
    {
        $this->intro = $intro;
        $this->content = $content;
        $this->credentials = $credentials;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new-magazine')
            ->subject('Miti Magazine Notification')
            ->replyTo('miti-magazine@betterglobeforestry.com');
    }
}
