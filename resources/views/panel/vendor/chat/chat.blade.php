@extends('panel.layouts.app')
@section('content')
<div class="container mt-4">
    <h4>Chat with {{ $user->name }}</h4>
    <div id="chat-box" class="border p-3 mb-3" style="height: 300px; overflow-y: scroll;">
        @foreach ($messages as $msg)
            <div class="{{ $msg->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
                <p class="mb-1">{{ $msg->message }}</p>
                <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
    <form id="chat-form">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Type your message">
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> --}}
@vite(['resources/js/app.js'])
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chat-form');
    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            let form = e.target;
            fetch("{{ route('vendor.chat.send') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': form._token.value,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    message: form.message.value,
                    receiver_id: form.receiver_id.value,
                })
            }).then(res => res.json())
            .then(res => {
                if (res.success) {
                    // chatForm.message.value = '';
                    location.reload();
                }
            });
        });
    }

    // Listen for real-time messages
    window.Echo.private('chat.{{ auth()->id() }}')
        .listen('MessageSent', (e) => {
            const chatBox = document.getElementById('chat-box');
            // Only append if the message is for this conversation
            if (e.chat.sender.id == {{ auth()->id() }} || e.chat.receiver_id == {{ $user->id }}) {
                const align = e.chat.sender.id == {{ auth()->id() }} ? 'text-end' : 'text-start';
                chatBox.innerHTML += `
                    <div class="${align}">
                        <p class="mb-1">${e.chat.message}</p>
                        <small class="text-muted">just now</small>
                    </div>
                `;
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
});
</script>
