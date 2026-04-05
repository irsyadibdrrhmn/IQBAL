@extends('layouts.admin.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-[#5f5b57]">Daftar Pengguna</h2>
        <a href="{{ route('users.create') }}"
           class="inline-block px-4 py-2 bg-[#e99c2e] hover:bg-[#d68c25] text-white text-sm font-medium rounded-lg transition">
            Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-[#a09e9c]/20">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-[#f8f8f8]">
                    <tr>
                        <th class="px-6 py-3 text-left text-[#5f5b57] font-medium">#</th>
                        <th class="px-6 py-3 text-left text-[#5f5b57] font-medium">Nama</th>
                        <th class="px-6 py-3 text-left text-[#5f5b57] font-medium">Email</th>
                        <th class="px-6 py-3 text-left text-[#5f5b57] font-medium">Role</th>
                        <th class="px-6 py-3 text-right text-[#5f5b57] font-medium">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#a09e9c]/20 text-[#616060]">
                    @forelse ($users as $i => $user)
                        <tr class="hover:bg-[#fffaf5] transition">
                            <td class="px-6 py-4">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-[#616060]">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-[#616060]">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    {{ $user->role === 'admin' ? 'bg-[#e99c2e]/10 text-[#e99c2e]' : 'bg-[#a09e9c]/10 text-[#616060]' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-transparent border border-[#a09e9c]/40 text-[#616060] rounded-lg hover:bg-[#e99c2e] hover:text-white transition text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-[#a09e9c] italic">
                                Tidak ada pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($users, 'links'))
            <div class="px-6 py-4 border-t border-[#a09e9c]/20 flex justify-end">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
