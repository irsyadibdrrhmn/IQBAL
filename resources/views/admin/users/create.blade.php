@extends('layouts.admin.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold text-[#5f5b57] mb-6">Tambah Pengguna Baru</h2>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-md border border-[#a09e9c]/30 p-6">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-[#5f5b57] mb-1">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]/40 focus:border-[#e99c2e]">
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-[#5f5b57] mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]/40 focus:border-[#e99c2e]">
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-[#5f5b57] mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]/40 focus:border-[#e99c2e]">
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-[#5f5b57] mb-1">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] focus:outline-none focus:ring-2 focus:ring-[#e99c2e]/40 focus:border-[#e99c2e]">
                </div>

                {{-- Role --}}
                <div>
                    <label for="role" class="block text-sm font-medium text-[#5f5b57] mb-1">Role</label>
                    <select id="role" name="role" required
                            class="w-full border border-[#a09e9c]/40 rounded-lg px-4 py-2 text-[#616060] bg-white focus:outline-none focus:ring-2 focus:ring-[#e99c2e]/40 focus:border-[#e99c2e]">
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-4">
                <button type="submit"
                        class="px-5 py-2.5 bg-[#e99c2e] text-white rounded-lg hover:bg-[#d68c25] transition">
                    Tambah Pengguna
                </button>
                <a href="{{ route('users.index') }}"
                   class="px-5 py-2.5 border border-[#a09e9c]/40 text-[#616060] rounded-lg hover:bg-[#e99c2e] hover:text-white transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
