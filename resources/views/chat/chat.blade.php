<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Wedding Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/venues') }}">Venues</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/vendors') }}">Vendors</a></li>
                    @if (Route::has('login'))
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('chat.vendors') }}">
                                <i class="fas fa-comments"></i> Chat
                            </a>
                        </li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/couple/dashboard') }}">Dashboard</a></li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="nav-link">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                            @endif
                        @endauth
                @endif
                </ul>
            </div>
        </div>
    </nav>
<div class="container mt-4">
    <h4>Chat with {{ $vendor->name }}</h4>

    <div id="messages" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
        @foreach ($messages as $msg)
            <p><strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}</p>
        @endforeach
    </div>

    <form id="chat-form" class="mt-3">
        @csrf
        <input type="hidden" id="receiver_id" name="receiver_id" value="{{ $vendor->id }}">
        <div class="input-group">
            <input type="text" id="message" name="message" class="form-control" placeholder="Type your message">
            <button class="btn btn-primary" type="submit">Send</button>
        </div>
    </form>
</div><br>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Wedding Management System</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> --}}
@vite(['resources/js/app.js'])

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.Echo.private('chat.{{ auth()->id() }}')
            .listen('MessageSent', (e) => {
                const messageBox = document.getElementById('messages');
                messageBox.innerHTML += `<p><strong>${e.chat.sender.name}:</strong> ${e.chat.message}</p>`;
            });

        document.getElementById('chat-form').addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('Submitting chat form');
            fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    receiver_id: document.getElementById('receiver_id').value,
                    message: document.getElementById('message').value
                })
            }).then(res => {
                console.log('Response status:', res.status);
                if (res.ok) {
                    // document.getElementById('message').value = '';
                    location.reload();
                }
                return res.text();
            }).then(text => {
                console.log('Response body:', text);
            });
        });
    });
</script>

</body>
</html>
