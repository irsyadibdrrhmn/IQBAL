@extends('layouts.admin.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-md border border-gray-200 mt-6">
    <!-- Header -->
    <div class="bg-[#f8f8f8] rounded-t-2xl px-6 py-3 flex justify-between items-center border-b border-gray-200">
        <h2 class="text-lg font-semibold text-[#5f5b57]">
            Edit Product
        </h2>
    </div>

    <!-- Body -->
    <div class="px-6 py-6 bg-white rounded-b-2xl">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-[#5f5b57] mb-1">Name</label>
                <input type="text" id="name" name="name"
                    value="{{ $product->name }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060] placeholder-gray-400">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-[#5f5b57] mb-1">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060] placeholder-gray-400">{{ $product->description }}</textarea>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-semibold text-[#5f5b57] mb-1">Price</label>
                <input type="text" id="price" name="price"
                    value="{{ $product->price }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060] placeholder-gray-400">
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-semibold text-[#5f5b57] mb-1">Stock</label>
                <input type="text" id="stock" name="stock"
                    value="{{ $product->stock }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060] placeholder-gray-400">
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-semibold text-[#5f5b57] mb-1">Category</label>
                <select id="category_id" name="category_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060] bg-white">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jenis Produk -->
            <div>
                <label class="block text-sm font-semibold text-[#5f5b57] mb-1">Jenis Produk</label>
                <div class="flex items-center gap-6 text-[#616060]">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="is_premium" value="1"
                               {{ $product->is_premium == 1 ? 'checked' : '' }}
                               class="text-[#e99c2e] focus:ring-[#e99c2e]">
                        <span>Premium</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="is_premium" value="0"
                               {{ $product->is_premium == 0 ? 'checked' : '' }}
                               class="text-[#e99c2e] focus:ring-[#e99c2e]">
                        <span>Biasa</span>
                    </label>
                </div>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-semibold text-[#5f5b57] mb-1">Image</label>
                <input type="file" id="image" name="image"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060]">
            </div>

            <!-- Buttons -->
            <div class="flex justify-end items-center gap-3 pt-4">
                <a href="{{ route('products.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-[#616060] hover:bg-gray-100 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-[#e99c2e] hover:bg-[#d18b28] text-white rounded-md font-medium shadow-sm transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
