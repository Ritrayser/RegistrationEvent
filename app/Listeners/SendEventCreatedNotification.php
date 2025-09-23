<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmed;
use App\Jobs\SendEmailNotification;

class SendEventCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(UserRegisterEvent $event): void
    {
        $mail = new RegistrationConfirmed($event->createdEvent, $event->user);
        SendEmailNotification::dispatch($mail, $event->user->email);
    }
}
