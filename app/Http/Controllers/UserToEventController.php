<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationCancelled;
use App\Mail\RegistrationConfirmed;
use App\Models\Event;
use App\Services\EventService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserToEventController extends Controller
{
    public function registor(Event $event, EventService $eventService)
    {

        try {
             $user = Auth::user();

             $eventService->registerUser($event, $user);

            return response()->json([__('message.successfully')], 200 );
        } catch(Exception $e)
        { 
            dd($e);
            return response()->json($e->getMessage(), $e->getCode());
        }
       

    }

    public function cansel(Event $event, EventService $eventService)
    {
        try{
            $user = Auth::user();

            $eventService->canselUser($event, $user);

            return response()->json([__('message.cancelled')], 200);
        } catch(Exception $e)
        {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function getParticipants(Event $event)
    {
        $participants = $event->user;

        return response()->json($participants);
    }
}
