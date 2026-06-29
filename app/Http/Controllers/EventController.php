<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::active()->upcoming()->orderBy('event_date')->get();
        $data = EventResource::collection($events)->resolve();
        $json = json_encode(['data' => $data], JSON_INVALID_UTF8_SUBSTITUTE);
        return response($json, 200, ['Content-Type' => 'application/json']);
    }
}
