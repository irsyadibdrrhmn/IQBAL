@extends('layouts.admin.admin')

@section('content')
<div class="col-md-12">
    <div class="card rounded-lg shadow">
        <!-- Header Card -->
        <div class="card-header bg-white border-b border-gray-300">
            <div class="flex justify-between items-center">
                <div class="text-[#5f5b57] font-bold text-lg">➕ Add New Category</div>
            </div>
        </div>

        <!-- Body Form -->
        <div class="card-body bg-white p-6">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-[#616060] font-semibold mb-2">Category Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="w-full border border-[#616060] rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#e99c2e] focus:border-[#e99c2e] text-[#616060]" 
                        placeholder="Enter category name..." 
                        required
                    >
                    @error('name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex gap-3 mt-4">
                    <button type="submit" class="bg-[#e99c2e] hover:bg-[#d38b2a] text-white font-semibold px-4 py-2 rounded">
                        💾 Save
                    </button>
                    <a href="{{ route('categories.index') }}" class="border border-gray-400 text-[#616060] hover:bg-[#f5f5f5] px-4 py-2 rounded font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
