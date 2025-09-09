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
            return response()->json(['message'=>'No vacant tables'], 400);
        }

        if ($event->users()->where('user_id', $userId)->exists())
            {
                return response()->json(['message'=>'You are already registered'], 400);
            }

        $event->users()->attach($userId);

        return response()->json(['message'=>'You have successfully registered'], 200 );


    }

    public function cansel($eventId)
    {
        $userId = Auth::id();

        $event = Event::findOrFail($eventId);

        if(!$event->users()->where('user_id', $userId)->exists())
        {
            return response()->json(['message'=>'You have not registered for this event'], 400);
        }

        $event->users()->detach($userId);

        return response()->json(['message'=>'Your registration has been cancelled'], 200);
    }
}
