<?php

namespace App\Listeners;

use App\Events\AdminRegisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminRegistrationNotification;


class SendAdminRegisterEventNotification
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
    public function handle(AdminRegisterEvent $event): void
    {
        $admin = User::where('is_admin', true)->first();

        $registrationTime = Carbon::now()->toDateTimeString();

        Mail::to($admin->email)->send(new AdminRegistrationNotification($event->user, $event->event, $registrationTime));
    }
}
