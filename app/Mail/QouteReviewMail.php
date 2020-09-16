<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QouteReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $qoute
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($qoute)
    {
        $this->qoute = $qoute;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('qoute@corperm.ng')->subject('Qoute')->view('Mail.invoice.qoute_review');
    }
}
