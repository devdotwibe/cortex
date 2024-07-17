<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    function index(Request $request)
    {
        /**
         * @var User
         */
        $user = Auth::user();
        
        return view('user.profile.edit',compact('user'));
    }

    function update(Request $request)
    {
        $request->validate([

            "first_name"=>"required",
            "last_name"=>"required",
            "phone"=>"required",
            "schooling_year"=>"required",
        ]);
        /**
         * @var User
         */
        $user = Auth::user();
        $user->name = $request->first_name.' '.$request->last_name;
       
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->schooling_year = $request->schooling_year;

        $user->save();

        return redirect()->route('profile.view')->with('success','Profile Updated Successfully');

    }

    function view(Request $request)
    {
        $user = Auth::user();
        
        return view('user.profile.view',compact('user'));
    }

}
