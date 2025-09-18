<?php

namespace App\Listeners;

use App\Events\AdminCancelEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminCancellationNotification;

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

        Mail::to($admin->email)->send(new AdminCancellationNotification($event->user, $event->event, $cancellationTime));
    }
}
