<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmed;
use App\Models\Event;
use App\Models\User;
use Illuminate\Mail\Mailable;

class SendEmailNotification implements ShouldQueue
{
    use Queueable;


    public function __construct(public Mailable $mail, public string $emailTo)
    {}

    public function handle(): void
    {
        Mail::to($this->emailTo)->send($this->mail);
    }
}
