@extends('layouts.admin.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#5f5b57]">Daftar Banner</h2>
        <a href="{{ route('banners.create') }}" 
           class="px-4 py-2 bg-[#e99c2e] text-white rounded-lg hover:bg-[#d68c25] transition">
           + Tambah Banner
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-md border border-[#a09e9c]/30">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8f8f8] text-[#5f5b57] uppercase text-sm">
                        <th class="px-6 py-3 font-medium border-b border-[#a09e9c]/30">Nama</th>
                        <th class="px-6 py-3 font-medium border-b border-[#a09e9c]/30">Gambar</th>
                        <th class="px-6 py-3 font-medium border-b border-[#a09e9c]/30">Deskripsi</th>
                        <th class="px-6 py-3 font-medium border-b border-[#a09e9c]/30">Diskon</th>
                        <th class="px-6 py-3 text-right font-medium border-b border-[#a09e9c]/30">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#a09e9c]/30">
                    @forelse($banners as $banner)
                        <tr class="hover:bg-[#fff8f0] transition">
                            <td class="px-6 py-3 text-[#616060]">{{ $banner->name }}</td>
                            <td class="px-6 py-3">
                                @if($banner->image)
                                    <img src="{{ asset('storage/' . $banner->image) }}" 
                                         alt="Banner" 
                                         class="w-20 h-14 object-cover rounded-lg border border-[#a09e9c]/30">
                                @else
                                    <span class="text-[#a09e9c] italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-[#616060]">
                                {{ $banner->description ?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-[#616060]">
                                {{ $banner->discount_amount ?? 0 }}%
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('banners.edit', $banner) }}" 
                                       class="px-3 py-1.5 text-sm rounded-lg bg-[#e99c2e]/80 text-white hover:bg-[#e99c2e] transition">
                                       Edit
                                    </a>
                                    <form action="{{ route('banners.destroy', $banner) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin hapus banner?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1.5 text-sm rounded-lg bg-red-500/80 text-white hover:bg-red-600 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-[#a09e9c] italic">
                                Belum ada banner.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
