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
        $category = Category::findOrFail($id)->where('');

        // Fetch the tips related to the selected category
        $tips = $category->tips; // Assuming you have a relationship defined in Category model

        // Pass the tips and category to the view
        return view('user.TipsandAdvise.tips_n_advice', compact('tips', 'category'));
    }
}



