<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        // Validasi data review
        $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|max:1000',
    ]);

        // Cek apakah user sudah pernah memberikan review
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()
                ->route('events.show', $event->id)
                ->with('error', 'Anda sudah memberikan review untuk event ini.');
        }

        // Simpan review
        Review::create([
        'user_id' => Auth::id(),
        'event_id' => $event->id,
        'partner_id' => $event->partner_id,
        'rating' => $request->rating,
        'review' => $request->review,
    ]);
        return redirect()
            ->route('events.show', $event->id)
            ->with('success', 'Review berhasil dikirim. Terima kasih atas ulasan Anda!');
    }
}
