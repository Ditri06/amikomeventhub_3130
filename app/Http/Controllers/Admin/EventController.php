<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;



class EventController extends Controller
{
    public function index()
{
// Memakai relasi dan pengaturan limit paginasi (10 entri per halaman)
$events = \App\Models\Event::with('category')->latest()->paginate(10);
return view('admin.events.index', compact('events'));
}

public function create()
{
$categories = \App\Models\Category::all();
return view('admin.events.create', compact('categories'));
}

public function store(\Illuminate\Http\Request $request)
{
    $data = $request->validate([

        'category_id' => 'required',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

    ]);

    // Upload poster
    if ($request->hasFile('poster')) {
        $data['poster_path'] = $request->file('poster')->store('posters', 'public');
    }

    // Simpan data event
    \App\Models\Event::create($data);

    return redirect()->route('admin.events.index')
        ->with('success', 'Data Event berhasil ditambahkan.');
}

public function destroy(Event $event)
{
    $event->delete();

    return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
}

public function edit(Event $event)

{

    $categories = \App\Models\Category::all();

    return view('admin.events.edit', compact('event', 'categories'));

}



public function update(\Illuminate\Http\Request $request, Event $event)

{

    $data = $request->validate([

        'category_id' => 'required',

        'title' => 'required|string|max:255',

        'description' => 'required|string',

        'date' => 'required|date',

        'location' => 'required|string|max:255',

        'price' => 'required|numeric',

        'stock' => 'required|numeric',

        'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

    ]);

    // Upload poster baru
    if ($request->hasFile('poster')) {

        $data['poster_path'] = $request->file('poster')
            ->store('posters', 'public');

    }

    $event->update($data);

    return redirect()->route('admin.events.index')
        ->with('success', 'Rincian data event berhasil diperbarui.');

}

    public function transactions()
    {
        return view('admin.transactions');
    }
}
