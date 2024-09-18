<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TermsAndConditions;
class UserTermsController extends Controller
{
    public function index(Request $request){

        $TermsAndConditions = TermsAndConditions::first();





        return view("terms",compact('TermsAndConditions'));


}

}
