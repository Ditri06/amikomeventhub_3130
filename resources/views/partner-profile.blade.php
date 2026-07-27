@extends('layouts.app')

@section('title', $partner->name . ' - Profil Penyelenggara')

@section('content')

<main class="max-w-6xl mx-auto px-6 py-20">

    {{-- =========================
        PROFIL PENYELENGGARA
    ========================== --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 md:p-12">

        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">

            {{-- LOGO PARTNER --}}
            <div class="flex-shrink-0">

                @if($partner->logo_url)

                    <img
                        src="{{ $partner->logo_url }}"
                        alt="{{ $partner->name }}"
                        class="w-32 h-32 object-contain rounded-3xl bg-slate-50 p-5 border border-slate-100"
                    >

                @else

                    <div class="w-32 h-32 bg-indigo-100 text-indigo-600 rounded-3xl flex items-center justify-center font-black text-5xl">
                        {{ strtoupper(substr($partner->name, 0, 1)) }}
                    </div>

                @endif

            </div>


            {{-- INFORMASI PARTNER --}}
            <div class="flex-1 text-center md:text-left">

                <p class="text-sm text-indigo-600 font-bold uppercase tracking-widest mb-2">
                    Profil Penyelenggara
                </p>

                <h1 class="text-4xl md:text-5xl font-black text-slate-900">
                    {{ $partner->name }}
                </h1>

                <p class="text-slate-500 mt-3">
                    Penyelenggara berbagai event dan acara.
                </p>


                {{-- RATING --}}
                <div class="mt-6 flex flex-col sm:flex-row items-center md:items-start gap-6">

                    <div class="bg-yellow-50 rounded-2xl px-6 py-4">

                        <div class="flex items-center gap-2">

                            <span class="text-3xl font-black text-yellow-600">
                                {{ number_format($averageRating ?? 0, 1) }}
                            </span>

                            <span class="text-yellow-500 text-xl">
                                ★
                            </span>

                        </div>

                        <p class="text-sm text-slate-500 mt-1">
                            Rata-rata Rating
                        </p>

                    </div>


                    <div class="bg-indigo-50 rounded-2xl px-6 py-4">

                        <p class="text-3xl font-black text-indigo-600">
                            {{ $totalReviews }}
                        </p>

                        <p class="text-sm text-slate-500 mt-1">
                            Total Ulasan
                        </p>

                    </div>


                    <div class="bg-green-50 rounded-2xl px-6 py-4">

                        <p class="text-3xl font-black text-green-600">
                            {{ $partner->events->count() }}
                        </p>

                        <p class="text-sm text-slate-500 mt-1">
                            Event Diselenggarakan
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        EVENT PENYELENGGARA
    ========================== --}}
    <div class="mt-16">

        <div class="mb-8">

            <h2 class="text-3xl font-black text-slate-900">
                Event yang Diselenggarakan
            </h2>

            <p class="text-slate-500 mt-2">
                Lihat berbagai event yang diselenggarakan oleh {{ $partner->name }}.
            </p>

        </div>


        @if($partner->events->count() > 0)

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($partner->events as $event)

                    <a
                        href="{{ route('events.show', $event->id) }}"
                        class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition"
                    >

                        {{-- POSTER EVENT --}}
                        @if($event->poster_path)

                            <img
                                src="{{ asset('storage/' . $event->poster_path) }}"
                                alt="{{ $event->title }}"
                                class="w-full h-52 object-cover"
                            >

                        @else

                            <div class="w-full h-52 bg-slate-100 flex items-center justify-center text-slate-400">
                                Tidak Ada Poster
                            </div>

                        @endif


                        <div class="p-6">

                            <h3 class="text-xl font-black text-slate-900">
                                {{ $event->title }}
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
                            </p>

                            <p class="text-indigo-600 font-bold mt-4">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </p>

                        </div>

                    </a>

                @endforeach

            </div>

        @else

            <div class="bg-slate-50 rounded-3xl p-10 text-center">
                <p class="text-slate-500">
                    Belum ada event yang diselenggarakan.
                </p>
            </div>

        @endif

    </div>


    {{-- =========================
        TESTIMONI PEMBELI
    ========================== --}}
    <div class="mt-16">

        <div class="mb-8">

            <h2 class="text-3xl font-black text-slate-900">
                Ulasan Pembeli
            </h2>

            <p class="text-slate-500 mt-2">
                Pengalaman dan testimoni dari pembeli yang telah mengikuti event.
            </p>

        </div>


        @if($partner->reviews->count() > 0)

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @foreach($partner->reviews->sortByDesc('created_at') as $review)

                    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">

                        {{-- RATING --}}
                        <div class="flex items-center gap-1 mb-4">

                            @for($i = 1; $i <= 5; $i++)

                                @if($i <= $review->rating)

                                    <span class="text-yellow-400 text-xl">
                                        ★
                                    </span>

                                @else

                                    <span class="text-slate-300 text-xl">
                                        ★
                                    </span>

                                @endif

                            @endfor

                        </div>


                        {{-- REVIEW --}}
                        <p class="text-slate-600 leading-relaxed">
                            "{{ $review->review }}"
                        </p>


                        {{-- USER & EVENT --}}
                        <div class="mt-6 pt-5 border-t border-slate-100">

                            <p class="font-bold text-slate-900">
                                {{ $review->user->name ?? 'Pengguna' }}
                            </p>

                            <p class="text-sm text-slate-500 mt-1">
                                Mengikuti: {{ $review->event->title ?? 'Event' }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="bg-slate-50 rounded-3xl p-10 text-center">

                <p class="text-slate-500">
                    Belum ada ulasan dari pembeli.
                </p>

            </div>

        @endif

    </div>

</main>

@endsection
