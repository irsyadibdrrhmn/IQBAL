@extends('layouts.admin.admin')

@section('content')
    <div class="w-full px-4">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-[#fff8f0] border-b border-[#e99c2e]/30 p-5 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-[#5f5b57]">🪑 Product List</h2>

                <!-- Dropdown Header -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="bg-[#e99c2e] text-white text-sm px-3 py-2 rounded-md hover:bg-[#d68c25] transition">
                        ⋮
                    </button>
                    <div x-show="open" @click.outside="open = false"
                        class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-lg shadow-md z-50"
                        x-transition>
                        <a href="{{ route('products.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#fff4e5]">Create</a>
                        <a href="{{ route('discounts.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#fff4e5]">Discounts</a>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 text-sm text-center">{{ session('success') }}</div>
            @endif

            <!-- Body -->
            <div class="p-0 overflow-x-auto bg-[#fffaf5]">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-[#e99c2e]/20 text-[#4a4a4a] uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 font-semibold">#</th>
                            <th class="px-6 py-3 font-semibold">Image</th>
                            <th class="px-6 py-3 font-semibold">Name</th>
                            <th class="px-6 py-3 font-semibold">Category</th>
                            <th class="px-6 py-3 font-semibold">Price</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Stock</th>
                            <th class="px-6 py-3 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                            <tr class="border-b border-gray-100 hover:bg-[#fff4e5]/40 transition">
                                <td class="px-6 py-3">{{ $index + 1 }}</td>
                                <td class="px-6 py-3">
                                    @if ($product->image)
                                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="w-12 h-12 object-cover rounded-md shadow-sm">
                                    @else
                                        <span class="text-gray-400">No image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 font-medium text-[#5f5b57]">{{ $product->name }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $product->category->name ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    @if ($product->discount && $product->discount->status === 'active')
                                        <del
                                            class="text-gray-400">Rp{{ number_format($product->price, 0, ',', '.') }}</del><br>
                                        <span
                                            class="text-[#e99c2e] font-semibold">Rp{{ number_format($product->discount->final_price, 0, ',', '.') }}</span>
                                    @else
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if ($product->is_premium)
                                        <span
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Premium</span>
                                    @else
                                        <span
                                            class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium">Standar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-700">{{ $product->stock }}</td>

                                <!-- Dropdown tiap baris -->
                                <td class="px-6 py-3 text-right">
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <!-- Tombol -->
                                        <button @click="open = !open"
                                            class="bg-[#e99c2e] text-white text-sm px-3 py-1.5 rounded-md hover:bg-[#d68c25] transition">
                                            Actions
                                        </button>

                                        <!-- Dropdown -->
                                        <ul x-show="open" @click.outside="open = false" x-transition
                                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-lg shadow-md z-50">
                                            <li>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#fff4e5]">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                 >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-[#fff4e5]">
                                                        Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-6 text-gray-400">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
