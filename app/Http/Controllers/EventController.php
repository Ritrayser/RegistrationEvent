<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Event::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request, EventService $eventService)
    {
        $event = $eventService->createEvent($request->validated());
        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Event $event, EventService $eventService)
    {
        $event = $eventService->updateEvent($request->validated(), $event);
        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, EventService $eventService)
    {
        if (Gate::denies('isAdmin')) {
            return response()->json([__('message.rights')], 403);
        }
        $eventService->deleteEvent($event);
        return response()->json([
            "status" => true,
            'message' =>  __('message.removed')
        ], Response::HTTP_OK);
    }
}
