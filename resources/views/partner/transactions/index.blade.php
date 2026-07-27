@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Partner')

@section('page_title', 'Laporan Transaksi')

@section('page_subtitle', 'Pantau transaksi dari event yang Anda selenggarakan.')

@section('content')

<div class="space-y-8">

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Total Transaksi --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-sm font-bold text-slate-500 uppercase">
                Total Transaksi
            </p>

            <h3 class="text-4xl font-black text-slate-800 mt-3">
                {{ $totalTransactions }}
            </h3>

            <p class="text-sm text-slate-400 mt-2">
                Semua transaksi event
            </p>
        </div>


        {{-- Transaksi Berhasil --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-sm font-bold text-slate-500 uppercase">
                Berhasil
            </p>

            <h3 class="text-4xl font-black text-green-600 mt-3">
                {{ $successfulTransactions }}
            </h3>

            <p class="text-sm text-slate-400 mt-2">
                Transaksi berhasil
            </p>
        </div>


        {{-- Transaksi Pending --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-sm font-bold text-slate-500 uppercase">
                Pending
            </p>

            <h3 class="text-4xl font-black text-yellow-600 mt-3">
                {{ $pendingTransactions }}
            </h3>

            <p class="text-sm text-slate-400 mt-2">
                Menunggu pembayaran
            </p>
        </div>


        {{-- Total Pendapatan --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-sm font-bold text-slate-500 uppercase">
                Total Pendapatan
            </p>

            <h3 class="text-3xl font-black text-indigo-600 mt-3">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h3>

            <p class="text-sm text-slate-400 mt-2">
                Dari transaksi berhasil
            </p>
        </div>

    </div>


    {{-- Tabel Transaksi --}}
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">

        <div class="mb-8">
            <h2 class="text-2xl font-black text-slate-800">
                Daftar Transaksi
            </h2>

            <p class="text-slate-500 mt-1">
                Transaksi dari event yang Anda selenggarakan.
            </p>
        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b border-slate-100 text-left">

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            No
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Order ID
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Event
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Nama Customer
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Email
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Total
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Status
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Tanggal
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($transactions as $transaction)

                        <tr class="border-b border-slate-50">

                            <td class="py-4 px-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="py-4 px-4 font-bold text-slate-700">
                                {{ $transaction->order_id }}
                            </td>

                            <td class="py-4 px-4 font-medium text-slate-700">
                                {{ $transaction->event->title ?? '-' }}
                            </td>

                            <td class="py-4 px-4 text-slate-600">
                                {{ $transaction->customer_name }}
                            </td>

                            <td class="py-4 px-4 text-slate-500">
                                {{ $transaction->customer_email }}
                            </td>

                            <td class="py-4 px-4 font-medium">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>

                            <td class="py-4 px-4">

                                @if($transaction->status === 'success')

                                    <span class="px-3 py-2 bg-green-100 text-green-700 rounded-xl font-bold text-sm">
                                        Berhasil
                                    </span>

                                @elseif($transaction->status === 'Pending')

                                    <span class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-xl font-bold text-sm">
                                        Pending
                                    </span>

                                @else

                                    <span class="px-3 py-2 bg-red-100 text-red-700 rounded-xl font-bold text-sm">
                                        {{ ucfirst($transaction->status) }}
                                    </span>

                                @endif

                            </td>

                            <td class="py-4 px-4 text-slate-500">
                                {{ $transaction->created_at->format('d M Y, H:i') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="py-10 text-center text-slate-400">

                                Belum ada transaksi dari event Anda.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
