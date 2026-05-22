@extends('layouts.admin')

@section('content')

<div class="mb-10">
    <!-- judul atas -->
     <h1 class="text-3xl font-black">
            Manajemen Partner
        </h1>

    <br>


    <div class="flex justify-between items-center mb-6">

    <form method="GET"
        action="{{ route('admin.partners.index') }}"
        class="flex gap-2">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari partner..."
            class="border px-4 py-3 rounded-xl w-72">

        <button
            type="submit"
            class="px-5 py-3 bg-slate-800 text-white rounded-xl font-bold">

            Cari

        </button>

    </form>


        <!-- BUTTON TAMBAH -->
        <button
            onclick="document.getElementById('modalCreate').classList.remove('hidden')"
            class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">

            + Tambah Partner

        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <table class="w-full text-left border-collapse">

            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">

                <tr>
                    <th class="px-8 py-4">No</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Nama Partner</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>

            </thead>

            <tbody class="divide-y border-t">

                @foreach($partners as $index => $partner)

                <tr class="hover:bg-slate-50">

                    <td class="px-8 py-6 font-bold">
                        {{ $index + 1 }}
                    </td>

                    <td class="px-8 py-6">

                       @if($partner->logo_url)

    <img src="{{ asset('storage/' . $partner->logo_url) }}"
        class="w-24 h-24 object-contain bg-white p-2 rounded-xl border">

@else

                            <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xs">
                                No Logo
                            </div>

                        @endif

                    </td>

                    <td class="px-8 py-6 font-bold">
                        {{ $partner->name }}
                    </td>

                    <td class="px-8 py-6 text-center space-x-2">

                        <!-- EDIT -->
                    <button
                        onclick="openEdit(
                            {{ $partner->id }},
                            '{{ $partner->name }}'
                        )"

                        class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-bold hover:bg-indigo-100 transition">

                        Edit

                    </button>

                        <!-- DELETE -->
                        <form
                            action="{{ route('admin.partners.destroy', $partner->id) }}"
                            method="POST"
                            class="inline">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus partner ini?')"
                                class="px-4 py-2 bg-rose-50 text-rose-600 rounded-lg text-sm font-bold hover:bg-rose-100 transition">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach
                @if($partners->isEmpty())
                <tr>
                    <td colspan="4" class="text-center py-8 text-slate-400">
                        Data partner tidak ditemukan
                    </td>
                </tr>
                @endif

            </tbody>

        </table>

    </div>
</div>

<!-- =========================
     MODAL CREATE
========================= -->
<div id="modalCreate"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-2xl w-96">

        <h2 class="text-xl font-bold mb-4">
            Tambah Partner
        </h2>

        <form action="{{ route('admin.partners.store') }}"
    method="POST"
    enctype="multipart/form-data">

            @csrf

            <input
                type="text"
                name="name"
                placeholder="Nama Partner"
                class="w-full border p-3 rounded-xl mb-4">

           <input
    type="file"
    name="logo"
    class="w-full border p-3 rounded-xl mb-4">

            <div class="flex justify-end gap-2">

                <button
                    type="button"
                    onclick="document.getElementById('modalCreate').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-200 rounded-xl">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-xl">

                    Simpan

                </button>

            </div>

        </form>

    </div>
</div>

<!-- =========================
     MODAL EDIT
========================= -->
<div id="modalEdit"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-2xl w-96">

        <h2 class="text-xl font-bold mb-4">
            Edit Partner
        </h2>

        <form id="editForm"
    method="POST"
    enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <input
                type="text"
                name="name"
                id="editName"
                class="w-full border p-3 rounded-xl mb-4">

            <input
    type="file"
    name="logo"
    class="w-full border p-3 rounded-xl mb-4">

            <div class="flex justify-end gap-2">

                <button
                    type="button"
                    onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-200 rounded-xl">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-xl">

                    Update

                </button>

            </div>

        </form>

    </div>
</div>

<!-- =========================
     SCRIPT EDIT
========================= -->
<script>

function openEdit(id, name)
{
    document.getElementById('modalEdit')
        .classList.remove('hidden');

    document.getElementById('editName').value = name;

    document.getElementById('editForm').action =
        "/admin/partners/" + id;
}

</script>

@endsection
