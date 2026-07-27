<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partner;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * Menampilkan semua Partner
     */
    public function index()
    {
        $partners = Partner::with('user')
            ->latest()
            ->get();

        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Menampilkan form tambah Partner
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Menyimpan Partner baru yang dibuat langsung oleh Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|url|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Membuat akun User untuk Partner
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(12)),
            'role' => 'partner',
        ]);

        // Membuat data Partner
        // Karena dibuat langsung oleh Admin,
        // maka status langsung approved
        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
            'user_id' => $user->id,
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner berhasil ditambahkan dan langsung disetujui!');
    }

    /**
     * Menampilkan detail Partner
     */
    public function show(string $id)
    {
        $partner = Partner::with([
            'user',
            'events',
            'reviews'
        ])->findOrFail($id);

        return view('admin.partners.show', compact('partner'));
    }

    /**
     * Menampilkan form edit Partner
     */
    public function edit(string $id)
    {
        $partner = Partner::with('user')
            ->findOrFail($id);

        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Mengupdate data Partner
     */
    public function update(Request $request, string $id)
    {
        $partner = Partner::with('user')
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|url|max:255',
            'email' => 'required|email|unique:users,email,' . $partner->user_id,
        ]);

        // Update akun User
        if ($partner->user) {
            $partner->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        // Update data Partner
        $partner->update([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner berhasil diperbarui!');
    }

    /**
     * Menghapus Partner
     */
    public function destroy(string $id)
    {
        $partner = Partner::with('user')
            ->findOrFail($id);

        // Hapus akun User yang terhubung
        if ($partner->user) {
            $partner->user->delete();
        }

        // Hapus data Partner
        $partner->delete();

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner berhasil dihapus!');
    }

    /**
     * Menyetujui pengajuan Partner
     */
    public function approve(string $id)
    {
        $partner = Partner::with('user')
            ->findOrFail($id);

        // Ubah status Partner menjadi approved
        $partner->update([
            'status' => 'approved',
        ]);

        // Ubah role User menjadi partner
        if ($partner->user) {
            $partner->user->update([
                'role' => 'partner',
            ]);
        }

        return redirect()
            ->route('admin.partners.index')
            ->with(
                'success',
                'Pengajuan Partner berhasil disetujui!'
            );
    }

    /**
     * Menolak pengajuan Partner
     */
    public function reject(string $id)
    {
        $partner = Partner::with('user')
            ->findOrFail($id);

        // Ubah status Partner menjadi rejected
        $partner->update([
            'status' => 'rejected',
        ]);

        // User tetap menjadi user biasa
        if ($partner->user) {
            $partner->user->update([
                'role' => 'user',
            ]);
        }

        return redirect()
            ->route('admin.partners.index')
            ->with(
                'success',
                'Pengajuan Partner berhasil ditolak.'
            );
    }
}
