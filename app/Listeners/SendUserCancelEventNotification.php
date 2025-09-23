<?php

namespace App\Listeners;

use App\Events\UserCancelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\RegistrationCancelled;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailNotification;

class SendUserCancelEventNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCancelEvent $event): void
    {
        $mail = (new RegistrationCancelled($event->cancelEvent, $event->user));
        SendEmailNotification::dispatch($mail, $event->user->email);
    }
}
