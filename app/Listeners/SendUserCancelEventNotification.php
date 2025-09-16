<?php

namespace App\Listeners;

use App\Events\UserCancelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\RegistrationCancelled;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($event->user->email)->send(new RegistrationCancelled($event->cancelEvent, $event->user));
    }
}
