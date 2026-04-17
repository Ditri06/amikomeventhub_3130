@extends('layouts.app')

@section('content')

<main class="max-w-3xl mx-auto px-6 py-20">

    <!-- Header -->
    <div class="mb-12">
        <a href="/event" class="text-indigo-600 font-bold flex items-center gap-2 mb-6">
            ← Kembali ke Event
        </a>

        <h1 class="text-4xl font-extrabold">Checkout</h1>
        <p class="text-slate-500 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
    </div>

    <div class="grid grid-cols-1 gap-8">

        <!-- Summary -->
        <div class="bg-white rounded-3xl border p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-6 border-b pb-4">Pesanan Anda</h3>

            <div class="flex gap-6 items-start">
                <img src="/assets/concert.png" class="w-24 h-24 rounded-2xl object-cover">

                <div>
                    <h4 class="font-bold text-lg">Jazz Night 2024</h4>
                    <p class="text-slate-500">16 Nov 2024</p>
                    <p class="text-indigo-600 font-bold mt-2">1 x Rp 150.000</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t space-y-3">
                <div class="flex justify-between">
                    <span>Harga Tiket</span>
                    <span>Rp 150.000</span>
                </div>

                <div class="flex justify-between">
                    <span>Biaya Layanan</span>
                    <span>Rp 5.000</span>
                </div>

                <div class="flex justify-between text-xl font-bold border-t pt-4">
                    <span>Total</span>
                    <span class="text-indigo-600">Rp 155.000</span>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-3xl border p-8 shadow-sm">

            <h3 class="text-xl font-bold mb-6 text-indigo-600">
                Data Pemesan
            </h3>

            <form class="space-y-6">

                <input type="text" placeholder="Nama Lengkap"
                    class="w-full p-4 border rounded-xl" required>

                <input type="email" placeholder="Email"
                    class="w-full p-4 border rounded-xl" required>

                <input type="tel" placeholder="No WhatsApp"
                    class="w-full p-4 border rounded-xl" required>

                <button type="button" onclick="showMidtrans()"
                    class="w-full py-4 bg-indigo-600 text-white rounded-xl font-bold">
                    Bayar Sekarang
                </button>

            </form>
        </div>

    </div>

</main>

<!-- Overlay Midtrans -->
<div id="midtrans-overlay"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center">

    <div class="bg-white p-8 rounded-2xl text-center">
        <h2 class="text-2xl font-bold mb-4">Pembayaran</h2>
        <p>Total: Rp 155.000</p>

        <button onclick="window.location.href='/ticket'"
            class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-xl">
            Bayar (Simulasi)
        </button>

        <button onclick="hideMidtrans()"
            class="block mt-4 text-sm text-slate-500">
            Batal
        </button>
    </div>

</div>

<script>
    function showMidtrans() {
        document.getElementById('midtrans-overlay').classList.remove('hidden');
        document.getElementById('midtrans-overlay').classList.add('flex');
    }

    function hideMidtrans() {
        document.getElementById('midtrans-overlay').classList.add('hidden');
        document.getElementById('midtrans-overlay').classList.remove('flex');
    }
</script>

@endsection
