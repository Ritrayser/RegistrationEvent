<?php

namespace App\Listeners;

use App\Events\UserRigisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\RegistrationConfirmed;

class SendEventCreatedNotification
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
    public function handle(UserRigisterEvent $event): void
    {
        Mail::to($event->user->email)->send(new RegistrationConfirmed($event->createdEvent, $event->user));
    }
}
