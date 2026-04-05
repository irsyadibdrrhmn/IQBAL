@extends('layouts.admin.admin')

@section('content')
<div class="flex justify-center py-6 bg-[#ffffff]">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-md flex flex-col max-h-[80vh] border border-gray-100">

        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
            <h6 class="font-semibold text-[#5f5b57] text-sm">
                💬 Chat dengan <span class="text-[#e99c2e]">{{ $user->name }}</span>
            </h6>
        </div>

        <!-- Chat Messages -->
        <div id="messages" class="flex-1 overflow-y-auto px-4 pt-3 space-y-2 min-h-[300px] max-h-[55vh]">
            @foreach ($messages as $message)
                @if ($message->from_user_id == auth()->id())
                    <div class="flex justify-end">
                        <div class="bg-[#e99c2e] text-white px-3 py-2 rounded-2xl rounded-tr-none shadow-sm max-w-[80%] text-sm">
                            {{ $message->message }}
                            <div class="text-white/70 text-right text-[10px] mt-1">
                                {{ $message->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-start">
                        <div class="bg-gray-100 text-[#616060] px-3 py-2 rounded-2xl rounded-tl-none shadow-sm max-w-[80%] text-sm">
                            {{ $message->message }}
                            <div class="text-[#a09e9c] text-[10px] mt-1">
                                {{ $message->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Input Chat -->
        <div class="border-t border-gray-200 px-4 py-2 bg-white">
            <form id="chat-form" class="flex items-center gap-2" onsubmit="sendMessage(event)">
                <input 
                    id="messageInput" 
                    type="text" 
                    placeholder="Ketik pesan..." 
                    autocomplete="off"
                    class="flex-1 border border-[#a09e9c]/40 rounded-full px-3 py-2 text-sm text-[#616060] focus:ring-2 focus:ring-[#e99c2e] focus:outline-none"
                >
                <button 
                    type="submit"
                    class="bg-[#e99c2e] text-white rounded-full px-4 py-2 text-sm font-medium hover:bg-[#d48b23] transition"
                >
                    Kirim
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const messagesEl = document.getElementById('messages');
    const inputEl = document.getElementById('messageInput');
    const userId = {{ $user->id }};
    const myId = {{ auth()->id() }};

    function scrollToBottom() {
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }
    scrollToBottom();

    async function sendMessage(event) {
        event.preventDefault();
        const message = inputEl.value.trim();
        if (!message) return;

        try {
            const res = await fetch('{{ route("send.message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message, to_user_id: userId })
            });

            const data = await res.json();
            if (data.status === 'Message sent!') {
                appendMessage(data.message);
                inputEl.value = '';
                scrollToBottom();
            }
        } catch (error) {
            console.error(error);
        }
    }

    function appendMessage(message) {
        const div = document.createElement('div');
        div.classList.add('flex', 'mb-2');

        if (message.from_user_id === myId) {
            div.classList.add('justify-end');
            div.innerHTML = `
                <div class="bg-[#e99c2e] text-white px-3 py-2 rounded-2xl rounded-tr-none shadow-sm max-w-[80%] text-sm">
                    ${message.message}
                    <div class="text-white/70 text-right text-[10px] mt-1">
                        ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                    </div>
                </div>
            `;
        } else {
            div.classList.add('justify-start');
            div.innerHTML = `
                <div class="bg-gray-100 text-[#616060] px-3 py-2 rounded-2xl rounded-tl-none shadow-sm max-w-[80%] text-sm">
                    ${message.message}
                    <div class="text-[#a09e9c] text-[10px] mt-1">
                        ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                    </div>
                </div>
            `;
        }

        messagesEl.appendChild(div);
    }

    async function fetchMessages() {
        try {
            const res = await fetch(`/chat/messages/${userId}`);
            const messages = await res.json();
            messagesEl.innerHTML = '';
            messages.forEach(appendMessage);
            scrollToBottom();
        } catch (error) {
            console.error('Fetch messages error:', error);
        }
    }

    setInterval(fetchMessages, 3000);
</script>

<style>
    #messages::-webkit-scrollbar {
        width: 5px;
    }
    #messages::-webkit-scrollbar-thumb {
        background: #e99c2e;
        border-radius: 4px;
    }
</style>
@endsection
