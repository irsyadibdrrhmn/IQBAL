@extends('layouts.admin.admin')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <div class="bg-white shadow-md rounded-2xl overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h4 class="text-xl font-semibold flex items-center gap-2" style="color: #5f5b57;">
                📩 Daftar Kontak
            </h4>
        </div>

        <ul class="divide-y divide-gray-100">
            @forelse ($users as $user)
                <li>
                    <a href="{{ route('chat.show', $user->id) }}"
                       data-user-id="{{ $user->id }}"
                       class="flex items-center gap-4 px-6 py-4 hover:bg-[#fff6f8] transition duration-200">
                       
                        {{-- Foto profil (inisial) --}}
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold uppercase shadow-sm"
                                 style="background-color: #fdecef; color: #f06292;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>

                        {{-- Nama dan status --}}
                        <div class="flex-1 min-w-0">
                            <div class="text-base font-medium truncate" style="color: #616060;">
                                {{ $user->name }}
                            </div>
                            @if (isset($unreadCounts[$user->id]) && $unreadCounts[$user->id] > 0)
                                <small class="text-red-500 font-medium unread-label">
                                    Pesan belum dibaca ({{ $unreadCounts[$user->id] }})
                                </small>
                            @endif
                        </div>

                        {{-- Badge unread --}}
                        @if (isset($unreadCounts[$user->id]) && $unreadCounts[$user->id] > 0)
                            <div>
                                <span class="bg-red-500 text-white text-xs font-semibold rounded-full px-3 py-1 unread-badge">
                                    {{ $unreadCounts[$user->id] }}
                                </span>
                            </div>
                        @endif
                    </a>
                </li>
            @empty
                <li class="text-center text-gray-400 py-6">Belum ada kontak.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('a[data-user-id]').forEach(link => {
            link.addEventListener('click', async function() {
                const userId = this.dataset.userId;

                try {
                    const res = await fetch(`/chat/read-messages/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({})
                    });

                    const data = await res.json();
                    if (data.success) {
                        this.querySelector('.unread-badge')?.remove();
                        this.querySelector('.unread-label')?.remove();
                    }
                } catch (error) {
                    console.error('Error updating read status:', error);
                }
            });
        });
    });
</script>
@endsection
