@extends('layouts.admin')

@section('content')

<div class="mb-10">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-black">
                Manajemen Kategori
            </h1>

            <p class="text-slate-500 mt-2">
                Kelola kategori event yang tersedia.
            </p>
        </div>

        <a
            href="{{ route('admin.categories.create') }}"
            class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"
        >
            + Tambah Kategori
        </a>

    </div>


    {{-- PESAN SUKSES --}}
    @if(session('success'))

        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl font-bold">
            {{ session('success') }}
        </div>

    @endif


    {{-- PESAN ERROR --}}
    @if(session('error'))

        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl font-bold">
            {{ session('error') }}
        </div>

    @endif


    {{-- ERROR VALIDASI --}}
    @if($errors->any())

        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl">

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <table class="w-full text-left border-collapse">

            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">

                <tr>

                    <th class="px-8 py-4">
                        No
                    </th>

                    <th class="px-8 py-4">
                        Nama Kategori
                    </th>

                    <th class="px-8 py-4">
                        Slug
                    </th>

                    <th class="px-8 py-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y border-t">

                @forelse($categories as $category)

                    <tr class="hover:bg-slate-50">

                        <td class="px-8 py-6">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-8 py-6 font-bold">
                            {{ $category->name }}
                        </td>

                        <td class="px-8 py-6 text-slate-500">
                            {{ $category->slug }}
                        </td>

                        <td class="px-8 py-6 text-center">

                            <a
                                href="{{ route('admin.categories.edit', $category->id) }}"
                                class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-bold hover:bg-indigo-100 transition mr-2"
                            >
                                Edit
                            </a>


                            <form
                                action="{{ route('admin.categories.destroy', $category->id) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-rose-50 text-rose-600 rounded-lg text-sm font-bold hover:bg-rose-100 transition"
                                >
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="px-8 py-10 text-center text-slate-400"
                        >
                            Belum ada kategori.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
