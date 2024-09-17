<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;

class UserCourseController extends Controller
{

    public function index(Request $request){

        $course = Courses::first();





        return view("course",compact('course'));


}



public function submit(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'email' => 'required|email:rfc,dns',
            'message' => 'required|string',
        ]);

        $admin_mail = Settings::first();

        Mail::to($admin_mail->emailaddress)->send(new ContactMail([

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'message' => $request->message,

        ]));


        return response()->json([
            'success' => 'Form submitted successfully!'
        ]);
    }

}
