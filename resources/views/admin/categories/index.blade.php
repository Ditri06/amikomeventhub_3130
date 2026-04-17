@extends('layouts.admin')

@section('content')

<div class="mb-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-black">Manajemen Kategori</h1>
        <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
            + Tambah Kategori
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">No</th>
                    <th class="px-8 py-4">Nama Kategori</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">

                <!-- Dummy Data -->
                <tr class="hover:bg-slate-50">
                    <td class="px-8 py-6">1</td>
                    <td class="px-8 py-6 font-bold">Seminar</td>
                    <td class="px-8 py-6 text-center space-x-2">
                        <button class="px-4 py-2 bg-yellow-400 text-white rounded-lg font-bold">Edit</button>
                        <button class="px-4 py-2 bg-red-500 text-white rounded-lg font-bold">Hapus</button>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-8 py-6">2</td>
                    <td class="px-8 py-6 font-bold">Konser</td>
                    <td class="px-8 py-6 text-center space-x-2">
                        <button class="px-4 py-2 bg-yellow-400 text-white rounded-lg font-bold">Edit</button>
                        <button class="px-4 py-2 bg-red-500 text-white rounded-lg font-bold">Hapus</button>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-8 py-6">3</td>
                    <td class="px-8 py-6 font-bold">Workshop</td>
                    <td class="px-8 py-6 text-center space-x-2">
                        <button class="px-4 py-2 bg-yellow-400 text-white rounded-lg font-bold">Edit</button>
                        <button class="px-4 py-2 bg-red-500 text-white rounded-lg font-bold">Hapus</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

@endsection
