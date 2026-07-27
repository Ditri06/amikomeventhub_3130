@extends('layouts.admin')

@section('title', 'Kelola Kupon - Admin')

@section('page_title', 'Kelola Kupon')

@section('page_subtitle', 'Kelola kode kupon dan diskon untuk event.')

@section('content')



    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl font-bold">
            {{ session('success') }}
        </div>
    @endif

   <a href="{{ route('admin.coupons.create') }}"
           class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
            + Tambah Kupon
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <table class="w-full text-left border-collapse">

            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">No</th>
                    <th class="px-8 py-4">Kode Kupon</th>
                    <th class="px-8 py-4">Diskon</th>
                    <th class="px-8 py-4">Penggunaan</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y border-t">

                @forelse($coupons as $coupon)

                <tr class="hover:bg-slate-50">

                    <td class="px-8 py-6">
                        {{ $coupons->firstItem() + $loop->index }}
                    </td>

                    <td class="px-8 py-6">
                        <span class="font-black text-indigo-600">
                            {{ $coupon->code }}
                        </span>
                    </td>

                    <td class="px-8 py-6 font-bold">

                        @if($coupon->discount_type === 'percentage')

                            {{ $coupon->discount_value }}%

                        @else

                            Rp {{ number_format($coupon->discount_value, 0, ',', '.') }}

                        @endif

                    </td>

                    <td class="px-8 py-6">

                        {{ $coupon->used_count }}

                        @if($coupon->max_usage)
                            / {{ $coupon->max_usage }}
                        @else
                            / ∞
                        @endif

                    </td>

                    <td class="px-8 py-6">

                        @if($coupon->is_active)

                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                Aktif
                            </span>

                        @else

                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                Nonaktif
                            </span>

                        @endif

                    </td>

                    <td class="px-8 py-6 text-center">

                        <a href="{{ route('admin.coupons.edit', $coupon) }}"
                           class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-bold hover:bg-indigo-100 transition mr-2">
                            Edit
                        </a>

                        <form action="{{ route('admin.coupons.destroy', $coupon) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus kupon ini?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-4 py-2 bg-rose-50 text-rose-600 rounded-lg text-sm font-bold hover:bg-rose-100 transition">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-400">
                        Belum ada kupon yang tersedia.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">
        {{ $coupons->links() }}
    </div>

</div>

@endsection
