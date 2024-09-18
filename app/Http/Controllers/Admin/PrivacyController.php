<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privacy;

class PrivacyController extends Controller
{
    public function index()
    {

        $privacy = Privacy::first();

        return view('admin.pages.privacy', compact('privacy'));
    }


    public function storesection1(Request $request)
    {
        // Validate the request data
        $request->validate([
           
            'description' => 'required|string',
           
    
        ]);
    
        // Check if a Support record already exists
        $privacy = Privacy::first();
    
        if (empty($privacy)) {
            // Create a new Support instance if none exists
            $privacy = new Privacy;
        }
    
        // Assign input values to the Support model
      
        $privacy->description = $request->input('description');
        
        // Handle the image file if it is provided
    
    
        // Save the Support model
        $privacy->save();
    
        // Redirect to a route with a success message
        return redirect()->route('admin.privacy.index')->with('success', 'Privacy Policy has been successfully saved.');
    }
    
    }


