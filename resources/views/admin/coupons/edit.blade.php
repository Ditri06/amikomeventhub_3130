@extends('layouts.admin')

@section('content')

<div class="max-w-3xl">

    <div class="mb-8">
        <h1 class="text-3xl font-black">Edit Kupon</h1>
        <p class="text-slate-500 mt-1">
            Perbarui informasi kupon.
        </p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        KODE KUPON
                    </label>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code', $coupon->code) }}"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none uppercase"
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
                            <option value="percentage"
                                {{ $coupon->discount_type === 'percentage' ? 'selected' : '' }}>
                                Persentase (%)
                            </option>

                            <option value="fixed"
                                {{ $coupon->discount_type === 'fixed' ? 'selected' : '' }}>
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
                            value="{{ old('discount_value', $coupon->discount_value) }}"
                            min="1"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                            required
                        >
                    </div>

                </div>


                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        MAKSIMAL PENGGUNAAN
                    </label>

                    <input
                        type="number"
                        name="max_usage"
                        value="{{ old('max_usage', $coupon->max_usage) }}"
                        min="1"
                        placeholder="Kosongkan jika tidak dibatasi"
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
                            value="{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d\TH:i') : '' }}"
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
                            value="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d\TH:i') : '' }}"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:border-indigo-600 outline-none"
                        >
                    </div>

                </div>


                <div class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ $coupon->is_active ? 'checked' : '' }}
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
                        Update Kupon
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
