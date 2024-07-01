<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function index(){
    return view('admin.settings.index');
}
public function store(Request $request){

    $settings  =new Settings();
    $settings->amount = $request->amount;
     if($settings->save()){
    return response()->json(['status' => 'success', 'message' => 'Amount added successfully']);
     }
     else{
        return response()->json(['status'=>'error','message'=>'failure']);
     }
}
}
