<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Order;
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

        if ($role_id == 1) {
            // Admin stats
            $totalVendors = User::where('role_id', 2)->count();
            $totalBookings = Booking::count();
            $totalVenues = Venue::count();
            $totalServices = Service::count();
            $totalOrders = Order::count();

            return view('panel.dashboard', compact(
                'role_id',
                'totalVendors',
                'totalBookings',
                'totalVenues',
                'totalServices',
                'totalOrders'
            ));
        } elseif ($role_id == 2) {
            // Vendor stats (only their own)
            $vendorId = Auth::id();
            $totalVenues = Venue::where('user_id', $vendorId)->count();
            $totalServices = Service::where('user_id', $vendorId)->count();

            // Orders: count unique orders that have at least one item for this vendor
            $totalOrders = \App\Models\OrderItem::whereHas('service', function($q) use ($vendorId) {
                $q->where('user_id', $vendorId);
            })->distinct('order_id')->count('order_id');

            return view('panel.dashboard', compact(
                'role_id',
                'totalVenues',
                'totalServices',
                'totalOrders'
            ));
        } else {
            return redirect('/');
        }
    }
}
