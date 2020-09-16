<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\InvoiceRecieptMail;
use Mail;

class InvoiceRecieptJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $invoice;
    public $reciept;
    public $client;
    public $company;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($invoice, $reciept, $client, $company)
    {
        $this->invoice = $invoice;
        $this->reciept = $reciept;
        $this->client = $client;
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = New InvoiceRecieptMail($this->invoice, $this->reciept, $this->client, $this->company);
        Mail::to($this->client->email)->send($email);
    }
}
