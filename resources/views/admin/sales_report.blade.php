@extends('layouts.admin.admin')

@section('content')
<div class="container mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">📊 Laporan Penjualan</h2>

    {{-- Statistik Singkat --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white shadow rounded-xl p-5 border border-gray-100">
            <small class="text-gray-500">Total Produk</small>
            <h5 class="text-lg font-semibold text-gray-800 mt-1">{{ $totalProducts }}</h5>
        </div>
        <div class="bg-white shadow rounded-xl p-5 border border-gray-100">
            <small class="text-gray-500">Total Order</small>
            <h5 class="text-lg font-semibold text-gray-800 mt-1">{{ $totalOrders }}</h5>
        </div>
        <div class="bg-white shadow rounded-xl p-5 border border-gray-100">
            <small class="text-gray-500">Total Pendapatan</small>
            <h5 class="text-lg font-semibold text-gray-800 mt-1">Rp{{ number_format($totalOrder, 0, ',', '.') }}</h5>
        </div>
    </div>

    {{-- Top Produk & Pelanggan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Top Produk Terlaris --}}
        <div class="bg-white shadow rounded-xl p-5 border border-gray-100">
            <h5 class="text-lg font-semibold text-gray-800 mb-4">Top 5 Produk Terlaris</h5>
            <ul class="divide-y divide-gray-100">
                @foreach($topProducts as $product)
                    <li class="flex justify-between items-center py-2">
                        <span class="text-gray-700">{{ $product->name }}</span>
                        <span class="bg-green-100 text-green-700 text-sm font-semibold px-3 py-1 rounded-full">
                            {{ $product->total_sold }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Top Pelanggan Aktif --}}
        <div class="bg-white shadow rounded-xl p-5 border border-gray-100">
            <h5 class="text-lg font-semibold text-gray-800 mb-4">Top 5 Pelanggan Aktif</h5>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">Nama</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">Jumlah Order</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">Total Belanja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topCustomers as $cust)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-gray-700">{{ $cust->name }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $cust->total_orders }}</td>
                            <td class="px-4 py-2 text-gray-700">Rp{{ number_format($cust->total_spent, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div>
            <label for="period" class="block text-sm font-medium text-gray-600 mb-1">Periode</label>
            <select name="period" id="period" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-300 focus:border-pink-400">
                <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Harian</option>
                <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Tahunan</option>
            </select>
        </div>

        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-600 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" id="start_date"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-300 focus:border-pink-400"
                value="{{ $startDate }}">
        </div>

        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-600 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" id="end_date"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-pink-300 focus:border-pink-400"
                value="{{ $endDate }}">
        </div>

        <div class="flex items-end">
            <button type="submit"
                class="w-full bg-[#fff0f5] hover:bg-pink-100 text-gray-700 font-semibold py-2 px-4 rounded-lg shadow-sm transition-all">
                Filter
            </button>
        </div>

        <div class="flex items-end">
            <a href="{{ route('sales.print') }}"
               class="w-full bg-[#fff0f5] hover:bg-pink-100 text-gray-700 font-semibold py-2 px-4 rounded-lg shadow-sm text-center transition-all">
               Print
            </a>
        </div>
    </form>

    {{-- Tabel Penjualan --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-100">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Produk</th>
                    <th class="px-4 py-3 text-right font-semibold">Jumlah Terjual</th>
                    <th class="px-4 py-3 text-right font-semibold">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr class="border-b hover:bg-pink-50 transition">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($sale->period)->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">{{ $sale->item_name }}</td>
                    <td class="px-4 py-2 text-right">{{ $sale->total_quantity_sold }}</td>
                    <td class="px-4 py-2 text-right">Rp{{ number_format($sale->total_revenue, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-400">Tidak ada data penjualan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
