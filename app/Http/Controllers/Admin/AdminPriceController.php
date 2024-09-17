<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pricing;
class AdminPriceController extends Controller
{
    public function index()
    {
       


        return view('admin.payment-price.index', compact('price'));
    }

    public function storesection1(Request $request)

    {

        
        // Validate the request data for price information
        $request->validate([
            'pricebannertitle' => 'nullable|string',
            'pricebuttonlabel' => 'nullable|string|max:255',
            'pricebuttonlink' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);
    
        // Retrieve the first record or create a new one
        $price = Pricing::first();
    
        if (empty($price)) {
            $price = new Pricing;
        }
    
        // Update fields
        $price->pricebannertitle = $request->input('pricebannertitle');
        $price->pricebuttonlabel = $request->input('pricebuttonlabel');
        $price->pricebuttonlink = $request->input('pricebuttonlink');
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Generate a unique name for the image and store it
            $imageName = "price/" . $request->file('image')->hashName();
            $request->file('image')->storeAs('public/price', $imageName); // Store image in 'public/price' directory
            $price->image = $imageName;
        }



    
        // Save the price record
        $price->save();
    
        // Redirect with success message
        return redirect()->route('admin.payment-price.index')->with('success', 'Price information has been successfully saved.');
    }
    



}
