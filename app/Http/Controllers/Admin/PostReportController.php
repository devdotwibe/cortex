<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportPost;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class PostReportController extends Controller
{
    use ResourceController;

    public function __construct(){
        self::$model=ReportPost::class;
        self::$defaultActions=[''];
    }
    public function index(Request $request){
        if($request->ajax()){
            return $this->buildTable();
        }
        return view('admin.report-post.index');
    }
}
