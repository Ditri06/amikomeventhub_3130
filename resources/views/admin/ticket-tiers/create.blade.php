@extends('layouts.admin')

@section('content')

<div class="max-w-3xl">

    <div class="mb-8">

        <h1 class="text-3xl font-black">
            Tambah Ticket Tier
        </h1>

        <p class="text-slate-500 mt-1">
            Tambahkan tahapan harga tiket untuk sebuah event.
        </p>

    </div>


    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

        <form
            action="{{ route('admin.ticket-tiers.store') }}"
            method="POST"
        >

            @csrf


            <div class="space-y-6">


                {{-- EVENT --}}

                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        EVENT
                    </label>

                    <select
                        name="event_id"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                        required
                    >

                        <option value="">
                            -- Pilih Event --
                        </option>

                        @foreach($events as $event)

                            <option
                                value="{{ $event->id }}"
                                {{ old('event_id') == $event->id ? 'selected' : '' }}
                            >
                                {{ $event->title }}
                            </option>

                        @endforeach

                    </select>

                    @error('event_id')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- NAMA TIER --}}

                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        NAMA TIER
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Early Bird"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                        required
                    >

                    <p class="text-xs text-slate-400 mt-2">
                        Contoh: Early Bird, Presale 1, Presale 2, atau Regular.
                    </p>

                    @error('name')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- HARGA --}}

                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        HARGA TIKET
                    </label>

                    <input
                        type="number"
                        name="price"
                        value="{{ old('price') }}"
                        placeholder="Contoh: 100000"
                        min="0"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                        required
                    >

                    <p class="text-xs text-slate-400 mt-2">
                        Masukkan harga dalam Rupiah.
                    </p>

                    @error('price')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- TANGGAL --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    <div>

                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            MULAI BERLAKU
                        </label>

                        <input
                            type="datetime-local"
                            name="start_date"
                            value="{{ old('start_date') }}"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                            required
                        >

                        @error('start_date')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            BERAKHIR
                        </label>

                        <input
                            type="datetime-local"
                            name="end_date"
                            value="{{ old('end_date') }}"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                            required
                        >

                        @error('end_date')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- URUTAN --}}

                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        URUTAN TIER
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', 1) }}"
                        min="1"
                        placeholder="Contoh: 1"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                        required
                    >

                    <p class="text-xs text-slate-400 mt-2">
                        Contoh: Early Bird = 1, Presale 1 = 2, Regular = 3.
                    </p>

                    @error('sort_order')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- BUTTON --}}

                <div class="flex gap-4 pt-4">

                    <a
                        href="{{ route('admin.ticket-tiers.index') }}"
                        class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700"
                    >
                        Simpan Ticket Tier
                    </button>

                </div>


            </div>

        </form>

    </div>

</div>

@endsection
