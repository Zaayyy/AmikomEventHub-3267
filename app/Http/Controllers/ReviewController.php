<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Event $event)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('home')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah user pernah membeli tiket event ini
        $transaction = Transaction::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['success', 'settlement'])
            ->exists();

        // Event hanya bisa direview setelah 1 hari selesai
        if (Carbon::now()->lt($event->date->copy()->addDay())) {

        return redirect()
            ->route('events.show', $event->id)
            ->with('error', 'Review hanya dapat diberikan 1 hari setelah acara selesai.');

    }

        if (!$transaction) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Anda belum membeli tiket event ini.');
        }

        // Cek apakah sudah pernah review
        $review = Review::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($review) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Anda sudah memberikan review.');
        }

        return view('reviews.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $transaction = Transaction::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['success', 'settlement'])
            ->exists();
        if (Carbon::now()->lt($event->date->copy()->addDay())) {

    return redirect()
        ->route('events.show', $event->id)
        ->with('error', 'Review belum dapat diberikan.');

        }

        if (!$transaction) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Anda tidak dapat memberikan review.');
        }

        if (! $event->partner_id) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Review belum dapat diberikan karena penyelenggara event belum terdaftar.');
        }

        $alreadyReview = Review::where('event_id',$event->id)
    ->where('user_id',Auth::id())
    ->exists();

if($alreadyReview){

    return redirect()
        ->route('events.show',$event)
        ->with('error','Anda sudah memberikan review.');

}

        Review::create([
            'event_id' => $event->id,
            'partner_id' => $event->partner_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('events.show', $event->id)
            ->with('success', 'Terima kasih, review berhasil dikirim.');
    }
}
