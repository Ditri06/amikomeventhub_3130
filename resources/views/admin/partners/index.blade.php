@extends('layouts.admin')

@section('title', 'Partner - Admin')

@section('page_title', 'Daftar Partner')

@section('page_subtitle', 'Kelola data penyelenggara atau partner event.')

@section('content')

<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">

    <div class="flex justify-between items-center mb-8">

        <div>
            <h2 class="text-2xl font-black text-slate-800">
                Daftar Partner
            </h2>

            <p class="text-slate-500 mt-1">
                Kelola penyelenggara event yang terdaftar.
            </p>
        </div>

        <a href="{{ route('admin.partners.create') }}"
           class="px-6 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
            + Tambah Partner
        </a>

    </div>


    @if(session('success'))

        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold">
            {{ session('success') }}
        </div>

    @endif


    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b border-slate-100 text-left">

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        No
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Partner
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Email Akun
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Logo
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Event
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Status
                    </th>

                    <th class="py-4 px-4 text-sm font-bold text-slate-500">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($partners as $partner)

                    <tr class="border-b border-slate-50">

                        {{-- No --}}
                        <td class="py-4 px-4">
                            {{ $loop->iteration }}
                        </td>


                        {{-- Nama Partner --}}
                        <td class="py-4 px-4 font-bold text-slate-700">
                            {{ $partner->name }}
                        </td>


                        {{-- Email Akun --}}
                        <td class="py-4 px-4 text-slate-500">
                            {{ $partner->user->email ?? '-' }}
                        </td>


                        {{-- Logo --}}
                        <td class="py-4 px-4">

                            @if($partner->logo_url)

                                <img
                                    src="{{ $partner->logo_url }}"
                                    alt="{{ $partner->name }}"
                                    class="w-12 h-12 object-contain rounded-xl bg-slate-50 p-1"
                                >

                            @else

                                <span class="text-slate-400">
                                    Tidak ada logo
                                </span>

                            @endif

                        </td>


                        {{-- Jumlah Event --}}
                        <td class="py-4 px-4">

                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full font-bold text-sm">
                                {{ $partner->events->count() }} Event
                            </span>

                        </td>


                        {{-- Status --}}
                        <td class="py-4 px-4">

                            @if($partner->status === 'approved')

                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-bold text-sm">
                                    Disetujui
                                </span>

                            @elseif($partner->status === 'rejected')

                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full font-bold text-sm">
                                    Ditolak
                                </span>

                            @else

                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full font-bold text-sm">
                                    Menunggu
                                </span>

                            @endif

                        </td>


                        {{-- Aksi --}}
                        <td class="py-4 px-4">

                            <div class="flex flex-wrap gap-2">

                                {{-- Tombol Setujui dan Tolak --}}
                                @if($partner->status === 'pending')

                                    {{-- Setujui --}}
                                    <form
                                        action="{{ route('admin.partners.approve', $partner->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menyetujui partner ini?')"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="px-4 py-2 bg-green-100 text-green-700 rounded-xl font-bold hover:bg-green-600 hover:text-white transition"
                                        >
                                            Setujui
                                        </button>

                                    </form>


                                    {{-- Tolak --}}
                                    <form
                                        action="{{ route('admin.partners.reject', $partner->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menolak partner ini?')"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="px-4 py-2 bg-orange-100 text-orange-700 rounded-xl font-bold hover:bg-orange-600 hover:text-white transition"
                                        >
                                            Tolak
                                        </button>

                                    </form>

                                @endif


                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin.partners.edit', $partner->id) }}"
                                    class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-xl font-bold hover:bg-yellow-500 hover:text-white transition"
                                >
                                    Edit
                                </a>


                                {{-- Hapus --}}
                                <form
                                    action="{{ route('admin.partners.destroy', $partner->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus partner ini?')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-red-100 text-red-700 rounded-xl font-bold hover:bg-red-600 hover:text-white transition"
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
                            class="py-10 text-center text-slate-400"
                        >
                            Belum ada data partner.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
