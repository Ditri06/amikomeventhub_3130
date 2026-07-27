@extends('layouts.admin')

@section('title', 'Tambah Event - Partner')

@section('page_title', 'Tambah Event')

@section('page_subtitle', 'Buat event baru yang akan diselenggarakan oleh Anda.')

@section('content')

<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm max-w-4xl">

    <form action="{{ route('partner.events.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf

        {{-- Kategori --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Kategori Event
            </label>

            <select
                name="category_id"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required
            >
                <option value="">-- Pilih Kategori --</option>

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>

            @error('category_id')
                <span class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </span>
            @enderror
        </div>


        {{-- Nama Event --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Nama Event
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="Masukkan nama event"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required
            >

            @error('title')
                <span class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </span>
            @enderror
        </div>


        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Deskripsi Event
            </label>

            <textarea
                name="description"
                rows="5"
                placeholder="Jelaskan tentang event yang akan diselenggarakan"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required
            >{{ old('description') }}</textarea>

            @error('description')
                <span class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </span>
            @enderror
        </div>


        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Tanggal dan Waktu Event
            </label>

            <input
                type="datetime-local"
                name="date"
                value="{{ old('date') }}"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required
            >

            @error('date')
                <span class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </span>
            @enderror
        </div>


        {{-- Lokasi --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Lokasi
            </label>

            <input
                type="text"
                name="location"
                value="{{ old('location') }}"
                placeholder="Contoh: Gedung Serbaguna Amikom"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required
            >

            @error('location')
                <span class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </span>
            @enderror
        </div>


        {{-- Harga dan Stok --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                    Harga Tiket
                </label>

                <input
                    type="number"
                    name="price"
                    value="{{ old('price') }}"
                    min="0"
                    placeholder="Contoh: 50000"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                    required
                >

                @error('price')
                    <span class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </span>
                @enderror
            </div>


            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                    Stok Tiket
                </label>

                <input
                    type="number"
                    name="stock"
                    value="{{ old('stock') }}"
                    min="0"
                    placeholder="Contoh: 100"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                    required
                >

                @error('stock')
                    <span class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </span>
                @enderror
            </div>

        </div>


        {{-- Poster --}}
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Poster Event
            </label>

            <input
                type="file"
                name="poster"
                accept=".jpg,.jpeg,.png"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
            >

            <p class="text-xs text-slate-400 mt-2">
                Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 2 MB.
            </p>

            @error('poster')
                <span class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </span>
            @enderror
        </div>


        {{-- Tombol --}}
        <div class="pt-4 flex justify-end gap-4 border-t border-slate-100">

            <a
                href="{{ route('partner.events.index') }}"
                class="px-6 py-4 text-slate-500 font-bold hover:text-slate-800 transition"
            >
                Batal
            </a>

            <button
                type="submit"
                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition"
            >
                Simpan Event
            </button>

        </div>

    </form>

</div>

@endsection
