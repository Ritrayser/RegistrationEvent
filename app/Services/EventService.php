<?php

namespace App\Services;

use App\Events\UserRigisterEvent;
use App\Events\UserCancelEvent;
use App\Mail\RegistrationCancelled;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Event;
use Exception;

class EventService 
{   
    public function __construct()
    {
        
    }

    public function createEvent(array $eventData): Event
    {
       return Event::create($eventData); 
    }

    public function updateEvent (array $eventData, Event $event): Event
    {
        return $event->update($eventData);
    }

    public function deleteEvent(Event $event): bool
    {
        return $event->delete();
    }

    public function registerUser(Event $event, User $user)
    {
         if ($event->users->count() >= $event->max_participants)
        {
            throw new Exception(__('message.vacant'), 400);
        }

        if ($event->users()->where('user_id', $user->id)->exists())
            {
                throw new Exception(__('message.already'), 400);
            }

        $event->users()->attach($user);

        UserRigisterEvent::dispatch($event, $user);

       
    }

    public function cancelUser(Event $event, User $user)
    {
        if(!$event->users()->where('user_id', $user->id)->exists())
        {
            throw new Exception(__('message.for_this_event'), 400);
        }

        $event->users()->detach($user );

        UserCancelEvent::dispatch($event, $user);
    }
}