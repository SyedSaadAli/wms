{{-- User Name on Top --}}
<p><strong>Booking Confirmed for: {{ $booking->user->name }}</strong></p>

{{-- Booking Details Table --}}
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <th>Venue Name</th>
        <td>{{ $booking->venue->name }}</td>
    </tr>
    <tr>
        <th>Venue Address</th>
        <td>{{ $booking->venue->address ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Booking Date</th>
        <td>{{ $booking->booking_date }}</td>
    </tr>
    <tr>
        <th>Guest Count</th>
        <td>{{ $booking->guest_count }}</td>
    </tr>
    <tr>
        <th>Event Start Time</th>
        <td>{{ $booking->event_start_time }}</td>
    </tr>
    <tr>
        <th>Event End Time</th>
        <td>{{ $booking->event_end_time }}</td>
    </tr>
    <tr>
        <th>Special Requests</th>
        <td>{{ $booking->special_requests ?? 'None' }}</td>
    </tr>
</table>

{{-- Invoice Section --}}
<h3 style="margin-top: 30px;">Invoice</h3>
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
    <tr>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td>Venue Price</td>
        <td><strong>AED {{ number_format($booking->venue->price, 0) }}</strong></td>
    </tr>
    <tr>
        <th>Total</th>
        <th>AED {{ number_format($booking->venue->price, 0) }}</th>
    </tr>
</table>

<p>Thank you for choosing us.</p>

<p>Want to make your event even more special? <br>
Check out our wide range of services to enhance your wedding experience!</p>

<a href="http://weddinginuae.com/services"
   style="display:inline-block;padding:12px 24px;background:#007bff;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;">
    Explore Our Services
</a>
