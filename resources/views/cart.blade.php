<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Venues - Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .venue-card {
            margin-bottom: 20px;
        }

        .venue-img {
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cart.index') }}">
                                    <i class="fas fa-shopping-cart"></i>
                                    Cart
                                    @if (isset($cartCount) && $cartCount > 0)
                                        <span class="badge bg-danger">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/couple/dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="nav-link">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link">
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
        <h2>Cart</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="alert alert-info">Your cart is empty.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Image</th>
                            <th>Price (AED)</th>
                            <th>Quantity</th>
                            <th>Subtotal (AED)</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($cartItems as $item)
                            @php
                                $subtotal = $item->service->price * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->service->name }}</td>
                                <td>
                                    @if ($item->service->image)
                                        <img src="{{ asset('service_images/' . $item->service->image) }}"
                                            alt="Service Image" width="80" height="80" style="object-fit:cover;">
                                    @else
                                        <img src="https://via.placeholder.com/80x80?text=No+Image" alt="No Image"
                                            width="80" height="80" style="object-fit:cover;">
                                    @endif
                                </td>
                                <td>{{ number_format($item->service->price, 2) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('cart.update', $item->id) }}"
                                        class="d-flex align-items-center">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                            min="1" class="form-control form-control-sm me-2"
                                            style="width:70px;">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td>{{ number_format($subtotal, 2) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <td colspan="5" class="text-end fw-bold">Total</td>
                            <td colspan="2" class="fw-bold">{{ number_format($total, 2) }} AED</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form method="POST" action="{{ route('cart.checkout') }}">
                @csrf
                <button type="submit" class="btn btn-success btn-lg mt-3">
                    <i class="fas fa-credit-card"></i> Checkout
                </button>
            </form>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
