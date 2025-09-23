<?php

namespace App\Listeners;

use App\Events\AdminCancelEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminCancellationNotification;
use App\Jobs\SendEmailNotification;

class SendAdminCancelEventNotification
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
    public function handle(AdminCancelEvent $event): void
    {
        $admin = User::where('is_admin', true)->first();

        $cancellationTime = Carbon::now()->toDateTimeString();

        $mail = (new AdminCancellationNotification($event->user, $event->event, $cancellationTime));
        SendEmailNotification::dispatch($mail, $admin->email);
    }
}
