<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat em Tempo Real</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 h-screen flex flex-col justify-center items-center">

    <div class="w-full max-w-lg bg-white shadow-md rounded-lg overflow-hidden flex flex-col h-[500px]">
        <div class="bg-indigo-600 text-white p-4 font-bold flex justify-between">
            <span>Sala: Geral</span>
            <span class="text-xs bg-indigo-500 px-2 py-1 rounded">Usuário: {{ auth()->user()->name }}</span>
        </div>

        <div id="messages-container" class="flex-1 p-4 overflow-y-auto space-y-3">
        </div>

        <form id="chat-form" class="border-t p-3 flex gap-2">
            <input type="text" id="message-input" placeholder="Digite sua mensagem..."
                class="flex-1 border rounded px-3 py-2 focus:outline-none focus:border-indigo-600" required>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Enviar
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roomId = 'geral';
            const messagesContainer = document.getElementById('messages-container');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const currentUserId = {{ auth()->id() }};

            function appendMessage(user, content, isMe = false) {
                const msgDiv = document.createElement('div');
                msgDiv.className = `flex flex-col ${isMe ? 'items-end' : 'items-start'}`;

                msgDiv.innerHTML = `
                    <span class="text-xs text-gray-500 px-1">${user}</span>
                    <div class="px-3 py-2 rounded-lg max-w-xs ${isMe ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800'}">
                        ${content}
                    </div>
                `;
                messagesContainer.appendChild(msgDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            fetch(`/messages/${roomId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(msg => {
                        appendMessage(msg.user.name, msg.content, msg.user_id === currentUserId);
                    });
                });

            window.Echo.private(`chat.${roomId}`)
                .listen('MessageSent', (e) => {
                    console.log('Mensagem recebida via WebSocket:', e);
                    appendMessage(e.message.user.name, e.message.content, e.message.user_id === currentUserId);
                });

            chatForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const content = messageInput.value;
                if (!content.trim()) return;

                messageInput.value = '';

                fetch('/messages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Socket-ID': window.Echo.socketId()
                        },
                        body: JSON.stringify({
                            content,
                            room_id: roomId
                        })
                    })
                    .then(res => res.json())
                    .then(msg => {
                        appendMessage(msg.user.name, msg.content, true);
                    });
            });
        });
    </script>
</body>

</html>
