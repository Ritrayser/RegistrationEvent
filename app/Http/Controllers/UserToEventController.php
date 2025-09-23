<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserToEventController extends Controller
{
    public function register(Event $event, EventService $eventService)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            $eventService->registerUser($event, $user);

            DB::commit();
            return response()->json([__('message.successfully')], 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'trace' => $exception->getTraceAsString(),
            ]);
            return response()->json($exception->getMessage(), $exception->getCode());
        }
    }

    public function cancel(Event $event, EventService $eventService)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            $eventService->cancelUser($event, $user);
            DB::commit();
            return response()->json([__('message.cancelled')], 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'trace' => $exception->getTraceAsString(),
            ]);
            return response()->json($exception->getMessage(), $exception->getCode());
        }
    }

    public function getParticipants(Event $event)
    {
        $participants = $event->users;

        return response()->json($participants);
    }
}
