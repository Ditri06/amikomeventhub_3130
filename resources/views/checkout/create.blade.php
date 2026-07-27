@extends('layouts.app')

@section('title', 'Checkout - ' . $event->title)

@section('content')

<main class="max-w-3xl mx-auto px-6 py-20">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div class="mb-12">

        <a
            href="{{ route('events.show', $event->id) }}"
            class="text-indigo-600 font-bold flex items-center gap-2 mb-6"
        >

            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                ></path>

            </svg>

            Kembali ke Event

        </a>


        <h1 class="text-4xl font-extrabold">
            Checkout
        </h1>


        <p class="text-slate-500 mt-2">
            Lengkapi data Anda untuk mendapatkan tiket.
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- PESAN ERROR --}}
    {{-- ===================================================== --}}

    @if(session('error'))

        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl font-bold">
            {{ session('error') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- PESAN SUKSES --}}
    {{-- ===================================================== --}}

    @if(session('success'))

        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl font-bold">
            {{ session('success') }}
        </div>

    @endif


    <div class="grid grid-cols-1 gap-8">


        {{-- ===================================================== --}}
        {{-- DETAIL PESANAN --}}
        {{-- ===================================================== --}}

        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">

            <h3 class="text-xl font-bold mb-6 border-b pb-4">
                Pesanan Anda
            </h3>


            {{-- DETAIL EVENT --}}

            <div class="flex gap-6 items-start">

                <img
                    src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                        ? asset('storage/' . $event->poster_path)
                        : 'https://placehold.co/200x200' }}"
                    alt="Event"
                    class="w-24 h-24 rounded-2xl object-cover"
                >


                <div>

                    <h4 class="font-extrabold text-lg">
                        {{ $event->title }}
                    </h4>


                    <p class="text-slate-500">

                        {{ $event->date->format('d M Y') }}

                        •

                        {{ $event->location }}

                    </p>


                    <p class="text-indigo-600 font-bold mt-2">

                        1 x Rp
                        {{ number_format($eventPrice, 0, ',', '.') }}

                    </p>
                </div>

            </div>


            {{-- ================================================= --}}
            {{-- KODE KUPON --}}
            {{-- ================================================= --}}

           @if($eventPrice > 0)

                <div class="mt-8 pt-6 border-t">

                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">

                        Kode Kupon

                    </label>


                    <div class="flex gap-3">

                        <input
                            type="text"
                            id="coupon_code"
                            name="coupon_code"
                            form="checkout-form"
                            value="{{ old('coupon_code') }}"
                            placeholder="Masukkan kode kupon"
                            class="flex-1 px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium uppercase"
                        >


                        <button
                            type="button"
                            id="apply-coupon"
                            class="px-6 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition"
                        >

                            Terapkan

                        </button>

                    </div>


                    {{-- PESAN KUPON --}}

                    <p
                        id="coupon-message"
                        class="text-xs mt-3 font-bold hidden"
                    ></p>


                    <p class="text-xs text-slate-400 mt-2">

                        Masukkan kode kupon jika Anda memiliki kupon diskon.

                    </p>

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- RINGKASAN HARGA --}}
            {{-- ================================================= --}}

            <div class="mt-8 pt-6 border-t space-y-3">


                {{-- HARGA TIKET --}}

                <div class="flex justify-between text-slate-500">

                    <span>
                        Harga Tiket
                    </span>


                    <span>

                        Rp
                        {{ number_format($eventPrice, 0, ',', '.') }}

                    </span>
                </div>


                {{-- DISKON --}}

                <div class="flex justify-between text-slate-500">

                    <span>
                        Diskon Kupon
                    </span>


                    <span
                        id="discount-display"
                        class="text-green-600 font-bold"
                    >

                        Rp 0

                    </span>

                </div>


                {{-- BIAYA LAYANAN --}}

                <div class="flex justify-between text-slate-500">

                    <span>
                        Biaya Layanan
                    </span>


                   <span>

                    Rp
                    {{ number_format($eventPrice > 0 ? 5000 : 0, 0, ',', '.') }}

                </span>

                </div>


                {{-- TOTAL BAYAR --}}

                <div class="flex justify-between text-2xl font-black mt-4 pt-4 border-t">

                    <span>
                        Total Bayar
                    </span>


                    <span
                        id="total-display"
                        class="text-indigo-600"
                    >

                        Rp
                       {{ number_format(
                        $eventPrice > 0
                            ? $eventPrice + 5000
                            : 0,
                        0,
                        ',',
                        '.'
                    ) }}

                    </span>

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- DATA PEMESAN --}}
        {{-- ===================================================== --}}

            <h3 class="text-xl font-bold mb-6 flex items-center gap-3 text-indigo-600">

            <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                ></path>
            </svg>

            Data Pemesan

        </h3>

            <form
                id="checkout-form"
                action="{{ route('checkout.store', $event->id) }}"
                method="POST"
                class="space-y-6"
            >

                @csrf


                {{-- ================================================= --}}
                {{-- NAMA LENGKAP --}}
                {{-- ================================================= --}}

                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">

                        Nama Lengkap

                    </label>


                    <input
                        type="text"
                        name="customer_name"
                        placeholder="Masukkan nama sesuai identitas"
                        class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                        required
                        value="{{ old('customer_name', Auth::user()->name) }}"
                    >

                </div>


                {{-- ================================================= --}}
                {{-- EMAIL DAN WHATSAPP --}}
                {{-- ================================================= --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    {{-- EMAIL --}}

                    <div>

                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">

                            Email Aktif

                        </label>


                        <input
                            type="email"
                            name="customer_email"
                            placeholder="contoh@gmail.com"
                            class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            required
                            value="{{ old('customer_email', Auth::user()->email) }}"
                        >


                        <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tighter">

                            *E-Ticket akan dikirim ke email ini

                        </p>

                    </div>


                    {{-- WHATSAPP --}}

                    <div>

                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">

                            No. WhatsApp

                        </label>


                        <input
                            type="tel"
                            name="customer_phone"
                            placeholder="08xxxxxxx"
                            class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            required
                            value="{{ old('customer_phone') }}"
                        >

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- TOMBOL PEMBAYARAN --}}
                {{-- ================================================= --}}

                <button
                    type="submit"
                    class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all"
                >

                    Lanjut Pembayaran

                </button>


                <p class="text-center text-xs text-slate-400">

                    Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan kami.

                </p>

            </form>

        </div>

    </div>

</main>



{{-- ========================================================= --}}
{{-- JAVASCRIPT KUPON --}}
{{-- ========================================================= --}}

@if($eventPrice > 0)

<script>

    /*
    |--------------------------------------------------------------------------
    | DATA KUPON
    |--------------------------------------------------------------------------
    */

    const coupons = @json($coupons ?? []);

    const eventPrice = {{ $eventPrice }};

    const serviceFee = 5000;

    const subtotal = eventPrice + serviceFee;


    /*
    |--------------------------------------------------------------------------
    | ELEMENT HTML
    |--------------------------------------------------------------------------
    */

    const couponInput = document.getElementById('coupon_code');

    const applyCouponButton = document.getElementById('apply-coupon');

    const couponMessage = document.getElementById('coupon-message');

    const discountDisplay = document.getElementById('discount-display');

    const totalDisplay = document.getElementById('total-display');


    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */

    function formatRupiah(number) {

        return 'Rp ' + Number(number).toLocaleString('id-ID');

    }


    /*
    |--------------------------------------------------------------------------
    | TERAPKAN KUPON
    |--------------------------------------------------------------------------
    */

    applyCouponButton.addEventListener('click', function () {

        const code = couponInput.value.trim().toUpperCase();


        /*
        | Jika kode kosong
        */

        if (code === '') {

            couponMessage.textContent =
                'Silakan masukkan kode kupon terlebih dahulu.';

            couponMessage.classList.remove(
                'hidden',
                'text-green-600'
            );

            couponMessage.classList.add(
                'text-red-500'
            );

            discountDisplay.textContent = 'Rp 0';

            totalDisplay.textContent =
                formatRupiah(subtotal);

            return;

        }


        /*
        | Cari kupon
        */

        const coupon = coupons.find(function (item) {

            return item.code.toUpperCase() === code;

        });


        /*
        | Kupon tidak ditemukan
        */

        if (!coupon) {

            couponMessage.textContent =
                'Kode kupon tidak ditemukan.';

            couponMessage.classList.remove(
                'hidden',
                'text-green-600'
            );

            couponMessage.classList.add(
                'text-red-500'
            );

            discountDisplay.textContent = 'Rp 0';

            totalDisplay.textContent =
                formatRupiah(subtotal);

            return;

        }


        /*
        | Cek kupon aktif
        */

        if (!coupon.is_active) {

            couponMessage.textContent =
                'Kupon yang digunakan sudah tidak aktif.';

            couponMessage.classList.remove(
                'hidden',
                'text-green-600'
            );

            couponMessage.classList.add(
                'text-red-500'
            );

            discountDisplay.textContent = 'Rp 0';

            totalDisplay.textContent =
                formatRupiah(subtotal);

            return;

        }


        /*
        | Cek tanggal mulai
        */

        const now = new Date();


        if (
            coupon.start_date &&
            new Date(coupon.start_date) > now
        ) {

            couponMessage.textContent =
                'Kupon belum mulai berlaku.';

            couponMessage.classList.remove(
                'hidden',
                'text-green-600'
            );

            couponMessage.classList.add(
                'text-red-500'
            );

            discountDisplay.textContent = 'Rp 0';

            totalDisplay.textContent =
                formatRupiah(subtotal);

            return;

        }


        /*
        | Cek tanggal berakhir
        */

        if (
            coupon.end_date &&
            new Date(coupon.end_date) < now
        ) {

            couponMessage.textContent =
                'Kupon sudah tidak berlaku.';

            couponMessage.classList.remove(
                'hidden',
                'text-green-600'
            );

            couponMessage.classList.add(
                'text-red-500'
            );

            discountDisplay.textContent = 'Rp 0';

            totalDisplay.textContent =
                formatRupiah(subtotal);

            return;

        }


        /*
        | Cek maksimal penggunaan
        */

        if (
            coupon.max_usage !== null &&
            coupon.used_count >= coupon.max_usage
        ) {

            couponMessage.textContent =
                'Kuota penggunaan kupon sudah habis.';

            couponMessage.classList.remove(
                'hidden',
                'text-green-600'
            );

            couponMessage.classList.add(
                'text-red-500'
            );

            discountDisplay.textContent = 'Rp 0';

            totalDisplay.textContent =
                formatRupiah(subtotal);

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG DISKON
        |--------------------------------------------------------------------------
        */

        let discountAmount = 0;


        /*
        | Diskon persentase
        */

        if (coupon.discount_type === 'percentage') {

            const percentage = Math.min(
                Number(coupon.discount_value),
                100
            );

            discountAmount =
                subtotal * percentage / 100;

        }


        /*
        | Diskon nominal tetap
        */

        else if (coupon.discount_type === 'fixed') {

            discountAmount =
                Number(coupon.discount_value);

        }


        /*
        | Diskon tidak boleh lebih besar dari subtotal
        */

        discountAmount = Math.min(
            discountAmount,
            subtotal
        );


        /*
        | Bulatkan angka
        */

        discountAmount = Math.floor(
            discountAmount
        );


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL AKHIR
        |--------------------------------------------------------------------------
        */

        const totalPrice = Math.max(
            0,
            subtotal - discountAmount
        );


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN HASIL
        |--------------------------------------------------------------------------
        */

        discountDisplay.textContent =
            formatRupiah(discountAmount);


        totalDisplay.textContent =
            formatRupiah(totalPrice);


        /*
        |--------------------------------------------------------------------------
        | PESAN BERHASIL
        |--------------------------------------------------------------------------
        */

        couponMessage.textContent =
            'Kupon berhasil diterapkan. Anda mendapatkan diskon ' +
            formatRupiah(discountAmount) +
            '.';


        couponMessage.classList.remove(
            'hidden',
            'text-red-500'
        );


        couponMessage.classList.add(
            'text-green-600'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | ENTER DI INPUT KUPON
    |--------------------------------------------------------------------------
    */

    couponInput.addEventListener('keydown', function (event) {

        if (event.key === 'Enter') {

            event.preventDefault();

            applyCouponButton.click();

        }

    });

</script>

@endif

@endsection
