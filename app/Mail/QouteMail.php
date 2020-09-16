<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QouteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $client;
    public $company;
    public $invoice_items;
    public $invoice_vat_items;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $client, $company, $invoice_items, $invoice_vat_items)
    {
        $this->invoice = $invoice;
        $this->client = $client;
        $this->company = $company;
        $this->invoice_items = $invoice_items;
        $this->invoice_vat_items = $invoice_vat_items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('qoute@corperm.ng')->subject('Qoute')->view('Mail.invoice.qoute');
    
    }
}
