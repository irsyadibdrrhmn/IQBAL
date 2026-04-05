@extends('layouts.admin.admin')

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 w-full">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-[#5f5b57]">Order List</h2>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-[#616060] text-center">
                    <tr>
                        <th class="px-4 py-2 font-semibold">#</th>
                        <th class="px-4 py-2 font-semibold">Name</th>
                        {{-- <th class="px-4 py-2 font-semibold">Products</th> --}}
                        {{-- <th class="px-4 py-2 font-semibold">Note</th> --}}
                        <th class="px-4 py-2 font-semibold">Total</th>
                        <th class="px-4 py-2 font-semibold">Resi</th>
                        <th class="px-4 py-2 font-semibold">Status Pembayaran</th>
                        <th class="px-4 py-2 font-semibold">Status</th>
                        <th class="px-4 py-2 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-[#616060]">
                    @forelse ($orders as $index => $order)
                        <tr class="hover:bg-gray-50 text-center">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $order->user->name }}</td>

                            <!-- Products -->
                            {{-- <td class="px-4 py-2 text-left">
                                @if ($order->orderItems && $order->orderItems->isNotEmpty())
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($order->orderItems as $item)
                                            <li>
                                                {{ $item->product->name ?? 'Nama Produk Tidak Tersedia' }} -
                                                {{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}
                                                @if(optional($item->product)->is_premium)
                                                    <span class="text-red-600 font-semibold">(Premium)</span>
                                                @endif

                                                @if($item->bundle)
                                                    <ul class="list-disc list-inside ml-4 text-[#a09e9c]">
                                                        @foreach ($item->bundle->products as $bundledProduct)
                                                            <li>
                                                                {{ $bundledProduct->name }} -
                                                                Rp{{ number_format($bundledProduct->price, 0, ',', '.') }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-[#a09e9c] italic">No products</span>
                                @endif
                            </td> --}}

                            {{-- <td class="px-4 py-2">{{ $order->note }}</td> --}}
                            <td class="px-4 py-2">Rp{{ number_format($order->total, 0, ',', '.') }}</td>

                            <!-- Resi -->
                            <td class="px-4 py-2">
                                <form action="{{ route('orders.updateResi', $order->id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input 
                                        type="text" 
                                        name="resi" 
                                        value="{{ $order->resi }}" 
                                        placeholder="Input Resi"
                                        class="w-40 border border-gray-300 rounded-full px-3 py-1 text-sm focus:ring-2 focus:ring-[#e99c2e] outline-none"
                                    >
                                    <button type="submit" class="bg-[#e99c2e] text-white rounded-full px-3 py-1 text-sm hover:bg-[#d48b23] transition">
                                        Save
                                    </button>
                                </form>
                            </td>

                            <!-- Payment Status -->
                            <td class="px-4 py-2">
                                @php
                                    $color = match($order->payment_status) {
                                        'paid' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        default => ($order->status == 'shipped' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800'),
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst($order->payment_status == 'paid' ? 'Paid' : ($order->payment_status == 'failed' ? 'Failed' : $order->status)) }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-2">
                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select 
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="border border-gray-300 rounded-full text-sm px-2 py-1 focus:ring-2 focus:ring-[#e99c2e] outline-none"
                                    >
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="accepted" {{ $order->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-2 text-right relative">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button @click="open = !open" class="bg-[#e99c2e] text-white text-sm px-3 py-1 rounded-full hover:bg-[#d48b23] transition">
                                        Actions
                                    </button>
                                    <div 
                                        x-show="open"
                                        @click.away="open = false"
                                        class="absolute right-0 mt-2 w-28 bg-white border border-gray-100 rounded-lg shadow-lg z-10"
                                    >
                                        <a href="{{ route('orders.show', $order->id) }}" class="block px-3 py-2 text-sm hover:bg-gray-50 text-[#616060]">
                                            View
                                        </a>
                                        <form action="{{ route('order.destroy', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-[#a09e9c] py-4">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center py-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
