<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Support;



class SupportController extends Controller
{
    // Other methods...

    public function index()
    {

        $support = Support::first();

        return view('admin.pages.support', compact('support'));
    }


    public function storesection1(Request $request)
{
    // Validate the request data
    $request->validate([
        'supporttile' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'buttonlabel' => 'nullable|string|max:255',
        'buttonlink' => 'nullable|string|max:255',

    ]);

    // Check if a Support record already exists
    $support = Support::first();

    if (empty($support)) {
        // Create a new Support instance if none exists
        $support = new Support;
    }

    // Assign input values to the Support model
    $support->supporttile = $request->input('supporttile');
    $support->description = $request->input('description');
    $support->buttonlabel = $request->input('buttonlabel');
    $support->buttonlink = $request->input('buttonlink');

    // Handle the image file if it is provided


    // Save the Support model
    $support->save();

    // Redirect to a route with a success message
    return redirect()->route('admin.support.index')->with('success', 'Support has been successfully saved.');
}

}
