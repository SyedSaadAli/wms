<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProfileController extends Controller
{
    // Show Bussiness profile
    public function index()
    {
        $id = Auth::user()->id;
        $data['profile'] = Profile::where('user_id', $id)->first();
        return view('panel.vendor.profile.index', $data);
    }

    // Add a new profile
    public function add()
    {
        return view('panel.vendor.profile.add');
    }

    // Inserts a new profile record
    public function insert(Request $req)
    {
        // Handle the image upload
        $imageName = null;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Generate a unique name
            $destinationPath = public_path('profile_images'); // Define the folder path

            // Create the folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true); // Create the folder with proper permissions
            }

            // Move the file to the folder
            $image->move($destinationPath, $imageName);
        }
        // Save the business profile record
        $save = new Profile;
        $save->image_name = $imageName; // Save the image name in the database
        $save->name = $req->name;
        $save->description = $req->description;
        $save->user_id = Auth::user()->id;
        $save->save();

        return redirect('panel/vendor/profile')->with('success', 'Business profile successfully added');
    }

    // Loads profile edit view
    public function edit($id)
    {
        $id = Auth::user()->id;
        $data['getRecord'] = Profile::where('user_id', $id)->first();
        return view('panel.vendor.profile.edit', $data);
    }

    // Updates an existing user
    public function update(Request $req, $id)
    {
        // Find the existing profile record
        $profile = Profile::find($id);

        if (!$profile) {
            return redirect('panel/vendor/profile')->with('error', 'Profile not found.');
        }

        // Handle the image upload
        if ($req->hasFile('image')) {
            // Delete the previous image if it exists
            if ($profile->image_name && file_exists(public_path('profile_images/' . $profile->image_name))) {
                unlink(public_path('profile_images/' . $profile->image_name));
            }

            // Upload the new image
            $image = $req->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Generate a unique name
            $destinationPath = public_path('profile_images'); // Define the folder path

            // Create the folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true); // Create the folder with proper permissions
            }

            // Move the file to the folder
            $image->move($destinationPath, $imageName);

            // Update the image name in the database
            $profile->image_name = $imageName;
        }

        // Update other fields
        $profile->name = $req->name;
        $profile->description = $req->description;

        // Save the updated profile
        $profile->save();

        return redirect('panel/vendor/profile')->with('success', 'Business profile successfully updated');
    }
}
