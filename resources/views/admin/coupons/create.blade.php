@extends('layouts.admin')

@section('content')

<div class="max-w-3xl">

    <div class="mb-8">
        <h1 class="text-3xl font-black">Tambah Kupon</h1>
        <p class="text-slate-500 mt-1">
            Buat kode kupon baru untuk digunakan pelanggan.
        </p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

        <form action="{{ route('admin.coupons.store') }}" method="POST">

            @csrf

            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        KODE KUPON
                    </label>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code') }}"
                        placeholder="Contoh: EVENT2026"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none uppercase"
                        required
                    >

                    @error('code')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            JENIS DISKON
                        </label>

                        <select
                            name="discount_type"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                            required
                        >
                            <option value="percentage">
                                Persentase (%)
                            </option>

                            <option value="fixed">
                                Nominal (Rp)
                            </option>
                        </select>
                    </div>


                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            NILAI DISKON
                        </label>

                        <input
                            type="number"
                            name="discount_value"
                            value="{{ old('discount_value') }}"
                            placeholder="Contoh: 10"
                            min="1"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                            required
                        >

                        @error('discount_value')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        MAKSIMAL PENGGUNAAN
                    </label>

                    <input
                        type="number"
                        name="max_usage"
                        value="{{ old('max_usage') }}"
                        placeholder="Kosongkan jika tidak dibatasi"
                        min="1"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                    >
                </div>


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
                        >
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
                        >
                    </div>

                </div>


                <div class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked
                        class="w-5 h-5 text-indigo-600 rounded"
                    >

                    <label class="font-bold text-slate-700">
                        Kupon Aktif
                    </label>

                </div>


                <div class="flex gap-4 pt-4">

                    <a
                        href="{{ route('admin.coupons.index') }}"
                        class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700"
                    >
                        Simpan Kupon
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
