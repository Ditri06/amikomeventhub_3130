@extends('layouts.app')

@section('title', 'E-Ticket - ' . $transaction->event->title)

@section('content')

<main class="max-w-4xl mx-auto px-6 py-16">

    {{-- ===================================================== --}}
    {{-- PESAN SUKSES --}}
    {{-- ===================================================== --}}

    <div class="text-center mb-10">

        <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-5">

            <svg
                class="w-10 h-10"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7"
                ></path>

            </svg>

        </div>


        <h1 class="text-3xl font-black mb-3">
            Pembayaran Berhasil!
        </h1>


        <p class="text-slate-500">
            Terima kasih telah melakukan pemesanan.
            E-Ticket Anda sudah tersedia dan dapat dicetak.
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- E-TICKET --}}
    {{-- ===================================================== --}}

    <div
        id="eticket"
        class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden"
    >

        {{-- ================================================= --}}
        {{-- HEADER E-TICKET --}}
        {{-- ================================================= --}}

        <div class="bg-indigo-600 text-white p-8">

            <div class="flex flex-col md:flex-row justify-between gap-6">

                <div>

                    <p class="text-indigo-200 text-sm font-bold uppercase tracking-wider">
                        E-TICKET
                    </p>

                    <h2 class="text-3xl font-black mt-2">
                        {{ $transaction->event->title }}
                    </h2>

                </div>


                <div class="text-left md:text-right">

                    <p class="text-indigo-200 text-sm">
                        Order ID
                    </p>

                    <p class="font-black text-lg">
                        {{ $transaction->order_id }}
                    </p>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- DETAIL EVENT --}}
        {{-- ================================================= --}}

        <div class="p-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- ================================================= --}}
                {{-- POSTER --}}
                {{-- ================================================= --}}

                <div>

                    @if(
                        $transaction->event->poster_path &&
                        Storage::disk('public')->exists(
                            $transaction->event->poster_path
                        )
                    )

                        <img
                            src="{{ asset('storage/' . $transaction->event->poster_path) }}"
                            alt="{{ $transaction->event->title }}"
                            class="w-full aspect-[3/4] object-cover rounded-2xl"
                        >

                    @else

                        <img
                            src="{{ asset('assets/concert.png') }}"
                            alt="{{ $transaction->event->title }}"
                            class="w-full aspect-[3/4] object-cover rounded-2xl"
                        >

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- INFORMASI EVENT --}}
                {{-- ================================================= --}}

                <div class="md:col-span-2 space-y-6">

                    {{-- NAMA EVENT --}}

                    <div>

                        <p class="text-sm text-slate-400 font-bold uppercase">
                            Nama Event
                        </p>

                        <p class="text-lg font-black">
                            {{ $transaction->event->title }}
                        </p>

                    </div>


                    {{-- TANGGAL DAN LOKASI --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>

                            <p class="text-sm text-slate-400 font-bold uppercase">
                                Tanggal
                            </p>

                            <p class="font-bold">
                                {{ $transaction->event->date->format('d F Y') }}
                            </p>

                        </div>


                        <div>

                            <p class="text-sm text-slate-400 font-bold uppercase">
                                Lokasi
                            </p>

                            <p class="font-bold">
                                {{ $transaction->event->location }}
                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- DATA PEMESAN --}}
                    {{-- ================================================= --}}

                    <div class="border-t border-slate-100 pt-6">

                        <p class="text-sm text-slate-400 font-bold uppercase mb-3">
                            Data Pemesan
                        </p>


                        <div class="space-y-2">

                            <p>

                                <span class="font-bold">
                                    Nama:
                                </span>

                                {{ $transaction->customer_name }}

                            </p>


                            <p>

                                <span class="font-bold">
                                    Email:
                                </span>

                                {{ $transaction->customer_email }}

                            </p>


                            <p>

                                <span class="font-bold">
                                    WhatsApp:
                                </span>

                                {{ $transaction->customer_phone }}

                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- TOTAL PEMBAYARAN --}}
                    {{-- ================================================= --}}

                    <div class="border-t border-slate-100 pt-6">

                        <div class="flex justify-between items-center">

                            <div>

                                <p class="text-sm text-slate-400 font-bold uppercase">
                                    Total Pembayaran
                                </p>


                                <p class="text-2xl font-black text-indigo-600">

                                    {{ $transaction->total_price == 0
                                        ? 'Gratis'
                                        : 'Rp ' . number_format(
                                            $transaction->total_price,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </p>

                            </div>


                            <div>

                                <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full font-bold text-sm">

                                    LUNAS

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- QR CODE --}}
        {{-- HANYA MUNCUL SAAT CETAK --}}
        {{-- ================================================= --}}

        <div
            id="print-qrcode"
            class="hidden border-t-2 border-dashed border-slate-200 p-8"
        >

            <div class="flex flex-col items-center justify-center">

                <p class="text-sm text-slate-500 font-bold uppercase mb-4">
                    QR Code E-Ticket
                </p>


                <div class="bg-white p-4 rounded-2xl border border-slate-200">

                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($transaction->order_id) }}"
                        alt="QR Code E-Ticket"
                        class="w-48 h-48"
                    >

                </div>


                <p class="text-xs text-slate-500 mt-4 text-center">

                    Tunjukkan QR Code ini kepada panitia
                    saat memasuki acara.

                </p>


                <p class="text-sm font-bold text-slate-700 mt-2">

                    {{ $transaction->order_id }}

                </p>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- FOOTER TICKET --}}
        {{-- ================================================= --}}

        <div class="border-t-2 border-dashed border-slate-200 p-8">

            <div class="text-center">

                <p class="text-sm text-slate-500 mb-2">

                    Tunjukkan E-Ticket ini kepada panitia
                    saat memasuki acara.

                </p>


                <p class="text-xs text-slate-400">

                    Order ID: {{ $transaction->order_id }}

                </p>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- TOMBOL AKSI --}}
    {{-- ===================================================== --}}

    <div class="flex flex-col md:flex-row justify-center gap-4 mt-8">

        {{-- ================================================= --}}
        {{-- CETAK E-TICKET --}}
        {{-- ================================================= --}}

        <button
            onclick="window.print()"
            class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"
        >

            🖨️ Cetak E-Ticket

        </button>


        {{-- ================================================= --}}
        {{-- KEMBALI KE HOME --}}
        {{-- ================================================= --}}

        <a
            href="{{ route('home') }}"
            class="px-8 py-4 border-2 border-slate-200 rounded-xl font-bold text-slate-600 hover:border-indigo-600 hover:text-indigo-600 transition text-center"
        >

            Kembali ke Beranda

        </a>

    </div>

</main>


{{-- ========================================================= --}}
{{-- PRINT STYLE --}}
{{-- ========================================================= --}}

<style>

@media print {

    /* Hilangkan background halaman */
    body {
        background: white !important;
    }


    /* Sembunyikan elemen yang tidak perlu dicetak */
    nav,
    footer,
    button,
    a {
        display: none !important;
    }


    /* Atur ukuran area cetak */
    main {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }


    /* Hilangkan shadow dan border luar */
    #eticket {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
        border-radius: 0 !important;
    }


    /* ===================================================== */
    /* QR CODE HANYA MUNCUL SAAT PRINT */
    /* ===================================================== */

    #print-qrcode {
        display: block !important;
    }


    /* Pastikan QR Code terlihat saat dicetak */
    #print-qrcode img {
        display: block !important;
        width: 200px !important;
        height: 200px !important;
    }

}

</style>

@endsection
