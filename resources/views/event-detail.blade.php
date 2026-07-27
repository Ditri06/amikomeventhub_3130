@extends('layouts.app')
@section('content')

    <main class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-3 gap-16">

        {{-- Bagian Gambar --}}
        <div class="relative">
            {{-- Pastikan nama kolom gambar sesuai, misal: $event->image --}}
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="rounded-[2rem] shadow-2xl w-full object-cover aspect-[4/5] object-center">

            {{-- Div ini sebelumnya terpotong, sekarang sudah dirapikan --}}
            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white bg-white/80 backdrop-blur">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-12">
            <div class="space-y-4">
                {{-- Kategori Dinamis --}}
                <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                    {{ $event->category->name ?? 'Event' }}
                </span>

                {{-- Judul Dinamis --}}
                <h1 class="text-5xl font-black">{{ $event->title }}</h1>

                <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{-- Tanggal Dinamis --}}
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{-- Lokasi (Jika ada di database Anda) --}}
                        <span>{{ $event->location ?? 'Amikom' }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-slate max-w-none">
                <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
                {{-- Deskripsi Dinamis (Sudah dirapikan, stock dipindah ke bawah) --}}
                <p class="text-lg text-slate-600 leading-relaxed">
                    {{ $event->description }}
                </p>
            </div>

            <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>

                        {{-- Harga Dinamis --}}
                        <h2 class="text-5xl font-black">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                            <span class="text-lg font-medium text-indigo-200">/orang</span>
                        </h2>

                        <p class="mt-4 text-indigo-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{-- Stok Dinamis ditempatkan di sini --}}
                            Sisa stok: <span class="font-bold underline">{{ $event->stock ?? 0 }} Tiket lagi!</span>
                        </p>
                    </div>
                    <div>
                        {{-- Route Dinamis --}}
                        <a href="{{ route('checkout.create', $event->id) }}"
                            class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
                <ul class="space-y-3 text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tiket dapat discan di pintu masuk (Check-in).
                    </li>
                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tiket yang sudah dibeli tidak dapat direfund.
                    </li>
                </ul>
            </div>
            @extends('layouts.app')
@section('content')

    <main class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-3 gap-16">

        {{-- Bagian Gambar --}}
        <div class="relative">
            {{-- Pastikan nama kolom gambar sesuai, misal: $event->image --}}
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="rounded-[2rem] shadow-2xl w-full object-cover aspect-[4/5] object-center">

            {{-- Div ini sebelumnya terpotong, sekarang sudah dirapikan --}}
            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white bg-white/80 backdrop-blur">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-12">
            <div class="space-y-4">
                {{-- Kategori Dinamis --}}
                <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                    {{ $event->category->name ?? 'Event' }}
                </span>

                {{-- Judul Dinamis --}}
                <h1 class="text-5xl font-black">{{ $event->title }}</h1>

                <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{-- Tanggal Dinamis --}}
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{-- Lokasi (Jika ada di database Anda) --}}
                        <span>{{ $event->location ?? 'Amikom' }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-slate max-w-none">
                <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
                {{-- Deskripsi Dinamis (Sudah dirapikan, stock dipindah ke bawah) --}}
                <p class="text-lg text-slate-600 leading-relaxed">
                    {{ $event->description }}
                </p>
            </div>

            <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>

                        {{-- Harga Dinamis --}}
                        <h2 class="text-5xl font-black">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                            <span class="text-lg font-medium text-indigo-200">/orang</span>
                        </h2>

                        <p class="mt-4 text-indigo-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{-- Stok Dinamis ditempatkan di sini --}}
                            Sisa stok: <span class="font-bold underline">{{ $event->stock ?? 0 }} Tiket lagi!</span>
                        </p>
                    </div>
                    <div>
                        {{-- Route Dinamis --}}
                        <a href="{{ route('checkout.create', $event->id) }}"
                            class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
                <ul class="space-y-3 text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tiket dapat discan di pintu masuk (Check-in).
                    </li>
                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tiket yang sudah dibeli tidak dapat direfund.
                    </li>
                </ul>
                {{-- Rating & Review --}}
            <div class="space-y-6 mt-12">

                <div>
                    <h3 class="text-2xl font-bold">Rating & Review</h3>
                    <p class="text-slate-500 mt-2">
                        Bagikan pengalaman Anda setelah mengikuti event ini.
                    </p>
                </div>

                {{-- Pesan sukses --}}
                @if(session('success'))
                    <div class="p-4 bg-green-100 text-green-700 rounded-xl font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Pesan error --}}
                @if(session('error'))
                    <div class="p-4 bg-red-100 text-red-700 rounded-xl font-bold">
                        {{ session('error') }}
                    </div>
                @endif

                @auth

                    {{-- Form Review --}}
                    @if($event->date->copy()->addDay()->isPast())

                        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">

                            <h4 class="text-xl font-bold mb-6">
                                Berikan Penilaian Anda
                            </h4>

                            <form action="{{ route('reviews.store', $event->id) }}" method="POST">
                                @csrf

                                {{-- Rating --}}
                                <div class="mb-6">

                                    <label class="block text-sm font-bold text-slate-700 mb-3">
                                        Rating
                                    </label>

                                    <select name="rating"
                                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl"
                                        required>

                                        <option value="">Pilih Rating</option>
                                        <option value="5">★★★★★ - Sangat Baik</option>
                                        <option value="4">★★★★☆ - Baik</option>
                                        <option value="3">★★★☆☆ - Cukup</option>
                                        <option value="2">★★☆☆☆ - Kurang</option>
                                        <option value="1">★☆☆☆☆ - Sangat Kurang</option>

                                    </select>

                                </div>

                                {{-- Testimoni --}}
                                <div class="mb-6">

                                    <label class="block text-sm font-bold text-slate-700 mb-3">
                                        Testimoni
                                    </label>

                                    <textarea
                                        name="review"
                                        rows="5"
                                        placeholder="Ceritakan pengalaman Anda mengikuti event ini..."
                                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl"
                                    >{{ old('review') }}</textarea>

                                </div>

                                <button type="submit"
                                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
                                    Kirim Review
                                </button>

                            </form>

                        </div>

                    @else

                        <div class="bg-slate-50 rounded-3xl p-6 text-slate-500">
                            Rating dan review dapat diberikan satu hari setelah event selesai.
                        </div>

                    @endif

                @else

                    <div class="bg-slate-50 rounded-3xl p-6 text-slate-500">
                        Silakan login dengan Google terlebih dahulu untuk memberikan rating dan review.
                    </div>

                @endauth

            </div>
                        </div>
                    </div>
                </main>

            @endsection

        </div>
    </main>

@endsection
