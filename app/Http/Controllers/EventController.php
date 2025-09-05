<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
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
    public function store(EventRequest $request)
    {
        if (Gate::denies('isAdmin')) {
        return response()->json(['message' => 'You dont have enough rights'], 403);
    }   
        $event = Event::create($request->validated());
        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, string $id)
    {
        if (Gate::denies('isAdmin')) {
        return response()->json(['message' => 'You dont have enough rights'], 403);
    }   
        $event = Event::findOrFail($id);
        $event->update($request->validated());
        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('isAdmin')) {
        return response()->json(['message' => 'You dont have enough rights'], 403);
    }   
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(204);
    }
}
