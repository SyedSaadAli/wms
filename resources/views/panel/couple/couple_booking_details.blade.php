<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - Wedding Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #f0f0f0;
            padding: 20px;
            height: 100vh;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
        }

        .sidebar a:hover {
            color: #007bff;
        }

        .content {
            padding: 20px;
        }

        .booking-card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            overflow: hidden;
            background-color: #fff;
        }

        .booking-card img {
            width: 250px;
            height: auto;
            object-fit: cover;
        }

        .booking-details {
            padding: 20px;
            flex: 1;
        }

        .badge {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 sidebar">
                <ul>
                    <li><a href="{{ route('couple.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('couple.profile.view') }}">Profile</a></li>
                    <li><a href="{{ route('couple.booking.details') }}">Booking Details</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline"
                                style="text-decoration: none; color: inherit;">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
            <main class="col-md-9 content">
                <h2>Booking Details</h2>

                @forelse ($bookings as $booking)
                    <div class="card booking-card mb-3 p-3">
                        <div class="row g-3 align-items-center">
                            @if ($booking->venue && $booking->venue->image_name)
                                <div class="col-md-4">
                                    <img src="{{ asset('venue_images/' . $booking->venue->image_name) }}"
                                        alt="{{ $booking->venue->name }}" class="img-fluid rounded">
                                </div>
                            @endif

                            <div class="col-md-8">
                                <div class="booking-details">
                                    <h5 class="card-title">Venue: {{ $booking->venue->name ?? 'N/A' }}</h5>
                                    <p><strong>Date:</strong> {{ $booking->booking_date }}</p>
                                    <p><strong>Time:</strong>
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->event_start_time)->format('h:i A') }}
                                        -
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->event_end_time)->format('h:i A') }}
                                    </p>
                                    <p><strong>Guest Count:</strong> {{ $booking->guest_count }}</p>
                                    <p><strong>Special Requests:</strong> {{ $booking->special_requests ?? 'None' }}
                                    </p>
                                    <p><strong>Status:</strong> <span class="badge bg-success">Confirmed</span></p>
                                    <a href="{{ route('couple.venue.booking.edit', ['id' => $booking->id]) }}" class="btn btn-primary mt-2">Edit Venue Booking</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No bookings found.</p>
                @endforelse
            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
