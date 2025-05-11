<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class CoupleController extends Controller
{
    public function viewCoupleDashboard(){
        // Fetch the logged-in user's data
        $user = Auth::user();

        // Pass the user data to the view
        return view('panel.couple.couple_dashboard', compact('user'));
    }

     public function viewCoupleProfile(){
        return view('panel.couple.couple_profile');
    }

     public function updateCoupleProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'event_date' => 'nullable|date|after_or_equal:today',
        ]);

        // Update the user's profile
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->event_date = $request->event_date; // Update event_date (can be null)
        $user->save();

        return redirect()->route('couple.profile.view')->with('success', 'Profile updated successfully.');
    }

     public function viewCoupleBookingDetails()
    {
        // Fetch the logged-in user's bookings with associated venue details
        $bookings = Booking::where('user_id', Auth::id())
            ->with('venue') // Eager load the venue relationship
            ->orderBy('booking_date', 'desc') // Order by booking date in descending order
            ->get();

        return view('panel.couple.couple_booking_details', compact('bookings'));
    }

     public function editCoupleVenueBooking($id)
    {
        // Fetch the booking details by ID
        $booking = Booking::with('venue')->findOrFail($id);

        // Pass the booking details to the view
        return view('panel.couple.couple_venue_booking', compact('booking'));
    }

    public function updateCoupleVenueBooking(Request $request, $id)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'event_start_time' => 'required|date_format:H:i', // Ensure time is in HH:mm format
            'event_end_time' => 'required|date_format:H:i|after:event_start_time', // Ensure end time is after start time
            'guest_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:255',
        ]);

        // Fetch the booking to update
        $booking = Booking::findOrFail($id);

        // Check if another booking exists on the same date for the same venue
        $isBooked = Booking::where('venue_id', $booking->venue_id)
            ->where('booking_date', $request->booking_date)
            ->where('id', '!=', $id) // Exclude the current booking
            ->exists();

        if ($isBooked) {
            return redirect()->back()->withErrors(['booking_date' => 'The venue is already booked on the selected date.']);
        }

        // Update the booking details
        $booking->booking_date = $request->booking_date;
        $booking->event_start_time = $request->event_start_time;
        $booking->event_end_time = $request->event_end_time;
        $booking->guest_count = $request->guest_count;
        $booking->special_requests = $request->special_requests;
        $booking->save();

        return redirect()->route('couple.booking.details')->with('success', 'Booking updated successfully.');
    }
}
