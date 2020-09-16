<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountActivationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $recepient;
    public $name;
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recepient, $name, $token)
    {
         $this->recepient = $recepient;
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@corperm.com')->subject('CorpERM Account Activation')->view('Mail.Account_activation');
    }
}
