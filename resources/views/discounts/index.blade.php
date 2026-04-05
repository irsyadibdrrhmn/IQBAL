@extends('layouts.admin.admin')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-md">
    <div class="flex justify-between items-center border-b border-[#a09e9c]/30 pb-4 mb-4">
        <h2 class="text-xl font-semibold text-[#5f5b57]">Daftar Diskon</h2>

        <!-- Dropdown Menu -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="px-4 py-2 text-[#616060] bg-[#f9f9f9] hover:bg-[#e99c2e] hover:text-white rounded-lg transition">
                Menu
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-40 bg-white border border-[#a09e9c]/30 rounded-lg shadow-lg z-10">
                <a href="{{ route('discounts.create') }}" class="block px-4 py-2 text-[#616060] hover:bg-[#e99c2e] hover:text-white rounded-t-lg">
                    Tambah Diskon
                </a>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border border-[#a09e9c]/30 text-sm">
            <thead class="bg-[#f7f7f7] text-[#5f5b57]">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Nama Promo</th>
                    <th class="px-4 py-2 text-left">Produk</th>
                    <th class="px-4 py-2 text-left">Nilai</th>
                    <th class="px-4 py-2 text-left">Harga Setelah Diskon</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($discounts as $i => $d)
                <tr class="border-t border-[#a09e9c]/20 hover:bg-[#fdfaf7] transition">
                    <td class="px-4 py-2 text-[#616060]">{{ $i + 1 }}</td>
                    <td class="px-4 py-2 text-[#616060]">{{ $d->promo_name }}</td>
                    <td class="px-4 py-2 text-[#616060]">{{ $d->product->name ?? '-' }}</td>
                    <td class="px-4 py-2 text-[#616060]">
                        @if($d->discount_type == 'percent')
                            {{ $d->discount_value }}%
                        @else
                            Rp {{ number_format($d->discount_value) }}
                        @endif
                    </td>
                    <td class="px-4 py-2 text-[#616060]">Rp {{ number_format($d->final_price) }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded-lg text-xs font-medium 
                            {{ $d->status == 'active' ? 'bg-[#e99c2e]/20 text-[#e99c2e]' : 'bg-[#a09e9c]/20 text-[#616060]' }}">
                            {{ ucfirst($d->status) }}
                        </span>
                    </td>
              <td class="px-4 py-2 text-right align-top">
    <div x-data="{ open: false }" class="relative inline-block text-left">
        <!-- Tombol Dropdown -->
        <button @click="open = !open"
            class="px-3 py-1 border border-[#a09e9c]/40 rounded-lg text-[#616060] hover:bg-[#e99c2e] hover:text-white transition font-medium focus:outline-none">
            Aksi
        </button>

        <!-- Isi Dropdown -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-1"
             @click.away="open = false"
             class="absolute right-0 mt-2 w-44 bg-white border border-[#a09e9c]/30 rounded-xl shadow-lg overflow-hidden z-50">
             
            <!-- Toggle Status -->
            <form action="{{ route('discounts.toggle', $d->id) }}" method="POST" class="block">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-[#5f5b57] hover:bg-[#e99c2e] hover:text-white transition">
                    {{ $d->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>

            <!-- Edit -->
            <a href="{{ route('discounts.edit', $d->id) }}"
                class="block px-4 py-2 text-sm text-[#5f5b57] hover:bg-[#e99c2e] hover:text-white transition">
                Edit
            </a>

            <!-- Hapus -->
            <form action="{{ route('discounts.destroy', $d->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus diskon ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-500 hover:text-white transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-[#a09e9c] italic">
                        Belum ada diskon.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Tambahkan Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
