<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivityMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function build()
    {
        return $this->view('emails.activity-mails.activity-mail')
                    ->with('data', $this->emailData);
    }
}
