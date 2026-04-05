<!-- Tambahkan ini di <head> -->
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<!-- Bubble Chat Floating Button + Chat Box -->
<div x-data="{ open: false }" style="position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 1055;">
    <!-- Toggle Button -->
    <button 
        @click="open = !open" 
        class="shadow"
        style="width: 60px; 
               height: 60px; 
               background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
               color: white;
               border: none;
               border-radius: 50%;
               display: flex;
               align-items: center;
               justify-content: center;
               cursor: pointer;
               transition: all 0.3s ease;
               box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4);"
        onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 20px rgba(251, 191, 36, 0.6)';"
        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(251, 191, 36, 0.4)';"
    >
        <i class="fas fa-comment-dots fa-lg"></i>
    </button>

    <!-- Chat Box -->
    <div 
        x-show="open"
        x-cloak
        @click.outside="open = false"
        x-transition
        class="border-0 shadow-lg"
        style="width: 350px; 
               max-height: 550px; 
               position: absolute; 
               bottom: 80px; 
               right: 0; 
               border-radius: 1rem;
               overflow: hidden;
               box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
               background: white;"
    >
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
                    color: white;
                    padding: 1rem 1.25rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;">
            <div>
                <strong style="font-size: 1.1rem;">💬 Chat Admin</strong>
                <div style="font-size: 0.75rem; opacity: 0.9; margin-top: 2px;">
                    <i class="fas fa-circle" style="font-size: 0.5rem; color: #4ade80;"></i> Online
                </div>
            </div>
            <button 
                @click="open = false"
                style="background: rgba(255, 255, 255, 0.2);
                       border: none;
                       width: 32px;
                       height: 32px;
                       border-radius: 50%;
                       color: white;
                       cursor: pointer;
                       display: flex;
                       align-items: center;
                       justify-content: center;
                       transition: all 0.2s;"
                onmouseover="this.style.background='rgba(255, 255, 255, 0.3)';"
                onmouseout="this.style.background='rgba(255, 255, 255, 0.2)';"
            >
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Chat Body -->
        <div id="bubble-messages" 
             class="overflow-auto"
             style="height: 350px;
                    padding: 1.25rem;
                    background: linear-gradient(to bottom, #fffbeb 0%, #fef3c7 100%);">
            <!-- Chat messages will be inserted here -->
        </div>

        <!-- Input -->
        <div style="padding: 1rem; 
                    background: white; 
                    border-top: 1px solid #f3f4f6;">
            <form id="bubble-form" 
                  style="display: flex; 
                         gap: 0.5rem; 
                         margin: 0;" 
                  onsubmit="sendBubbleMessage(event)">
                <input 
                    id="bubbleInput" 
                    type="text" 
                    placeholder="Tulis pesan..." 
                    class="form-control"
                    style="flex: 1;
                           padding: 0.75rem 1.25rem;
                           border: 2px solid #fde68a;
                           border-radius: 2rem;
                           outline: none;
                           font-size: 0.9rem;
                           transition: all 0.3s;"
                    onfocus="this.style.borderColor='#fbbf24'; this.style.boxShadow='0 0 0 3px rgba(251, 191, 36, 0.1)';"
                    onblur="this.style.borderColor='#fde68a'; this.style.boxShadow='none';"
                />
                <button 
                    type="submit" 
                    style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
                           color: white;
                           border: none;
                           width: 45px;
                           height: 45px;
                           border-radius: 50%;
                           cursor: pointer;
                           display: flex;
                           align-items: center;
                           justify-content: center;
                           transition: all 0.3s;
                           box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);"
                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 12px rgba(251, 191, 36, 0.5)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 8px rgba(251, 191, 36, 0.3)';"
                >
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>


<!-- Scripts -->
<script>
    const bubbleInput = document.getElementById('bubbleInput');
    const bubbleMessages = document.getElementById('bubble-messages');

    function scrollBubbleBottom() {
        bubbleMessages.scrollTop = bubbleMessages.scrollHeight;
    }

    async function sendBubbleMessage(event) {
        event.preventDefault();
        const message = bubbleInput.value.trim();
        if (!message) return;

        try {
            const res = await fetch('{{ route("send.message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message, to_user_id: 1 }) // Ganti ID jika perlu
            });

            const data = await res.json();
            if (data.status === 'Message sent!') {
                appendBubbleMessage(data.message);
                bubbleInput.value = '';
                scrollBubbleBottom();
            }
        } catch (err) {
            console.error(err);
        }
    }

    function appendBubbleMessage(message) {
        const myId = {{ auth()->id() }};
        const time = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const msgEl = document.createElement('div');
        msgEl.style.display = 'flex';
        msgEl.style.marginBottom = '1rem';
        msgEl.style.justifyContent = message.from_user_id === myId ? 'flex-end' : 'flex-start';

        const isUser = message.from_user_id === myId;
        
        msgEl.innerHTML = `
            <div style="background: ${isUser ? 'linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%)' : 'white'};
                        color: ${isUser ? 'white' : '#374151'};
                        padding: 0.75rem 1rem;
                        border-radius: ${isUser ? '1rem 1rem 0.25rem 1rem' : '1rem 1rem 1rem 0.25rem'};
                        max-width: 75%;
                        box-shadow: ${isUser ? '0 2px 8px rgba(251, 191, 36, 0.3)' : '0 2px 8px rgba(0, 0, 0, 0.1)'};">
                <div style="font-size: 0.9rem;">${message.message}</div>
                <div style="text-align: right; font-size: 0.7rem; color: ${isUser ? 'rgba(255, 255, 255, 0.9)' : '#9ca3af'}; margin-top: 0.25rem;">${time}</div>
            </div>
        `;

        bubbleMessages.appendChild(msgEl);
    }

    async function fetchBubbleMessages() {
        try {
            const res = await fetch(`/chat/messages/1`); // Ganti dengan ID target jika perlu
            const messages = await res.json();

            bubbleMessages.innerHTML = '';
            messages.forEach(appendBubbleMessage);
            scrollBubbleBottom();
        } catch (err) {
            console.error('Failed to fetch messages', err);
        }
    }

    setInterval(fetchBubbleMessages, 3000);
</script>

<!-- Alpine.js (wajib untuk x-data, x-show, dsb) -->
<script src="//unpkg.com/alpinejs" defer></script>

<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />