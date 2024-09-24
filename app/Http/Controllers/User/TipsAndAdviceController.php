<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class TipsAndAdviceController extends Controller
{
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::all(); // Fetch all records

        // Pass the categories to the view
        return view('user.TipsandAdvise.index', compact('categories'));
    }


    public function tip_show($id)
    {
        // Fetch the selected category
        $category = Category::with('tips')->findOrFail($id); // Ensure the category is loaded with tips

        // Check if the category has any tips before passing it to the view
        if ($category->tips->isEmpty()) {
            // Redirect or show a message if no tips found
            return redirect()->route('tipsandadvise.index')->with('error', 'No tips found for this category.');
        }

        // Pass the tips and category to the view
        return view('user.TipsandAdvise.tips_n_advice', compact('tips', 'category'));
    }
}


