<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
    <h4>Select a Vendor to Chat</h4>
    <ul class="list-group">
        @foreach ($vendors as $vendor)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $vendor->name }}
                <a href="{{ route('chat.with.vendor', $vendor->id) }}" class="btn btn-sm btn-success">Chat</a>
            </li>
        @endforeach
    </ul>
</div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Wedding Management System</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
