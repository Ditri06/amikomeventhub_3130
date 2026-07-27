@extends('layouts.admin')

@section('title', 'Event Saya - Partner')

@section('page_title', 'Event Saya')

@section('page_subtitle', 'Kelola event yang diselenggarakan oleh Anda.')

@section('content')

<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">

        <div>
            <h2 class="text-2xl font-black text-slate-800">
                Daftar Event Saya
            </h2>

            <p class="text-slate-500 mt-1">
                Kelola event yang Anda selenggarakan.
            </p>
        </div>

        <a href="{{ route('partner.events.create') }}"
           class="px-6 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
            + Tambah Event
        </a>

    </div>


    {{-- Pesan Sukses --}}
    @if(session('success'))

        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold">
            {{ session('success') }}
        </div>

    @endif


    {{-- Tabel Event --}}
    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b border-slate-100 text-left">

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        No
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Nama Event
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Kategori
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Tanggal
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Harga
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Stok
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($events as $event)

                    <tr class="border-b border-slate-50">

                        <td class="py-4 px-4">
                            {{ $events->firstItem() + $loop->index }}
                        </td>

                        <td class="py-4 px-4 font-bold text-slate-700">
                            {{ $event->title }}
                        </td>

                        <td class="py-4 px-4 text-slate-500">
                            {{ $event->category->name ?? '-' }}
                        </td>

                        <td class="py-4 px-4 text-slate-500">
                            {{ $event->date->format('d M Y, H:i') }}
                        </td>

                        <td class="py-4 px-4 font-medium">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        </td>

                        <td class="py-4 px-4">
                            {{ $event->stock }}
                        </td>

                        <td class="py-4 px-4">

                            <div class="flex gap-2">

                                <a href="{{ route('partner.events.edit', $event->id) }}"
                                   class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-xl font-bold">
                                    Edit
                                </a>

                                <form action="{{ route('partner.events.destroy', $event->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus event ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-4 py-2 bg-red-100 text-red-700 rounded-xl font-bold">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="py-10 text-center text-slate-400">

                            Belum ada event yang dibuat.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    <div class="mt-6">
        {{ $events->links() }}
    </div>

</div>

@endsection
