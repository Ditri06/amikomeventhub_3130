@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-black">
                Ticket Tier
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola tahapan harga tiket berdasarkan periode penjualan.
            </p>
        </div>

        <a
            href="{{ route('admin.ticket-tiers.create') }}"
            class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition"
        >
            + Tambah Ticket Tier
        </a>

    </div>


    {{-- PESAN SUKSES --}}

    @if(session('success'))

        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl font-bold">
            {{ session('success') }}
        </div>

    @endif


    {{-- TABEL --}}

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                            Event
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                            Nama Tier
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                            Harga
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-600">
                            Periode
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-bold text-slate-600">
                            Urutan
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-bold text-slate-600">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($ticketTiers as $index => $ticketTier)

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-5 text-slate-500">
                                {{ $ticketTiers->firstItem() + $index }}
                            </td>


                            <td class="px-6 py-5">

                                <p class="font-bold text-slate-800">
                                    {{ $ticketTier->event->title ?? '-' }}
                                </p>

                            </td>


                            <td class="px-6 py-5">

                                <span class="inline-flex px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold">
                                    {{ $ticketTier->name }}
                                </span>

                            </td>


                            <td class="px-6 py-5">

                                <span class="font-bold text-slate-800">
                                    Rp {{ number_format($ticketTier->price, 0, ',', '.') }}
                                </span>

                            </td>


                            <td class="px-6 py-5 text-sm text-slate-500">

                                <div>
                                    {{ $ticketTier->start_date
                                        ? $ticketTier->start_date->format('d M Y H:i')
                                        : '-'
                                    }}
                                </div>

                                <div class="mt-1">
                                    s/d
                                    {{ $ticketTier->end_date
                                        ? $ticketTier->end_date->format('d M Y H:i')
                                        : '-'
                                    }}
                                </div>

                            </td>


                            <td class="px-6 py-5 text-center">

                                <span class="font-bold text-slate-700">
                                    {{ $ticketTier->sort_order }}
                                </span>

                            </td>


                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    <a
                                        href="{{ route('admin.ticket-tiers.edit', $ticketTier) }}"
                                        class="px-4 py-2 bg-amber-100 text-amber-700 rounded-lg font-bold hover:bg-amber-200 transition"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.ticket-tiers.destroy', $ticketTier) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus ticket tier ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-bold hover:bg-red-200 transition"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-12 text-center text-slate-500"
                            >
                                Belum ada ticket tier.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($ticketTiers->hasPages())

            <div class="p-6 border-t border-slate-100">
                {{ $ticketTiers->links() }}
            </div>

        @endif

    </div>

</div>

@endsection
