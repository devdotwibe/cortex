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
        // Fetch the selected category along with its tips
        $category = Category::with('tips')->findOrFail($id);

        // If the category has no tips, redirect or show an error
        if ($category->tips->isEmpty()) {
            return redirect()->route('tipsandadvise.index')->with('error', 'No tips available for this category.');
        }

        // Pass the category and tips to the view
        return view('user.TipsandAdvise.tips_n_advice', compact('category', 'tips'));
    }
}


