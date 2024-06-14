<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Learn;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class LearnTopicController extends Controller
{
    use ResourceController; 

    function __construct()
    {
        self::$model = Learn::class; 
    } 
    
    public function index(Request $request){
        self::reset();
        self::$model = Category::class; 

        $categorys=$this->buildResult();
      
        return view("user.learn.index",compact('categorys'));
    }
}
