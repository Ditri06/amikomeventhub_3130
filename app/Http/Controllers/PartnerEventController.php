<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerEventController extends Controller
{
    // Menampilkan event milik partner yang sedang login
    public function index()
    {
        $partner = Auth::user()->partner;

        if (!$partner) {
            abort(404, 'Data partner belum terhubung dengan akun ini.');
        }

        $events = Event::where('partner_id', $partner->id)
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('partner.events.index', compact('events'));
    }

    // Menampilkan form tambah event
    public function create()
    {
        $categories = Category::all();

        return view('partner.events.create', compact('categories'));
    }

    // Menyimpan event baru
    public function store(Request $request)
    {
        $partner = Auth::user()->partner;

        if (!$partner) {
            abort(404, 'Data partner belum terhubung dengan akun ini.');
        }

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')
                ->store('posters', 'public');
        }

        // Partner otomatis ditentukan dari akun yang sedang login
        $data['partner_id'] = $partner->id;

        Event::create($data);

        return redirect()
            ->route('partner.events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    // Menampilkan form edit event
    public function edit(Event $event)
    {
        $partner = Auth::user()->partner;

        if (!$partner || $event->partner_id !== $partner->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        $categories = Category::all();

        return view('partner.events.edit', compact('event', 'categories'));
    }

    // Update event
    public function update(Request $request, Event $event)
    {
        $partner = Auth::user()->partner;

        if (!$partner || $event->partner_id !== $partner->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')
                ->store('posters', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('partner.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    // Menghapus event
    public function destroy(Event $event)
    {
        $partner = Auth::user()->partner;

        if (!$partner || $event->partner_id !== $partner->id) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        $event->delete();

        return redirect()
            ->route('partner.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
