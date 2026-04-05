@extends('layouts.admin.admin')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between bg-[#f8f8f8] border-b border-[#a09e9c]/30 px-6 py-4">
            <h2 class="text-xl font-semibold text-[#5f5b57]">Daftar Kategori</h2>
            <div>
                <a href="{{ route('categories.create') }}" 
                    class="bg-[#e99c2e] text-white px-4 py-2 rounded-lg hover:bg-[#d58a20] transition">
                    + Tambah Kategori
                </a>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-6 py-3 text-sm border-b border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#a09e9c]/30">
                <thead class="bg-[#f8f8f8]">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-[#5f5b57]">#</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-[#5f5b57]">Nama Kategori</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-[#5f5b57]">Dibuat Pada</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-[#5f5b57]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#a09e9c]/20">
                    @forelse($categories as $index => $category)
                        <tr class="hover:bg-[#fdf8f3] transition">
                            <td class="px-6 py-4 text-[#616060]">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-[#616060]">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-right text-[#616060]">
                                {{ $category->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{-- Dropdown Aksi --}}
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button @click="open = !open"
                                        class="px-3 py-1 border border-[#a09e9c]/40 rounded-lg text-[#616060] hover:bg-[#e99c2e] hover:text-white transition">
                                        Aksi
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-40 bg-white border border-[#a09e9c]/30 rounded-lg shadow-lg z-10">
                                        
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="block px-4 py-2 hover:bg-[#e99c2e] hover:text-white rounded-t-lg transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full text-left px-4 py-2 hover:bg-red-500 hover:text-white rounded-b-lg transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-[#a09e9c]">Tidak ada kategori ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pastikan AlpineJS aktif --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
