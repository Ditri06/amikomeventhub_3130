@extends('layouts.app')

@section('title', $event->title)

@section('content')

@php
    // Ambil Ticket Tier yang sedang aktif
    $activeTicketTier = $event->ticketTiers
        ->filter(function ($tier) {
            return $tier->start_date <= now() && $tier->end_date >= now();
        })
        ->sortBy('sort_order')
        ->first();

    // Gunakan harga Ticket Tier aktif
    // Jika tidak ada, gunakan harga event
    $eventPrice = $activeTicketTier
        ? $activeTicketTier->price
        : $event->price;
@endphp

<main class="max-w-7xl mx-auto px-6 py-20">

    {{-- =========================
        BAGIAN DETAIL EVENT
    ========================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">

        {{-- BAGIAN GAMBAR --}}
        <div class="relative">

            @if($event->poster_path)
                <img
                    src="{{ asset('storage/' . $event->poster_path) }}"
                    alt="{{ $event->title }}"
                    class="rounded-[2rem] shadow-2xl w-full object-cover aspect-[4/5] object-center"
                >
            @else
                <img
                    src="https://placehold.co/600x750"
                    alt="{{ $event->title }}"
                    class="rounded-[2rem] shadow-2xl w-full object-cover aspect-[4/5] object-center"
                >
            @endif

            {{-- STATUS PEMBAYARAN --}}
            <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl z-20 border border-slate-100">
                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">
                            Terverifikasi
                        </p>

                        <p class="font-bold">
                            Pembayaran Aman via Midtrans
                        </p>
                    </div>

                </div>
            </div>

        </div>


        {{-- =========================
            INFORMASI EVENT
        ========================== --}}
        <div class="lg:col-span-2 space-y-12">

            {{-- JUDUL DAN INFORMASI --}}
            <div class="space-y-4">

                {{-- KATEGORI --}}
                <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                    {{ $event->category->name ?? 'Event' }}
                </span>

                {{-- JUDUL --}}
                <h1 class="text-5xl font-black">
                    {{ $event->title }}
                </h1>

                {{-- INFORMASI EVENT --}}
                <div class="flex flex-wrap gap-6 text-slate-500 font-medium">

                    {{-- TANGGAL --}}
                    <div class="flex items-center gap-2">

                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>

                        <span>
                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
                        </span>

                    </div>


                    {{-- LOKASI --}}
                    <div class="flex items-center gap-2">

                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>

                        <span>
                            {{ $event->location ?? 'Amikom' }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- =========================
                DESKRIPSI EVENT
            ========================== --}}
            <div class="prose prose-slate max-w-none">

                <h3 class="text-2xl font-bold mb-4">
                    Deskripsi Event
                </h3>

                <p class="text-lg text-slate-600 leading-relaxed">
                    {{ $event->description }}
                </p>

            </div>


            {{-- =========================
                PENYELENGGARA / PARTNER
            ========================== --}}
            @if(isset($event->partner))

                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">

                    <p class="text-sm text-slate-500 font-bold uppercase mb-3">
                        Diselenggarakan Oleh
                    </p>

                    <div class="flex items-center gap-4">

                        @if($event->partner->logo_url)

                         <img
                            src="{{ $event->partner->logo_url }}"
                            alt="{{ $event->partner->name }}"
                            class="w-14 h-14 object-contain rounded-xl bg-white p-2"
                            onerror="this.style.display='none';"
                        >

                        @else

                            <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xl">
                                {{ strtoupper(substr($event->partner->name, 0, 1)) }}
                            </div>

                        @endif

                        <div>

                        <a
                            href="{{ route('partner.show', $event->partner->id) }}"
                            class="font-bold text-lg text-slate-900 hover:text-indigo-600 transition"
                        >
                            {{ $event->partner->name }}
                        </a>
                            <p class="text-sm text-slate-500">
                                Penyelenggara Event
                            </p>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =========================
                HARGA DAN CHECKOUT
            ========================== --}}
            <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden">

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">

                    <div>

                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">
                            Harga Tiket
                        </p>

                 <h2 class="text-5xl font-black">

                    Rp {{ number_format($eventPrice, 0, ',', '.') }}

                    <span class="text-lg font-medium text-indigo-200">
                        /orang
                    </span>

                </h2>

                        <p class="mt-4 text-indigo-100 flex items-center gap-2">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>

                            Sisa stok:

                            <span class="font-bold underline">
                                {{ $event->stock }} Tiket lagi!
                            </span>

                        </p>

                    </div>


                    {{-- TOMBOL PESAN --}}
                    <div>

                        @if($event->stock > 0)

                            <a
                                href="{{ route('checkout.create', $event->id) }}"
                                class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl"
                            >
                                Pesan Sekarang
                            </a>

                        @else

                            <button
                                disabled
                                class="px-10 py-5 bg-slate-300 text-slate-500 rounded-2xl font-black text-xl cursor-not-allowed"
                            >
                                Tiket Habis
                            </button>

                        @endif

                    </div>

                </div>

                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>

                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>

            </div>


            {{-- =========================
                KEBIJAKAN TIKET
            ========================== --}}
            <div class="space-y-4">

                <h3 class="text-xl font-bold">
                    Kebijakan Tiket
                </h3>

                <ul class="space-y-3 text-slate-500">

                    <li class="flex items-start gap-2">

                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7">
                            </path>
                        </svg>

                        E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.

                    </li>

                    <li class="flex items-start gap-2">

                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7">
                            </path>
                        </svg>

                        Tiket dapat discan di pintu masuk (Check-in).

                    </li>

                    <li class="flex items-start gap-2 text-rose-500">

                        <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>

                        Tiket yang sudah dibeli tidak dapat direfund.

                    </li>

                </ul>

            </div>

        </div>

    </div>


    {{-- =====================================================
        BAGIAN RATING & REVIEW
    ====================================================== --}}

    <div class="mt-24 border-t border-slate-200 pt-16">

        <div class="max-w-5xl mx-auto">

            {{-- JUDUL REVIEW --}}
            <div class="text-center mb-12">

                <h2 class="text-3xl font-black text-slate-900">
                    Rating & Review
                </h2>

                <p class="text-slate-500 mt-2">
                    Bagikan pengalaman Anda setelah mengikuti event ini.
                </p>

            </div>


            {{-- RINGKASAN RATING --}}
            <div class="bg-slate-50 rounded-3xl p-8 mb-10">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

                    {{-- RATING RATA-RATA --}}
                    <div class="text-center">

                        @php
                            $averageRating = $event->reviews->avg('rating') ?? 0;
                            $totalReviews = $event->reviews->count();
                        @endphp

                        <div class="text-5xl font-black text-indigo-600">
                            {{ number_format($averageRating, 1) }}
                        </div>

                        <div class="flex justify-center gap-1 mt-3">

                            @for($i = 1; $i <= 5; $i++)

                                @if($i <= round($averageRating))

                                    <span class="text-yellow-400 text-2xl">
                                        ★
                                    </span>

                                @else

                                    <span class="text-slate-300 text-2xl">
                                        ★
                                    </span>

                                @endif

                            @endfor

                        </div>

                        <p class="text-sm text-slate-500 mt-2">
                            Berdasarkan {{ $totalReviews }} ulasan
                        </p>

                    </div>


                    {{-- INFO REVIEW --}}
                    <div>

                        <h3 class="font-bold text-xl mb-3">
                            Bagaimana pengalaman Anda?
                        </h3>

                        <p class="text-slate-500 leading-relaxed">
                            Setelah mengikuti event, Anda dapat memberikan penilaian
                            dari 1 sampai 5 bintang dan menuliskan pengalaman Anda.
                        </p>

                    </div>

                </div>

            </div>


            {{-- FORM REVIEW --}}
            @auth

                <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm mb-10">

                    <h3 class="text-xl font-bold mb-6">
                        Tulis Review Anda
                    </h3>

                    <form
                        action="{{ route('reviews.store', $event->id) }}"
                        method="POST"
                        class="space-y-6"
                    >

                        @csrf

                        {{-- RATING --}}
                        <div>

                            <label class="block text-sm font-bold text-slate-700 mb-3">
                                Berikan Rating
                            </label>

                            <div class="flex gap-3">

                                @for($i = 1; $i <= 5; $i++)

                                    <label class="cursor-pointer">

                                        <input
                                            type="radio"
                                            name="rating"
                                            value="{{ $i }}"
                                            class="hidden peer"
                                            required
                                        >

                                        <span class="text-4xl text-slate-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition">
                                            ★
                                        </span>

                                    </label>

                                @endfor

                            </div>

                        </div>


                        {{-- KOMENTAR --}}
                        <div>

                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Testimoni / Review
                            </label>

                            <textarea
                                name="review"
                                rows="5"
                                placeholder="Ceritakan pengalaman Anda mengikuti event ini..."
                                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition"
                                required
                            >{{ old('comment') }}</textarea>

                        </div>


                        <button
                            type="submit"
                            class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition"
                        >
                            Kirim Review
                        </button>

                    </form>

                </div>

            @else

                <div class="bg-indigo-50 rounded-3xl p-8 text-center mb-10">

                    <h3 class="font-bold text-xl text-indigo-900">
                        Ingin memberikan review?
                    </h3>

                    <p class="text-indigo-700 mt-2">
                        Silakan login terlebih dahulu untuk memberikan rating dan review.
                    </p>

                    <a
                        href="{{ route('login') }}"
                        class="inline-block mt-5 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"
                    >
                        Login
                    </a>

                </div>

            @endauth


            {{-- DAFTAR REVIEW --}}
            <div class="space-y-6">

                <h3 class="text-2xl font-black">
                    Ulasan Pengguna
                </h3>

                @forelse($event->reviews as $review)

                    <div class="bg-white border border-slate-200 rounded-3xl p-6">

                        <div class="flex justify-between items-start gap-4">

                            <div>

                                <h4 class="font-bold text-lg">
                                    {{ $review->user->name ?? 'Pengguna' }}
                                </h4>

                                <div class="flex gap-1 mt-1">

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <= $review->rating)

                                            <span class="text-yellow-400">
                                                ★
                                            </span>

                                        @else

                                            <span class="text-slate-300">
                                                ★
                                            </span>

                                        @endif

                                    @endfor

                                </div>

                            </div>

                            <span class="text-sm text-slate-400">
                                {{ $review->created_at->format('d M Y') }}
                            </span>

                        </div>

                        <p class="mt-4 text-slate-600 leading-relaxed">
                            {{ $review->comment }}
                        </p>

                    </div>

                @empty

                    <div class="text-center py-10 bg-slate-50 rounded-3xl">

                        <p class="text-slate-500">
                            Belum ada ulasan untuk event ini.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</main>

@endsection
