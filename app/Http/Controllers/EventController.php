<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $event->load([
            'category',
            'partner',
            'reviews.user',
        ]);

        $event->loadAvg('reviews', 'rating');

        return view('events.event-detail', compact('event'));
    }
}