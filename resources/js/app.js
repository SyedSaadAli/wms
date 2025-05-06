import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.private('chat.' + receiverId)
    .listen('MessageSent', (e) => {
        console.log('New message:', e.message);
        // Update UI accordingly
        const messagesDiv = document.getElementById('messages');
        const newMessage = document.createElement('p');
        newMessage.textContent = e.message;
        messagesDiv.appendChild(newMessage);
    });
