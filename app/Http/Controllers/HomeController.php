<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Profile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Display the venues page.
     */
    public function venues($id = null)
    {
        if ($id) {
            $profile = Profile::find($id);
            $data['venues'] = Venue::where('user_id', $profile->user_id)->get();
            return view('venues', $data);
        } else {
            $data['venues'] = Venue::all();
            return view('venues', $data);
        }
    }

    /**
     * Display the vendors page.
     */
    public function vendors()
    {
        $data['businessProfile'] = Profile::all();
        return view('vendors', $data);
    }
}
