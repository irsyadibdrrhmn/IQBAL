@extends('layouts.admin.admin')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-white rounded-2xl shadow-md border border-[#a09e9c]/30">
        <!-- Header -->
        <div class="border-b border-[#a09e9c]/30 px-6 py-4">
            <h2 class="text-xl font-semibold text-[#5f5b57]">Edit Discount</h2>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-5">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('discounts.update', $discount->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Promo Name -->
                <div>
                    <label for="promo_name" class="block text-[#5f5b57] font-medium mb-1">Promo Name</label>
                    <input type="text" id="promo_name" name="promo_name"
                        value="{{ old('promo_name', $discount->promo_name) }}"
                        class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]" required>
                </div>

                <!-- Product -->
                <div>
                    <label for="product_id" class="block text-[#5f5b57] font-medium mb-1">Product</label>
                    <select id="product_id" name="product_id"
                        class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] bg-white focus:outline-none focus:ring-2 focus:ring-[#e99c2e]" required>
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == $discount->product_id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Discount Type -->
                <div>
                    <label for="discount_type" class="block text-[#5f5b57] font-medium mb-1">Discount Type</label>
                    <select id="discount_type" name="discount_type"
                        class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] bg-white focus:outline-none focus:ring-2 focus:ring-[#e99c2e]" required>
                        <option value="percent" {{ $discount->discount_type == 'percent' ? 'selected' : '' }}>Percent (%)</option>
                        <option value="fixed" {{ $discount->discount_type == 'fixed' ? 'selected' : '' }}>Fixed (Rp)</option>
                    </select>
                </div>

                <!-- Discount Value -->
                <div>
                    <label for="discount_value" class="block text-[#5f5b57] font-medium mb-1">Discount Value</label>
                    <input type="number" id="discount_value" name="discount_value"
                        value="{{ old('discount_value', $discount->discount_value) }}" min="0"
                        class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]" required>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-[#5f5b57] font-medium mb-1">Status</label>
                    <select id="status" name="status"
                        class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] bg-white focus:outline-none focus:ring-2 focus:ring-[#e99c2e]" required>
                        <option value="active" {{ $discount->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $discount->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('discounts.index') }}"
                       class="px-4 py-2 border border-[#a09e9c]/40 rounded-lg text-[#616060] hover:bg-[#a09e9c]/20 transition">
                        Back
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-[#e99c2e] text-white rounded-lg hover:bg-[#d68c24] transition">
                        Update Discount
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
