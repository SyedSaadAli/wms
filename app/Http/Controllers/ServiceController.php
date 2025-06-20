<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Lists all services
     public function list()
     {
        $id = Auth::user()->id;
        $data['services'] = Service::all()->where('user_id', $id); // Fetch all services
        return view('panel.vendor.service.list', $data);
     }

     // Add a new service
     public function add()
     {
         return view('panel.vendor.service.add');
     }

     // Inserts a new service record
     public function insert(Request $req)
     {
         // Handle the image upload
         $imageName = null;
         if ($req->hasFile('image')) {
             $image = $req->file('image');
             $imageName = time() . '_' . $image->getClientOriginalName(); // Generate a unique name
             $destinationPath = public_path('service_images'); // Define the folder path

             // Create the folder if it doesn't exist
             if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true); // Create the folder with proper permissions
             }

             // Move the file to the folder
            $image->move($destinationPath, $imageName);
         }
         // Save the service record
         $save = new Service;
         $save->image = $imageName; // Save the image name in the database
         $save->name = $req->name;
         $save->description = $req->description;
         $save->price = $req->price;
         $save->location = $req->location;
         $save->user_id = Auth::user()->id;
         $save->save();

         return redirect('panel/vendor/service')->with('success', 'Service successfully added');
     }

     // Loads service edit view
     public function edit($id)
     {
         $data['getRecord'] = Service::find($id); // Fetch user by ID
         return view('panel.vendor.service.edit', $data);
     }

     // Updates an existing service
     public function update(Request $req, $id)
     {
         // Find the existing service record
         $service = Service::find($id);

         if (!$service) {
             return redirect('panel/vendor/service')->with('error', 'service not found.');
         }

         // Handle the image upload
         if ($req->hasFile('image')) {
             // Delete the previous image if it exists
             if ($service->image && file_exists(public_path('service_images/' . $service->image))) {
                 unlink(public_path('service_images/' . $service->image));
             }

             // Upload the new image
             $image = $req->file('image');
             $imageName = time() . '_' . $image->getClientOriginalName(); // Generate a unique name
             $destinationPath = public_path('service_images'); // Define the folder path

             // Create the folder if it doesn't exist
             if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true); // Create the folder with proper permissions
             }

             // Move the file to the folder
             $image->move($destinationPath, $imageName);

             // Update the image name in the database
             $service->image = $imageName;
         }

         // Update other fields
         $service->name = $req->name;
         $service->description = $req->description;
         $service->price = $req->price;
         $service->location = $req->location;
         // Save the updated service
         $service->save();

         return redirect('panel/vendor/service')->with('success', 'Service successfully updated');
     }

     // Deletes a service
     public function delete($id)
     {
         // Find the existing service record
         $service = service::find($id);

         if (!$service) {
             return redirect('panel/vendor/service')->with('error', 'Service not found.');
         }

         // Delete the image file if it exists
         if ($service->image && file_exists(public_path('service_images/' . $service->image))) {
             unlink(public_path('service_images/' . $service->image));
         }

         // Delete the service record from the database
         $service->delete();

         return redirect('panel/vendor/service')->with('success', 'Service successfully deleted');
     }
}
