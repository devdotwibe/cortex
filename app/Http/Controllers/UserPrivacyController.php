<?php

namespace App\Http\Controllers;
use App\Models\Privacy;
use Illuminate\Http\Request;

class UserPrivacyController extends Controller
{
    public function index(Request $request){

        $privacy = Privacy::first();





        return view("privacy",compact('privacy'));


}

}
