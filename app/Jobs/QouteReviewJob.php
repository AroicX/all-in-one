<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\QouteReviewMail;
use Mail;

class QouteReviewJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $qoute;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($qoute)
    {
        $this->qoute = $qoute;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = New QouteReviewMail($this->qoute);
        Mail::to($this->client->email)->send($email);
    }
}
