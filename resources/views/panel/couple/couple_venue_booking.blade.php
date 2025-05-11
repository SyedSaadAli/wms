<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Booking - Wedding Management System</title>
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
                <h2>Venue Booking - {{ $booking->venue->name ?? 'N/A' }}</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('couple.venue.booking.update', ['id' => $booking->id]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="bookingDate" class="form-label">Booking Date</label>
                        <input type="date" class="form-control" id="bookingDate" name="booking_date"
                            value="{{ $booking->booking_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventStartTime" class="form-label">Event Start Time</label>
                        <input type="time" class="form-control" id="eventStartTime" name="event_start_time"
                            value="{{ \Carbon\Carbon::parse($booking->event_start_time)->format('H:i') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventEndTime" class="form-label">Event End Time</label>
                        <input type="time" class="form-control" id="eventEndTime" name="event_end_time"
                            value="{{ \Carbon\Carbon::parse($booking->event_end_time)->format('H:i') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="guestCount" class="form-label">Guest Count</label>
                        <input type="number" class="form-control" id="guestCount" name="guest_count"
                            value="{{ $booking->guest_count }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="specialRequests" class="form-label">Special Requests</label>
                        <textarea class="form-control" id="specialRequests" name="special_requests" rows="3">{{ $booking->special_requests }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Venue Booking</button>
                </form>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
