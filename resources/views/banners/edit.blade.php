@extends('layouts.admin.admin')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <h2 class="text-2xl font-semibold mb-6 text-[#5f5b57]">Edit Banner</h2>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-[#616060] mb-1">Nama</label>
                <input type="text" name="name" value="{{ $banner->name }}" required
                    class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]" />
            </div>

            {{-- Gambar Saat Ini --}}
            <div>
                <label class="block text-sm font-medium text-[#616060] mb-1">Gambar Saat Ini</label>
                @if($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner" class="w-32 h-auto rounded-lg shadow-sm border border-[#a09e9c]" />
                @else
                    <p class="text-sm text-gray-500 italic">Belum ada gambar</p>
                @endif
            </div>

            {{-- Ganti Gambar --}}
            <div>
                <label class="block text-sm font-medium text-[#616060] mb-1">Ganti Gambar (opsional)</label>
                <input type="file" name="image"
                    class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]" />
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-[#616060] mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]">{{ $banner->description }}</textarea>
            </div>

            {{-- Nominal Diskon --}}
            <div>
                <label class="block text-sm font-medium text-[#616060] mb-1">Nominal Diskon (%)</label>
                <input type="number" name="discount_amount" value="{{ $banner->discount_amount }}"
                    class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]" />
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3 pt-4">
                <button type="submit"
                    class="px-5 py-2 rounded-lg bg-[#e99c2e] text-white font-medium hover:bg-[#d68b1f] transition duration-200">
                    Perbarui
                </button>
                <a href="{{ route('banners.index') }}"
                    class="px-5 py-2 rounded-lg bg-[#a09e9c] text-white font-medium hover:bg-[#8e8c89] transition duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
