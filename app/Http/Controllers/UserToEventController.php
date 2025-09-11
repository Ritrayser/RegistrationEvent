<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserToEventController extends Controller
{
    public function registor($eventId)
    {
        $userId = Auth::id();

        $event = Event::findOrFail($eventId);

        if ($event->users->count() >= $event->max_participants)
        {
            return response()->json([__('message.vacant')], 400);
        }

        if ($event->users()->where('user_id', $userId)->exists())
            {
                return response()->json([__('message.already')], 400);
            }

        $event->users()->attach($userId);

        return response()->json([__('message.successfully')], 200 );


    }

    public function cansel($eventId)
    {
        $userId = Auth::id();

        $event = Event::findOrFail($eventId);

        if(!$event->users()->where('user_id', $userId)->exists())
        {
            return response()->json([__('message.for_this_event')], 400);
        }

        $event->users()->detach($userId);

        return response()->json([__('message.cancelled')], 200);
    }

    public function getParticipants($eventId)
    {
        $event = Event::findOrFail($eventId);

        $participants = $event->users;

        return response()->json($participants);
    }
}
