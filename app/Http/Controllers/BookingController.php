<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Venue;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'bookingDate' => 'required|date|after_or_equal:today',
            'guestCount' => 'required|integer|min:1',
            'eventStartTime' => 'required|date_format:H:i',
            'eventEndTime' => 'required|date_format:H:i',
            'specialRequests' => 'nullable|string|max:255',
        ]);

        // Check if the event start time is earlier than the event end time
        if (strtotime($request->eventStartTime) >= strtotime($request->eventEndTime)) {
            return response()->json([
                'success' => false,
                'message' => 'The event start time must be earlier than the event end time.',
            ]);
        }

        // Check if the venue is already booked on the selected date
        $isBooked = Booking::where('venue_id', $request->venue_id)
            ->where('booking_date', $request->bookingDate)
            ->exists();

        if ($isBooked) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, this venue is already booked on the selected date.',
            ]);
        }

        // Save the booking
        $booking = new Booking();
        $booking->venue_id = $request->venue_id;
        $booking->user_id = Auth::id();
        $booking->booking_date = $request->bookingDate;
        $booking->guest_count = $request->guestCount;
        $booking->event_start_time = $request->eventStartTime;
        $booking->event_end_time = $request->eventEndTime;
        $booking->special_requests = $request->specialRequests;
        $booking->save();

        $booking->load('user', 'venue');

        // Send confirmation email
        Mail::to(Auth::user()->email)->send(new BookingConfirmed($booking));

        return response()->json([
            'success' => true,
            'message' => 'Your Selected Venue Is Booked on ' . $request->bookingDate. '. Confirmation email has been sent.',
        ]);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'bookingDate' => 'required|date|after_or_equal:today',
        ]);

        // Check if the venue is already booked on the selected date
        $isBooked = Booking::where('venue_id', $request->venue_id)
            ->where('booking_date', $request->bookingDate)
            ->exists();

        if ($isBooked) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, this venue is already booked on the selected date.',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'The venue is available on the selected date.',
        ]);
    }

    public function viewAllBookings()
    {
        $bookings = Booking::with(['user', 'venue'])->latest()->get();
        return view('panel.admin.bookings', compact('bookings'));
    }

    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Prevent cancellation if the booking date is in the past
        if (\Carbon\Carbon::parse($booking->booking_date)->isPast()) {
            return redirect()->back()->with('error', 'You cannot cancel a booking for a past date.');
        }

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->back()->with('success', 'Booking cancelled successfully.');
    }

    public function vendorBookings()
    {
        $vendorId = Auth::id();

        // Get all venue IDs owned by this vendor
        $venueIds = Venue::where('user_id', $vendorId)->pluck('id');

        // Get bookings for these venues, eager load user and venue
        $bookings = Booking::with(['user', 'venue'])
            ->whereIn('venue_id', $venueIds)
            ->latest()
            ->get();

        return view('panel.vendor.booking.index', compact('bookings'));
    }
}
