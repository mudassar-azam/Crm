<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EngineerCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.engineer-mails.engineer_credentials') 
                    ->subject('Your Engineer Credentials');
    }
}
