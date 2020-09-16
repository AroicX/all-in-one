<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Mail\QouteMail;
use Mail;
class QouteJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $invoice;
    public $client;
    public $company;
    public $invoice_items;
    public $invoice_vat_items;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = New QouteMail($this->invoice, $this->client, $this->company, $this->invoice_items, $this->invoice_vat_items);
        Mail::to($this->client->email)->send($email);
    }
}
