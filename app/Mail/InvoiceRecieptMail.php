<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceRecieptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $reciept;
    public $client;
    public $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $reciept, $client,$company)
    {
        $this->invoice = $invoice;
        $this->reciept = $reciept;
        $this->client = $client;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('qoute@corperm.ng')->subject('Qoute')->view('Mail.invoice.reciept');
    }
}
