<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Learn;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model=Learn::class;
        self::$routeName="admin.learn";
    }
    
    function index(Request $request)
    {
        if($request->ajax()){
            return $this->addAction(function($data){

            return '<a onclick="SubCat(\''.route('admin.sub_category_table.show', $data->slug).'\', \''.$data->slug.'\')" class="btn btn-icons view_btn">+</a>';


            })->buildTable();
        }

        return view('admin.learn.index');
    }

    function store(Request $request)
    {
       
        $learn_data = $request->validate([

            "subject"=>"required",
        ]);
        
        $learn = new Learn;

        $learn->store($learn_data);
        
        return response()->json(['success' => 'Module Added Successfully']);

    }

    public function show(Request $request,Learn $learn){

        // dd($learn->slug);
        
        return view("admin.learn.show",compact('learn'));

    }

    public function destroy(Request $request,Learn $exam){ 
        $exam->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Learn deleted success"]);
        }        
        return redirect()->route('admin.learn.index')->with("success","QuestionBankChapter deleted success");
    }

    
    function add_subcatecory(Request $request,$slug)
    {
       
        $sub_data = $request->validate([

            "name"=>"required",
        ]);

        $learn = Learn::where('slug',$slug)->first();

        $sub_data['learn_id'] = $learn->id;
        
        $sub = new SubCategory;

        $sub->store($sub_data);
        
        return response()->json(['success' => 'Sub Category Added Successfully']);

    }

    function sub_category_table(Request $request)

        {
            if($request->ajax()){

                self::$model=SubCategory::class;

                self::$routeName="admin.sub_category_table";

                if(!empty($request->category))
                {
                    $category = Learn::findSlug($request->category);

                    return $this->where('learn_id',$category->id)->buildTable();
                }
                else
                {
                    return $this->buildTable();
                }
               
            }
            
        }
    

}

