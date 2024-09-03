<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    
    use ResourceController;

    function __construct()
    {
        self::$model=Exam::class;
        self::$routeName="admin.course";
    } 

    public function index(Request $request)
    {
       
        return view("admin.pages.course");
    }
}
