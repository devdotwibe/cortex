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




}
