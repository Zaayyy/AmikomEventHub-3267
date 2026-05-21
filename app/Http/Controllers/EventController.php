<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show($id)
{
    $event = Event::findOrFail($id); // Mencari data berdasarkan ID
    return view('events.show', compact('event')); // Memanggil resources/views/events/show.blade.php
}
}
