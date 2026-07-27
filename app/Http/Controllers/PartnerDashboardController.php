<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Transaction;

class PartnerDashboardController extends Controller
{
    public function index()
    {
        // Ambil partner yang terhubung dengan akun yang sedang login
        $partner = Auth::user()->partner;

        // Jika akun partner belum terhubung dengan data partner
        if (!$partner) {
            abort(404, 'Data partner belum terhubung dengan akun ini.');
        }

        // Ambil semua event milik partner yang sedang login
        $events = Event::where('partner_id', $partner->id)
            ->latest()
            ->get();

        // Hitung jumlah event
        $totalEvents = $events->count();

        // Ambil ID event milik partner
        $eventIds = $events->pluck('id');

        // Hitung jumlah transaksi
        $totalTransactions = Transaction::whereIn('event_id', $eventIds)
            ->count();

        // Hitung total pendapatan dari transaksi yang berhasil
        $totalRevenue = Transaction::whereIn('event_id', $eventIds)
            ->where('status', 'success')
            ->sum('total_price');

        return view('partner.dashboard', compact(
            'partner',
            'events',
            'totalEvents',
            'totalTransactions',
            'totalRevenue'
        ));
    }
}
