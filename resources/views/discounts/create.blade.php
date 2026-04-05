@extends('layouts.admin.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-md p-8">
    <h2 class="text-2xl font-semibold text-[#5f5b57] border-b border-[#a09e9c]/30 pb-3 mb-6">
        Buat Promo Diskon
    </h2>

    <form action="{{ route('discounts.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Nama Promo -->
        <div>
            <label class="block text-[#616060] font-medium mb-1">Nama Promo</label>
            <input type="text" name="promo_name"
                class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 focus:outline-none focus:border-[#e99c2e] focus:ring-1 focus:ring-[#e99c2e]"
                required>
        </div>

        <!-- Pilih Produk -->
        <div>
            <label class="block text-[#616060] font-medium mb-1">Pilih Produk</label>
            <select name="product_id"
                class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 bg-white text-[#616060] focus:outline-none focus:border-[#e99c2e] focus:ring-1 focus:ring-[#e99c2e]"
                required>
                <option value="">-- Pilih Produk --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Rp {{ number_format($product->price) }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Jenis Diskon -->
        <div>
            <label class="block text-[#616060] font-medium mb-1">Jenis Diskon</label>
            <select name="discount_type"
                class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 bg-white text-[#616060] focus:outline-none focus:border-[#e99c2e] focus:ring-1 focus:ring-[#e99c2e]"
                required>
                <option value="percent">Persentase (%)</option>
                <option value="fixed">Potongan Langsung (Rp)</option>
            </select>
        </div>

        <!-- Nilai Diskon -->
        <div>
            <label class="block text-[#616060] font-medium mb-1">Nilai Diskon</label>
            <input type="number" name="discount_value" min="0"
                class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 focus:outline-none focus:border-[#e99c2e] focus:ring-1 focus:ring-[#e99c2e]"
                required>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-[#616060] font-medium mb-1">Status</label>
            <select name="status"
                class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 bg-white text-[#616060] focus:outline-none focus:border-[#e99c2e] focus:ring-1 focus:ring-[#e99c2e]"
                required>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="pt-4">
            <button type="submit"
                class="bg-[#e99c2e] text-white px-6 py-2 rounded-lg hover:bg-[#d88a1f] transition font-medium">
                Simpan Diskon
            </button>
        </div>
    </form>
</div>
@endsection
