<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        // Fetch the support content from the database
        $support = Support::first(); // Assuming there's only one support record. Adjust as needed.

        return view('user.support.index', compact('support'));
    }

}




