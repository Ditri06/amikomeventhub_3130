@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-black">Kelola Event</h1>
    <p class="text-slate-500">Daftar semua event yang tersedia</p>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="font-bold text-xl">Daftar Event</h3>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold">
            + Tambah Event
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-400 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4">Nama Event</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <tr>
                    <td class="px-6 py-4 font-bold">Jazz Night 2024</td>
                    <td class="px-6 py-4">16 Nov 2024</td>
                    <td class="px-6 py-4 text-indigo-600 font-bold">Rp 150.000</td>
                    <td class="px-6 py-4">
                        <button class="text-blue-600 font-bold">Edit</button>
                        <button class="text-red-600 font-bold ml-3">Hapus</button>
                    </td>
                </tr>

                <tr>
                    <td class="px-6 py-4 font-bold">AI Workshop</td>
                    <td class="px-6 py-4">26 Oct 2024</td>
                    <td class="px-6 py-4 text-indigo-600 font-bold">Rp 50.000</td>
                    <td class="px-6 py-4">
                        <button class="text-blue-600 font-bold">Edit</button>
                        <button class="text-red-600 font-bold ml-3">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
