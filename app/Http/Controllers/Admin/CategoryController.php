<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model=Category::class;
        self::$routeName="admin.options";
    }
    
    
    public function index()
    {
        return view('admin.options.index');
    }
}
