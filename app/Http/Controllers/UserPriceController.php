<?php

namespace App\Http\Controllers;
use App\Models\SubscriptionPlan;

use Illuminate\Http\Request;

class UserPriceController extends Controller
{

    public function index(Request $request){
        $SubscriptionPlan = SubscriptionPlan::first();

     return view("price",compact('SubscriptionPlan'));
}

}


