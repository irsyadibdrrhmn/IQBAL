@extends('layouts.admin.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div>
    <h3 class="text-[#5f5b57] font-bold mb-3 text-xl">Dashboard</h3>
    <h6 class="text-[#a09e9c] mb-2">MEBEL ADEN SAFIRA JEPARA </h6>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-4">
    <!-- Product Card -->
    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="text-[#e99c2e] text-3xl">
            <i class="fas fa-box-open"></i>
        </div>
        <div>
            <p class="text-[#5f5b57] font-semibold">Product</p>
            <h4 class="text-[#616060] text-lg font-bold">{{ $totalProducts }}</h4>
        </div>
    </div>

    <!-- Orders Card -->
    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="text-[#e99c2e] text-3xl">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div>
            <p class="text-[#5f5b57] font-semibold">Orders</p>
            <h4 class="text-[#616060] text-lg font-bold">{{ $totalOrders }}</h4>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="text-[#e99c2e] text-3xl">
            <i class="fas fa-coins"></i>
        </div>
        <div>
            <p class="text-[#5f5b57] font-semibold">Revenue</p>
            <h4 class="text-[#616060] text-lg font-bold">
                Rp{{ number_format($totalOrder, 0, ',', '.') }}
            </h4>
        </div>
    </div>

    <!-- Users Card -->
    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="text-[#e99c2e] text-3xl">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-[#5f5b57] font-semibold">Users</p>
            <h4 class="text-[#616060] text-lg font-bold">{{ $totalUsers }}</h4>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6">
    <!-- Top Customers -->
    <div class="col-span-5 md:col-span-2 bg-white rounded-lg shadow p-4">
        <h5 class="text-[#5f5b57] font-semibold mb-3">Top 5 Pelanggan Aktif</h5>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-[#f5f5f5] text-[#5f5b57]">
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">Jumlah Order</th>
                        <th class="py-2 px-4 border-b">Total Belanja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topCustomers as $cust)
                        <tr class="text-[#616060] hover:bg-[#fff7e6]">
                            <td class="py-2 px-4 border-b">{{ $cust->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $cust->total_orders }}</td>
                            <td class="py-2 px-4 border-b">Rp{{ number_format($cust->total_spent, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="col-span-5 md:col-span-3 bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-3">
            <h5 class="text-[#5f5b57] font-semibold">Transaction History</h5>
            <div class="relative">
                <button class="text-[#616060] hover:text-[#e99c2e]">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-[#f5f5f5] text-[#5f5b57]">
                    <tr>
                        <th class="py-2 px-4 text-left">Payment Number</th>
                        <th class="py-2 px-4 text-end">Date & Time</th>
                        <th class="py-2 px-4 text-end">Amount</th>
                        <th class="py-2 px-4 text-end">Status</th>
                    </tr>
                </thead>
                <tbody class="text-[#616060]">
                    @foreach($orders as $order)
                        <tr class="hover:bg-[#fff7e6]">
                            <td class="py-2 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <button class="bg-[#e99c2e] text-white rounded-full p-1 text-xs">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    Payment from #{{ $order->midtrans_order_id }}
                                </span>
                            </td>
                            <td class="py-2 px-4 text-end">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y, h:ia') }}</td>
                            <td class="py-2 px-4 text-end">Rp{{ number_format($order->total) }}</td>
                            <td class="py-2 px-4 text-end">
                                <span class="px-2 py-1 rounded text-white {{ $order->payment_status == 'paid' ? 'bg-green-600' : 'bg-yellow-500' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-center mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
