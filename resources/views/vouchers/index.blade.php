@extends('layouts.admin.admin')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-6">
    <h2 class="text-2xl font-semibold mb-6 text-[#5f5b57]">Daftar Voucher</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol tambah voucher --}}
    <a href="{{ route('vouchers.create') }}" 
        class="inline-block mb-5 px-4 py-2 rounded-lg bg-[#e99c2e] text-white font-medium hover:bg-[#d68b1f] transition">
        + Tambah Voucher
    </a>

    {{-- Tabel daftar voucher --}}
    <div class="overflow-x-auto bg-white rounded-2xl shadow border border-[#a09e9c]/30">
        <table class="min-w-full text-left text-sm text-[#616060]">
            <thead class="bg-[#f9f9f9] border-b border-[#a09e9c]/30 text-[#5f5b57]">
                <tr>
                    <th class="py-3 px-4 font-semibold">Kode</th>
                    <th class="py-3 px-4 font-semibold">Diskon</th>
                    <th class="py-3 px-4 font-semibold">Tipe</th>
                    <th class="py-3 px-4 font-semibold">Kadaluarsa</th>
                    <th class="py-3 px-4 font-semibold">Status</th>
                    <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $voucher)
                    <tr class="border-b border-[#a09e9c]/30 hover:bg-[#fff7ed] transition">
                        <td class="py-3 px-4 font-medium text-[#5f5b57]">{{ $voucher->code }}</td>
                        <td class="py-3 px-4">{{ $voucher->discount_value }}</td>
                        <td class="py-3 px-4">{{ ucfirst($voucher->discount_type) }}</td>
                        <td class="py-3 px-4">
                            {{ $voucher->expires_at ? $voucher->expires_at->format('d M Y') : '-' }}
                        </td>
                        <td class="py-3 px-4">
                            @if($voucher->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Aktif
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- Tombol Aksi --}}
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center gap-2 flex-wrap">
                                <a href="{{ route('vouchers.edit', $voucher) }}" 
                                    class="px-3 py-1 text-sm rounded-md bg-[#e99c2e]/10 text-[#e99c2e] font-medium hover:bg-[#e99c2e]/20 transition">
                                    Edit
                                </a>

                                <form action="{{ route('vouchers.toggle', $voucher->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                        class="px-3 py-1 text-sm rounded-md font-medium 
                                        {{ $voucher->is_active ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} 
                                        transition">
                                        {{ $voucher->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('vouchers.destroy', $voucher) }}" method="POST" 
                                      onsubmit="return confirm('Yakin hapus voucher ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="px-3 py-1 text-sm rounded-md bg-red-100 text-red-700 font-medium hover:bg-red-200 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-[#a09e9c] italic">
                            Belum ada voucher
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
