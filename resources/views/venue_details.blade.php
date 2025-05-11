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

    <div class="container">
        <div class="venue-detail-container">
            <section class="venue-images-section">
                <img id="mainVenueImage" src="{{ asset('venue_images/'.$venue->image_name) }}" alt="Grand Ballroom" class="venue-image-main">
                </section>

            <section class="venue-details-section">
                <h2 id="venueName">{{ $venue->name }}</h2>
                <p id="venueDescription" class="mb-4">{{ $venue->description }}</p>

                <div class="detail-item">
                    <i class="fas fa-map-marker-alt detail-icon"></i>
                    <strong>Address:</strong> <span id="venueAddress">{{ $venue->address }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-users detail-icon"></i>
                    <strong>Guest Capacity:</strong> <span id="guestCapacity">{{ $venue->guest_capacity }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-dollar-sign detail-icon"></i>
                    <strong>Price Starting From:</strong> <span id="venuePrice"> ${{ number_format($venue->price, 0) }}</span>
                </div>
                <div class="detail-item">
                    <i class="far fa-calendar-alt detail-icon"></i>
                    <strong>Event Type:</strong> <span id="eventType">{{ $venue->event_type }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-palette detail-icon"></i>
                    <strong>Ambiance:</strong> <span id="venueAmbiance">{{ $venue->ambience }}</span>
                </div>

                <div>
                    <h4>Check Availability</h4>
                    <form id="availabilityForm">
                        @csrf
                        <input type="hidden" name="venue_id" value="{{ $venue->id }}">
                        <div class="mb-3">
                            <label for="checkInDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="checkInDate" name="bookingDate" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <button type="submit" class="btn btn-success">Check Availability</button>
                        <p id="availabilityMessage" class="mt-2"></p>
                    </form>
                </div>

                <div class="book-button">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">
                        Book Now
                    </button>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">{{ $venue->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST" data-processing="false">
                    @csrf
                        <input type="hidden" id="venue_id" name="venue_id" value={{ $venue->id }} required>
                    <div class="mb-3">
                        <label for="bookingDate" class="form-label">Booking Date</label>
                        <input type="date" min="{{ date('Y-m-d') }}" class="form-control" id="bookingDate" name="bookingDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="guestCount" class="form-label">Number of Guests</label>
                        <input type="number" class="form-control" id="guestCount" name="guestCount" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventStartTime" class="form-label">Event Start Time</label>
                        <input type="time" class="form-control" id="eventStartTime" name="eventStartTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventEndTime" class="form-label">Event End Time</label>
                        <input type="time" class="form-control" id="eventEndTime" name="eventEndTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="specialRequests" class="form-label">Special Requests</label>
                        <textarea class="form-control" id="specialRequests" name="specialRequests" rows="3"></textarea>
                    </div>
                    <p id="bookingConfirmation" class="mt-3"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmBooking">Confirm Booking</button>
            </div>
        </div>
    </div>
</div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 Wedding Management System</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    // Check Availability Form
    const availabilityForm = document.getElementById('availabilityForm');
    const availabilityMessage = document.getElementById('availabilityMessage');

    if (availabilityForm) {
        availabilityForm.addEventListener('submit', function (event) {
            event.preventDefault();

            // Clear previous messages
            availabilityMessage.textContent = '';

            // Submit the form via AJAX
            const formData = new FormData(availabilityForm);
            fetch('{{ route('bookings.checkAvailability') }}', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        availabilityMessage.textContent = data.message;
                        availabilityMessage.style.color = 'green';
                    } else {
                        availabilityMessage.textContent = data.message;
                        availabilityMessage.style.color = 'red';
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    availabilityMessage.textContent = 'An error occurred. Please try again.';
                    availabilityMessage.style.color = 'red';
                });
        });
    }

    // Booking Form
    const bookingForm = document.getElementById('bookingForm');
    const confirmBookingButton = document.getElementById('confirmBooking');
    const bookingModalElement = document.getElementById('bookingModal');
    const bookingConfirmation = document.getElementById('bookingConfirmation');

    if (confirmBookingButton && bookingForm) {
        confirmBookingButton.addEventListener('click', function () {
            // Prevent multiple submissions
            if (bookingForm.getAttribute('data-processing') === 'true') {
                return;
            }

            // Set the form as processing
            bookingForm.setAttribute('data-processing', 'true');

            // Clear previous messages
            bookingConfirmation.textContent = '';

            // Submit the form via AJAX
            const formData = new FormData(bookingForm);
            fetch(bookingForm.action, {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        bookingConfirmation.textContent = data.message;

                        // Close the modal after showing the message
                        setTimeout(() => {
                            const bookingModal = bootstrap.Modal.getInstance(bookingModalElement);
                            bookingModal.hide();
                            bookingForm.reset();
                            bookingConfirmation.textContent = '';
                        }, 2000);
                    } else {
                        bookingConfirmation.textContent = data.message || 'An error occurred. Please try again.';
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    bookingConfirmation.textContent = 'An error occurred. Please try again.';
                })
                .finally(() => {
                    // Reset the processing state
                    bookingForm.setAttribute('data-processing', 'false');
                });
        });
    }
});
    </script>
</body>
</html>
