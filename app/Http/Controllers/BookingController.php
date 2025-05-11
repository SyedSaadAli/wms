<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

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

        return response()->json([
            'success' => true,
            'message' => 'Your Selected Venue Is Booked on ' . $request->bookingDate,
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
}
