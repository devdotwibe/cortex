<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsAndConditions;

class TermsAndConditionsController extends Controller
{
    public function index()
    {

        $TermsAndConditions = TermsAndConditions::first();

        return view('admin.pages.terms', compact('TermsAndConditions'));
    }


    public function storesection1(Request $request)
    {
        // Validate the request data
        $request->validate([
           
            'description' => 'required|string',
           
    
        ]);
    
        // Check if a Support record already exists
        $TermsAndConditions = TermsAndConditions::first();
    
        if (empty($TermsAndConditions)) {
            // Create a new Support instance if none exists
            $TermsAndConditions = new TermsAndConditions;
        }
    
        // Assign input values to the Support model
      
        $TermsAndConditions->description = $request->input('description');
        
        // Handle the image file if it is provided
    
    
        // Save the Support model
        $TermsAndConditions->save();
    
        // Redirect to a route with a success message
        return redirect()->route('admin.terms.index')->with('success', 'Terms and Condition has been successfully saved.');
    }
    
    }

