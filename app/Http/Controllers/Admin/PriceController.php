<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\banner;
class PriceController extends Controller
{
    public function index()
    {

        $banner = Banner::first();

        return view('admin.price.index',compact('banner'));
    }
}
