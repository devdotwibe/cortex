<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ImportQuestions;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Question;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FullMockExamController extends Controller
{
    
    use ResourceController;
    function __construct()
    {
        self::$model=Question::class;
        self::$routeName="admin.question";
    } 

    public function index(Request $request,Exam $exam){ 
        self::$defaultActions=["delete"];

        if($request->ajax()){

            if(!empty($request->category)){

                $this->where('category_id',$request->category);
            }
        
            $this->orderBy('order_no', 'ASC');

            $examCount = Question::where('exam_id',$exam->id??0)->count();

            return $this->where('exam_id',$exam->id) 

                ->addAction(function($data)use($exam,$examCount){

                    $button = '';  

                    $selected ="";

                    $results = "";

                    for ($i = 1; $i <= $examCount; $i++) {

                        $selected = ($data->order_no == $i) ? 'selected' : ''; 

                        $results .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                    }

                    $button .= '<select name="work_update_coordinator" onchange="OrderChange(this)" data-type="full_mock" data-id="' . $data->id . '" data-exam="' . $data->exam_id . '" data-category="' . $data->category_id . '" data-subcategory=""  data-subcategoryset="" data-homeworkbook="">'; 
                    $button .= $results;
                    $button .= '</select>';
                    
                    return '
                    

                <a href="'.route("admin.full-mock-exam.edit",["exam"=>$exam->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
                    <span class="adminside-icon">
                    <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                    </span>
                    <span class="adminactive-icon">
                        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
                    </span>
                </a>

                 ' . $button . '


                    ';
                })->addColumn('visibility',function($data){
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="'.($data->id).'" '.($data->visible_status=="show"?"checked":"").' onchange="visiblechangerefresh('."'".route("admin.question.visibility",$data->slug)."'".')" > 
                        </div>
                    ';
                })
                ->buildTable(['description','visibility']);
        } 
        return view("admin.full-mock-exam.index",compact('exam'));
    }
    public function create(Request $request,Exam $exam){
        if($request->ajax()){
            $name=$request->name??"";
            if($name=="category_id"){
                self::reset();
                self::$model = Category::class; 
                return $this->buildSelectOption();
            }else{
                self::reset();
                self::$model = SubCategory::class; 
                return $this->where('category_id',$request->parent_id??0)->buildSelectOption();
            }
        }  
        return view("admin.full-mock-exam.create",compact('exam'));
    }

    public function edit(Request $request,Exam $exam,Question $question){ 
        if($request->ajax()){
            $name=$request->name??"";
            if($name=="category_id"){
                self::reset();
                self::$model = Category::class; 
                return $this->buildSelectOption();
            }else{
                self::reset();
                self::$model = SubCategory::class; 
                return $this->where('category_id',$request->parent_id??0)->buildSelectOption();
            }
        }  
        return view("admin.full-mock-exam.edit",compact('exam','question'));
    }


    public function importquestion(Request $request,Exam $exam){ 
        $request->validate([
            'import_fields'=>['required'],
            'import_fields.*'=>['required'],
            'import_datas'=>['required','file','mimes:json']
        ]);
 
        $file = $request->file('import_datas');
        $name = $file->hashName();
        Storage::put("importfile", $file); 
          
        dispatch(new ImportQuestions(
            filename:$name,
            exam:$exam, 
            fields:$request->import_fields
        ));

        return response()->json([
            'success'=>"Import started"
        ]);
    } 


    public function bulkaction(Request $request,Exam $exam)
    {
        if (!empty($request->deleteaction)) {
            // if ($request->input('select_all', 'no') == "yes") {

            //     if($request->category){

                    
            //     $admin = Auth::guard('admin')->user();
                                
            //     Question::where('exam_id', $exam->id)->where('category_id',$request->category)
            //     ->update(['admin_id' => $admin->id]);

            //         Question::where('exam_id', $exam->id)
            //                 ->where('category_id',$request->category)
            //                 ->delete();     
            //     }else{

            //         $admin = Auth::guard('admin')->user();
                                
            //         Question::where('exam_id', $exam->id)
            //         ->update(['admin_id' => $admin->id]);

            //         Question::where('exam_id', $exam->id)->delete();     
            //     }
            // } else {

            //     $admin = Auth::guard('admin')->user();
                                
            //     Question::whereIn('id', $request->input('selectbox', []))
            //     ->update(['admin_id' => $admin->id]);

            //     Question::whereIn('id', $request->input('selectbox', []))->delete();
            // }
                $admin = Auth::guard('admin')->user();                               
                Question::whereIn('id', $request->input('selectbox', []))
                        ->update(['admin_id' => $admin->id]);
                Question::whereIn('id', $request->input('selectbox', []))->delete();

            if ($request->ajax()) {
                return response()->json(["success" => "Questions deleted success"]);
            }
            return redirect()->route('admin.full-mock-exam.index')->with("success", "Questions deleted success");
        } else {
            $request->validate([
                "bulkaction" => ['required']
            ]);
            $data = [];

            switch ($request->bulkaction) {
              
                case 'visible_status':
                    $data["visible_status"] = "show";
                    break;
                case 'visible_status_disable':
                    $data["visible_status"] = "";
                    break;
                

                default:
                    # code...
                    break;
            }
            // if ($request->input('select_all', 'no') == "yes") {
            //     if($request->category){
            //         Question::where('exam_id', $exam->id)
            //                 ->where('category_id',$request->category)
            //                 ->update($data);
            //     }else{
            //         Question::where('exam_id', $exam->id)->update($data);
            //     }
            // } else {
            //     Question::whereIn('id', $request->input('selectbox', []))->update($data);
            // }
            Question::whereIn('id', $request->input('selectbox', []))->update($data);
            if ($request->ajax()) {
                return response()->json(["success" => "Questions update success"]);
            }
            return redirect()->route('admin.full-mock-exam.index')->with("success", "Questions update success");
        }
    }
}
