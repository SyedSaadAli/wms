<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Details - Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .venue-detail-container {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }
        .venue-images-section {
            flex: 0 0 50%;
            padding-right: 20px;
        }
        .venue-image-main {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
            object-fit: cover;
            max-height: 500px; /* Increased max-height for a single image */
        }
        .venue-details-section {
            flex: 0 0 50%;
            padding-left: 20px;
        }
        .detail-item {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .detail-icon {
            margin-right: 10px;
            color: #007bff;
            font-size: 1.2em;
        }
        .book-button {
            margin-top: 20px;
        }
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/vendors') }}">Vendors</a></li>
                    @if (Route::has('login'))
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/message') }}">
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

    <div class="container">
        <div class="venue-detail-container">
            <section class="venue-images-section">
                <img id="mainVenueImage" src="{{ asset('service_images/'.$service->image) }}" alt="Grand Ballroom" class="venue-image-main">
                </section>

            <section class="venue-details-section">
                <h2 id="venueName">{{ $service->name }}</h2>
                <p id="venueDescription" class="mb-4">{{ $service->description }}</p>

                <div class="detail-item">
                    <i class="fas fa-map-marker-alt detail-icon"></i>
                    <strong>Address:</strong> <span id="venueAddress">{{ $service->location }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-dollar-sign detail-icon"></i>
                    <strong>Price:</strong> <span id="venuePrice"> AED {{ number_format($service->price, 0) }}</span>
                </div>
            </section>
        </div>
    </div>
</div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Wedding Management System</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
