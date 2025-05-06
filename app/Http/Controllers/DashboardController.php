<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     /**
     * Display dashboard page.
     */
    public function dashboard(){
        $role_id = Auth::user()->role_id;
        if($role_id == 1 || $role_id == 2){
            return view('panel.dashboard');
        }else{
        return redirect('/');
        }
    }
}
