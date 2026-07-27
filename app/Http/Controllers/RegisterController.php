<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    // Menampilkan halaman registrasi
    public function create()
    {
        return view('auth.register');
    }

    // Memproses registrasi
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama organisasi atau kepanitiaan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Membuat User dan Partner secara bersamaan
        DB::transaction(function () use ($request) {

            // Membuat akun User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            // Membuat data Partner
            Partner::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'status' => 'pending',
            ]);
        });

        // Kembali ke halaman login
        return redirect()
            ->route('admin.login')
            ->with(
                'success',
                'Pendaftaran berhasil. Akun Anda sedang menunggu persetujuan dari Admin.'
            );
    }
}
