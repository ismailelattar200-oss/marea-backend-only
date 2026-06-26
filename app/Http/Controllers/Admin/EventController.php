<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date', 'desc')->get();
        return EventResource::collection($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'event_date' => 'required|date',
            'capacity' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
             $path = $request->file('image')->store('events', 'public');
             $validated['image_url'] = url('storage/' . $path);
        }

        $event = Event::create($validated);
        return new EventResource($event);
    }

    public function show(Event $event)
    {
        return new EventResource($event);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'event_date' => 'date',
            'capacity' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
             $path = $request->file('image')->store('events', 'public');
             $validated['image_url'] = url('storage/' . $path);
        }

        $event->update($validated);
        return new EventResource($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
