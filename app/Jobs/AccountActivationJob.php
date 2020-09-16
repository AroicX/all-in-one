<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\AccountActivationMail;
use Mail;
class AccountActivationJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $recepient;
    public $name;
    public $token;
    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = New AccountActivationMail($this->recepient, $this->name, $this->token);
        Mail::to($this->recepient)->send($email);
    }
}
