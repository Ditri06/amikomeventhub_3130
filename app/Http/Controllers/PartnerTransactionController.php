<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PartnerTransactionController extends Controller
{
    public function index()
    {
        // Ambil data partner dari user yang sedang login
        $partner = Auth::user()->partner;

        // Jika belum terhubung dengan data partner
        if (!$partner) {
            abort(404, 'Data partner belum terhubung dengan akun ini.');
        }

        // Ambil ID semua event milik partner
        $eventIds = $partner->events()->pluck('id');

        // Ambil semua transaksi dari event milik partner
        $transactions = Transaction::with('event')
            ->whereIn('event_id', $eventIds)
            ->latest()
            ->get();

        // Statistik transaksi
        $totalTransactions = $transactions->count();

        $successfulTransactions = $transactions
            ->where('status', 'success')
            ->count();

        $pendingTransactions = $transactions
            ->where('status', 'Pending')
            ->count();

        // Total pendapatan dari transaksi berhasil
        $totalRevenue = $transactions
            ->where('status', 'success')
            ->sum('total_price');

        return view('partner.transactions.index', compact(
            'partner',
            'transactions',
            'totalTransactions',
            'successfulTransactions',
            'pendingTransactions',
            'totalRevenue'
        ));
    }
}
