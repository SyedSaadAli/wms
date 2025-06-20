<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     /**
     * Display dashboard page.
     */
    public function dashboard()
    {
        $role_id = Auth::user()->role_id;
        if ($role_id == 1 || $role_id == 2) {
            // Fetch counts
            $totalVendors = User::where('role_id', 2)->count();
            $totalBookings = Booking::count();
            $totalVenues = Venue::count();
            $totalServices = Service::count();

            return view('panel.dashboard', compact(
                'totalVendors',
                'totalBookings',
                'totalVenues',
                'totalServices'
            ));
        } else {
            return redirect('/');
        }
    }
}
