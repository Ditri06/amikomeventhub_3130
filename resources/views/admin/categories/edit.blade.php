@extends('layouts.admin')

@section('content')

<div class="max-w-2xl">

    <div class="mb-8">

        <h1 class="text-3xl font-black">
            Edit Kategori
        </h1>

        <p class="text-slate-500 mt-2">
            Perbarui informasi kategori event.
        </p>

    </div>


    @if($errors->any())

        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl">

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

        <form
            action="{{ route('admin.categories.update', $category->id) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="mb-6">

                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Nama Kategori
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    required
                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                >

            </div>


            <div class="flex gap-3">

                <a
                    href="{{ route('admin.categories.index') }}"
                    class="px-6 py-3 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
