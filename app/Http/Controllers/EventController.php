<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::active()->upcoming()->orderBy('event_date')->get();
        return EventResource::collection($events);
    }
}
