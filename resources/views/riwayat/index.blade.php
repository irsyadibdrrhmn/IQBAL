@extends('layouts.admin.admin')

@section('content')
<div class="max-w-7xl mx-auto mt-10 bg-white rounded-2xl shadow-md overflow-hidden">

    {{-- Header --}}
    <div class="flex justify-between items-center px-6 py-4 border-b border-[#a09e9c]/30">
        <h2 class="text-2xl font-semibold text-[#5f5b57]">Daftar Pesanan</h2>

        {{-- Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                class="px-3 py-2 text-[#616060] border border-[#a09e9c]/40 rounded-lg hover:bg-[#e99c2e] hover:text-white transition">
                ⋮
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-40 bg-white border border-[#a09e9c]/30 rounded-lg shadow-lg z-10">
                <a href="{{ route('products.index') }}" 
                   class="block px-4 py-2 hover:bg-[#e99c2e] hover:text-white rounded-t-lg transition">Produk</a>
                <a href="{{ route('discounts.index') }}" 
                   class="block px-4 py-2 hover:bg-[#e99c2e] hover:text-white rounded-b-lg transition">Diskon</a>
            </div>
        </div>
    </div>

    {{-- Alert Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-6 py-3 border-t border-b border-green-200 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-left border-collapse">
            <thead class="bg-[#f8f8f8] border-b border-[#a09e9c]/30 text-[#5f5b57]">
                <tr>
                    <th class="px-6 py-3 font-medium">#</th>
                    <th class="px-6 py-3 font-medium">Nama</th>
                    <th class="px-6 py-3 font-medium">Produk / Bahan</th>
                    <th class="px-6 py-3 font-medium">Total</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-[#616060] divide-y divide-[#a09e9c]/20">
                @php $i = 1; @endphp
                @forelse ($orders as $order)
                    <tr class="hover:bg-[#fffaf5] transition">
                        <td class="px-6 py-4">{{ $i++ }}</td>
                        <td class="px-6 py-4">{{ $order->user->name }}</td>

                        <td class="px-6 py-4">
                            @if ($order->orderItems && $order->orderItems->isNotEmpty())
                                <ul class="space-y-1">
                                    @foreach ($order->orderItems as $item)
                                        <li class="flex items-center gap-2">
                                            <span class="text-[#e99c2e]">🏷️</span>
                                            <span>{{ $item->product->name }} – {{ $item->quantity }}x 
                                                <span class="text-[#a09e9c]">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="italic text-[#a09e9c]">Tidak ada produk</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            Rp{{ number_format($order->total, 0, ',', '.') }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-right">
                            <div x-data="{ open: false }" class="relative inline-block">
                                <button @click="open = !open"
                                    class="px-3 py-1 border border-[#a09e9c]/40 rounded-lg text-[#616060] hover:bg-[#e99c2e] hover:text-white transition">
                                    Aksi
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-40 bg-white border border-[#a09e9c]/30 rounded-lg shadow-lg z-10">
                                    <a href="{{ route('orders.show', $order->id) }}"
                                        class="block px-4 py-2 hover:bg-[#e99c2e] hover:text-white rounded-t-lg transition">
                                        👁️ Lihat
                                    </a>
                                    {{-- Uncomment jika ingin menambah hapus
                                    <form action="{{ route('order.destroy.admin', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 hover:bg-red-500 hover:text-white rounded-b-lg transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                    --}}
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-[#a09e9c] italic">
                            Tidak ada pesanan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-[#a09e9c]/20 flex justify-end">
        {{ $orders->links() }}
    </div>
</div>
@endsection
