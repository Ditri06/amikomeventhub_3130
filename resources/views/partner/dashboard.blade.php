@extends('layouts.admin')

@section('title', 'Dashboard Partner')

@section('page_title', 'Dashboard Partner')

@section('page_subtitle', 'Kelola event dan pantau performa penyelenggara.')

@section('content')

<div class="space-y-8">



    {{-- Informasi Partner --}}
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="flex items-center gap-5">

            @if($partner->logo_url)
                <img
                    src="{{ $partner->logo_url }}"
                    alt="{{ $partner->name }}"
                    class="w-20 h-20 object-contain rounded-2xl bg-slate-50 p-3"
                >
            @else
                <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center font-bold text-3xl">
                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                </div>
            @endif

            <div>
                <p class="text-sm text-slate-500 font-bold uppercase tracking-wide">
                    Penyelenggara
                </p>

                <h2 class="text-3xl font-black text-slate-800">
                    {{ $partner->name }}
                </h2>

                <p class="text-sm text-green-600 font-bold mt-1">
                    Status: {{ ucfirst($partner->status) }}
                </p>
            </div>

        </div>
    </div>


    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Total Event --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-sm font-bold text-slate-500 uppercase">
                Total Event
            </p>

            <h3 class="text-4xl font-black text-slate-800 mt-3">
                {{ $totalEvents }}
            </h3>

            <p class="text-sm text-slate-400 mt-2">
                Event yang kamu kelola
            </p>
        </div>


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


    {{-- Daftar Event --}}
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">

        <div class="mb-6">
            <h2 class="text-2xl font-black text-slate-800">
                Event Saya
            </h2>

            <p class="text-slate-500 mt-1">
                Daftar event yang dikelola oleh penyelenggara ini.
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
                            Nama Event
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Tanggal
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Harga
                        </th>

                        <th class="py-4 px-4 text-sm font-bold text-slate-500">
                            Stok
                        </th>

                    </tr>
                </thead>


                <tbody>

                    @forelse($events as $event)

                        <tr class="border-b border-slate-50">

                            <td class="py-4 px-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="py-4 px-4 font-bold text-slate-700">
                                {{ $event->title }}
                            </td>

                            <td class="py-4 px-4 text-slate-500">
                                {{ $event->date->format('d M Y, H:i') }}
                            </td>

                            <td class="py-4 px-4 font-medium">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </td>

                            <td class="py-4 px-4">
                                {{ $event->stock }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400">
                                Belum ada event yang dibuat.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
