<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

class UserCourseController extends Controller
{

    public function index(Request $request){

        $course = Courses::first();





        return view("course",compact('course'));


}
}
