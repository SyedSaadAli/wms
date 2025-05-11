<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Vendors - Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .vendor-card {
            margin-bottom: 20px;
        }
        .vendor-img {
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.html">Wedding Management System</a>
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
                            <a
                                href="{{ route('login') }}"
                                class="nav-link"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="nav-link">
                                    Register
                                </a>
                            @endif
                        @endauth
                @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Wedding Vendors</h2>
        <div class="row">
            @foreach ($businessProfile as $value)

            <div class="col-md-4 vendor-card">
                <div class="card">
                    <img src="{{ asset('profile_images/'.$value->image_name) }}" class="card-img-top vendor-img" alt="Photographer 1">
                    <div class="card-body">
                        <h5 class="card-title">{{ $value->name }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($value->description, 100, '...') }}</p>
                        <a href="{{ url('/venues/'.$value->id) }}" class="btn btn-primary">View Venues</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
