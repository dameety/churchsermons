<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class NewUserWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $mailHeading;
    public $mailBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $mailHeading, $mailBody)
    {

        $this->user = $user;
        $this->mailHeading = $mailHeading;
        $this->mailBody = $mailBody;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.newUserWelcomeMail');

    }
}
