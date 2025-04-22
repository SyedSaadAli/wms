<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Lists all users
    public function list()
    {
        $data['getRecord'] = User::getRecord(); // Fetch all users
        return view('panel.admin.vendor.list', $data);
    }

    public function approve($id)
    {
        $user = User::find($id);
        $user->is_approved = 'approved';
        $user->save();
        return redirect('panel/admin/vendor')->with('success', 'User successfully approved');
    }

    public function reject($id)
    {
        $user = User::find($id);
        $user->is_approved = 'rejected';
        $user->save();
        return redirect('panel/admin/vendor')->with('success', 'User successfully rejected');
    }
}
