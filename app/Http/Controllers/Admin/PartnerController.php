<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    // READ
    public function index(Request $request)
    {
        $search = $request->search;

        $partners = Partner::when($search, function ($query) use ($search) {

            $query->where('name', 'LIKE', '%' . $search . '%');

        })->latest()->get();

        return view('admin.partners.index', compact('partners'));
    }

    // CREATE
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|min:2',
        'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $path = $request->file('logo')->store('partners', 'public');

    Partner::create([
        'name' => $request->name,
        'logo_url' => $path
    ]);

    return back()->with('success', 'Partner berhasil ditambahkan');
}

    // UPDATE
    public function update(Request $request, Partner $partner)
{
    $request->validate([
        'name' => 'required|min:2',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = [
        'name' => $request->name
    ];

    if ($request->hasFile('logo')) {

        if ($partner->logo_url) {
            Storage::disk('public')->delete($partner->logo_url);
        }

        $data['logo_url'] =
            $request->file('logo')->store('partners', 'public');
    }

    $partner->update($data);

    return back()->with('success', 'Partner berhasil diupdate');
}

    // DELETE
   public function destroy(Partner $partner)
{
    if ($partner->logo_url) {
        Storage::disk('public')->delete($partner->logo_url);
    }

    $partner->delete();

    return back()->with('success', 'Partner berhasil dihapus');
}
}
