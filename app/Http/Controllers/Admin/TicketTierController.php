<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketTier;
use Illuminate\Http\Request;

class TicketTierController extends Controller
{
    /**
     * Menampilkan semua ticket tier
     */
    public function index()
    {
        $ticketTiers = TicketTier::with('event')
            ->orderBy('event_id')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.ticket-tiers.index', compact('ticketTiers'));
    }

    /**
     * Menampilkan form tambah ticket tier
     */
    public function create()
    {
        $events = Event::orderBy('title')->get();

        return view('admin.ticket-tiers.create', compact('events'));
    }

    /**
     * Menyimpan ticket tier baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'sort_order' => 'required|integer|min:1',
        ]);

        TicketTier::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()
            ->route('admin.ticket-tiers.index')
            ->with('success', 'Ticket tier berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail ticket tier
     */
    public function show(TicketTier $ticketTier)
    {
        return redirect()->route(
            'admin.ticket-tiers.edit',
            $ticketTier
        );
    }

    /**
     * Menampilkan form edit ticket tier
     */
    public function edit(TicketTier $ticketTier)
    {
        $events = Event::orderBy('title')->get();

        return view(
            'admin.ticket-tiers.edit',
            compact('ticketTier', 'events')
        );
    }

    /**
     * Mengupdate ticket tier
     */
    public function update(
        Request $request,
        TicketTier $ticketTier
    ) {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'sort_order' => 'required|integer|min:1',
        ]);

        $ticketTier->update([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()
            ->route('admin.ticket-tiers.index')
            ->with('success', 'Ticket tier berhasil diperbarui.');
    }

    /**
     * Menghapus ticket tier
     */
    public function destroy(TicketTier $ticketTier)
    {
        $ticketTier->delete();

        return redirect()
            ->route('admin.ticket-tiers.index')
            ->with('success', 'Ticket tier berhasil dihapus.');
    }
}
