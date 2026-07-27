<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total pendapatan dari transaksi yang berhasil
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])
            ->sum('total_price');

        // 2. Jumlah tiket yang sudah terjual
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])
            ->count();

        // 3. Jumlah event yang masih aktif / akan datang
        $activeEvents = Event::where('date', '>=', now())
            ->count();

        // 4. Jumlah transaksi yang masih pending
        $pendingOrders = Transaction::where('status', 'pending')
            ->count();

        // 5. 5 transaksi terbaru
        $recentTransactions = Transaction::with('event')
            ->latest()
            ->take(5)
            ->get();


        // =====================================================
        // DATA GRAFIK PERTUMBUHAN PENGGUNA
        // =====================================================

        $userGrowth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Membuat array 12 bulan dengan nilai awal 0
        $userChartLabels = [];
        $userChartData = [];

        for ($month = 1; $month <= 12; $month++) {

            $userChartLabels[] = date('M', mktime(0, 0, 0, $month, 1));

            $userChartData[] = $userGrowth
                ->where('month', $month)
                ->first()
                ->total ?? 0;
        }


        // =====================================================
        // DATA GRAFIK PERTUMBUHAN EVENT
        // =====================================================

        $eventGrowth = Event::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Membuat array 12 bulan dengan nilai awal 0
        $eventChartLabels = [];
        $eventChartData = [];

        for ($month = 1; $month <= 12; $month++) {

            $eventChartLabels[] = date('M', mktime(0, 0, 0, $month, 1));

            $eventChartData[] = $eventGrowth
                ->where('month', $month)
                ->first()
                ->total ?? 0;
        }


        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',

            // Data grafik pengguna
            'userChartLabels',
            'userChartData',

            // Data grafik event
            'eventChartLabels',
            'eventChartData'
        ));
    }
}
