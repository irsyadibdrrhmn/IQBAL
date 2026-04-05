@extends('layouts.app')

@section('content')
<div>
    <h2>Chat Room</h2>
    <div id="messages" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;"></div>

    <input type="text" id="messageInput" placeholder="Type message..." />
    <button onclick="sendMessage()">Send</button>
</div>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    // Initialize Pusher
    Pusher.logToConsole = true;
    var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });

    var channel = pusher.subscribe('presence-chat');

    channel.bind('App\\Events\\MessageSent', function(data) {
        var messages = document.getElementById('messages');
        messages.innerHTML += '<p><strong>' + data.user + ':</strong> ' + data.message + '</p>';
        messages.scrollTop = messages.scrollHeight;
    });

    function sendMessage() {
        var input = document.getElementById('messageInput');
        var message = input.value;

        if(message.trim() === '') return;

        fetch('{{ route("send.message") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({message: message})
        })
        .then(response => response.json())
        .then(data => {
            input.value = '';
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
