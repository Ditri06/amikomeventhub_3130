<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    // Method untuk menampilkan halaman detail event
    public function show($id)
    {
        $event = Event::with([
            'category',
            'reviews.user',
            'partner',
            'ticketTiers'
        ])->findOrFail($id);

        $activeTier = $event->ticketTiers()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('sort_order')
            ->first();

        return view('events.show', compact('event', 'activeTier'));
    }

    // Method untuk menampilkan halaman checkout
    public function checkout()
    {
        return view('checkout');
    }

    // Method untuk menampilkan halaman tiket
    public function ticket()
    {
        return view('ticket');
    }

}
