<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
     // Lists all venues
     public function list()
     {
        $id = Auth::user()->id;
        $data['venues'] = Venue::all()->where('user_id', $id); // Fetch all venues
        return view('panel.vendor.venue.list', $data);
     }

     // Add a new venue
     public function add()
     {
         return view('panel.vendor.venue.add');
     }

     // Inserts a new venue record
     public function insert(Request $req)
     {
         // Handle the image upload
         $imageName = null;
         if ($req->hasFile('image')) {
             $image = $req->file('image');
             $imageName = time() . '_' . $image->getClientOriginalName(); // Generate a unique name
             $destinationPath = public_path('venue_images'); // Define the folder path

             // Create the folder if it doesn't exist
             if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true); // Create the folder with proper permissions
             }

             // Move the file to the folder
            $image->move($destinationPath, $imageName);
         }
         // Save the venue record
         $save = new Venue;
         $save->image_name = $imageName; // Save the image name in the database
         $save->name = $req->name;
         $save->description = $req->description;
         $save->price = $req->price;
         $save->address = $req->address;
         $save->event_type = $req->event_type;
         $save->ambience = $req->ambience;
         $save->guest_capacity = $req->guest_capacity;
         $save->user_id = Auth::user()->id;
         $save->save();

         return redirect('panel/vendor/venue')->with('success', 'Venue successfully added');
     }

     // Loads venue edit view
     public function edit($id)
     {
         $data['getRecord'] = Venue::find($id); // Fetch user by ID
         return view('panel.vendor.venue.edit', $data);
     }

     // Updates an existing venue
     public function update(Request $req, $id)
     {
         // Find the existing venue record
         $venue = Venue::find($id);

         if (!$venue) {
             return redirect('panel/vendor/venue')->with('error', 'Venue not found.');
         }

         // Handle the image upload
         if ($req->hasFile('image')) {
             // Delete the previous image if it exists
             if ($venue->image_name && file_exists(public_path('venue_images/' . $venue->image_name))) {
                 unlink(public_path('venue_images/' . $venue->image_name));
             }

             // Upload the new image
             $image = $req->file('image');
             $imageName = time() . '_' . $image->getClientOriginalName(); // Generate a unique name
             $destinationPath = public_path('venue_images'); // Define the folder path

             // Create the folder if it doesn't exist
             if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true); // Create the folder with proper permissions
             }

             // Move the file to the folder
             $image->move($destinationPath, $imageName);

             // Update the image name in the database
             $venue->image_name = $imageName;
         }

         // Update other fields
         $venue->name = $req->name;
         $venue->description = $req->description;
         $venue->price = $req->price;
         $venue->address = $req->address;
         $venue->event_type = $req->event_type;
         $venue->ambience = $req->ambience;
         $venue->guest_capacity = $req->guest_capacity;
         // Save the updated venue
         $venue->save();

         return redirect('panel/vendor/venue')->with('success', 'Venue successfully updated');
     }

     // Deletes a venue
     public function delete($id)
     {
         // Find the existing venue record
         $venue = Venue::find($id);

         if (!$venue) {
             return redirect('panel/vendor/venue')->with('error', 'Venue not found.');
         }

         // Delete the image file if it exists
         if ($venue->image_name && file_exists(public_path('venue_images/' . $venue->image_name))) {
             unlink(public_path('venue_images/' . $venue->image_name));
         }

         // Delete the venue record from the database
         $venue->delete();

         return redirect('panel/vendor/venue')->with('success', 'Venue successfully deleted');
     }
}
