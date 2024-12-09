<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ImportQuestions;
use App\Models\Category;
use App\Models\Exam;
use App\Models\ExamCategoryTitle;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TopicTestController extends Controller
{
    
    use ResourceController; 
    public function index(Request $request){
        self::reset();
        self::$model = Category::class;
        self::$routeName = "admin.topic-test"; 
        $categorys=$this->buildResult();
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        return view("admin.topic-test.index",compact('categorys','exam'));
    }
    public function show(Request $request,Category $category){
        self::reset();
        self::$model = Question::class;
        self::$routeName = "admin.question"; 
        self::$defaultActions=["delete"];
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }
        if($request->ajax()){
            if(!empty($request->sub_category_id)){
                $this->where('sub_category_id',$request->sub_category_id);
            }
            $this->orderBy('order_no', 'ASC');

            
            $examCount = Question::where('category_id',$category->id)->where('exam_id',$exam->id??0)->count();

            return $this->where('exam_id',$exam->id)
                ->where('category_id',$category->id)

                ->addAction(function($data)use($category,$examCount){

                    $button = '';  

                    $selected ="";

                $results = "";

                for ($i = 1; $i <= $examCount; $i++) {

                    $selected = ($data->order_no == $i) ? 'selected' : ''; 

                    $results .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                }

                $button .= '<select name="work_update_coordinator" onchange="OrderChange(this)" data-type="topic_test" data-id="' . $data->id . '" data-exam="' . $data->exam_id . '" data-category="' . $data->category_id . '" data-subcategory=""  data-subcategoryset=""  data-homeworkbook="" >'; 
                $button .= $results;
                $button .= '</select>';

                
                    return '
                   
                        <a href="'.route("admin.topic-test.edit",["category"=>$category->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
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
        return view("admin.topic-test.show",compact('category','exam'));
    }
    public function create(Request $request,Category $category){ 
        if($request->ajax()){
            $name=$request->name??"";
            if($name=="sub_category_set"){
                self::reset();
                self::$model = Setname::class; 
                return $this->where('sub_category_id',$request->parent_id??0)/*->where('category_id',$category->id)*/->buildSelectOption();
            }else{
                self::reset();
                self::$model = SubCategory::class; 
                return $this->where('category_id',$category->id)->buildSelectOption();
            }
        } 
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        return view("admin.topic-test.create",compact('category','exam'));
    } 

    public function edit(Request $request,Category $category,Question $question){ 

        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        }

        if($request->ajax()){
            $name=$request->name??"";
            if($name=="sub_category_set"){
                self::reset();
                self::$model = Setname::class; 
                return $this->where('sub_category_id',$request->parent_id??0)/*->where('category_id',$category->id)*/->buildSelectOption();
            }
            elseif($name=="order_no"){
                self::reset();
                self::$model = Question::class; 

                $examCount = Question::where('category_id',$category->id)->where('exam_id',$exam->id??0)->count();

                $exams= Question::where('category_id',$category->id)->where('exam_id',$exam->id??0)->get();
                $results= [];

                foreach($exams as $k=> $item)
                {
                    $results[] = [
                        'id' => $k+1, 
                        'text' => $k+1
                    ];
                }

                return [
                    'results' => $results
                ];

            }else{
                self::reset();
                self::$model = SubCategory::class; 
                return $this->where('category_id',$category->id)->buildSelectOption();
            }
        } 
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        if($question->order_no === '9999999999')
        {
            $question->order_no="";
        }
        return view("admin.topic-test.edit",compact('category','exam','question'));
    }
    public function subtitle(Request $request){
        $data=$request->validate([
            "exam_id"=>['required'],
            "category_id"=>['required'],
            "title"=>['required'],
        ]);
        $icon=$request->icon;
        if(!empty($icon)){
            $data['icon']=$icon=="delete"?"":$icon;
        }
        $categorytitle=ExamCategoryTitle::where('exam_id',$data['exam_id'])->where('category_id',$data['category_id'])->first();
        if(empty($categorytitle)){
            $categorytitle=ExamCategoryTitle::store($data);
        }else{
            $categorytitle->update($data);
        }
        if(!empty($icon)){
            $data['icon']=$icon=="delete"?"":url('d0/'.$icon);
        }
        return $data;
    }
    public function updatetime(Request $request,Category $category){
        $data=$request->validate([
            'time_of_exam'=>[
                'required',
                function ($attribute, $value, $fail) {
                    $validTimeFormat = '/^(0[0-9]|1[0-9]|2[0-3]) ?: ?[0-5][0-9]$/';

                    if (!preg_match($validTimeFormat, $value) || $value === '00:00' || $value === '00 : 00') {
                        $fail('The time of exam must not be 00:00.');
                    }
                },
            ],
        ]);
     
        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        $category->update($data); 
       
        return redirect()->back()->with("success","Topic Test Time has been successfully updated");
    }


    public function importquestion(Request $request,Category $category){
        $request->validate([
            'import_fields'=>['required'],
            'import_fields.*'=>['required'],
            'import_datas'=>['required','file','mimes:json']
        ]);
 
        $file = $request->file('import_datas');
        $name = $file->hashName();
        Storage::put("importfile", $file);

        $exam=Exam::where("name",'topic-test')->first();
        if(empty($exam)){
            $exam=Exam::store([
                "title"=>"Topic Test",
                "name"=>"topic-test",
            ]);
            $exam=Exam::find( $exam->id );
        } 
        
        dispatch(new ImportQuestions(
            filename:$name,
            exam:$exam,
            category:$category,
            fields:$request->import_fields
        ));

        return response()->json([
            'success'=>"Import started"
        ]);
    } 

    // public function bulkaction(Request $request)
    // {
    //     if (!empty($request->deleteaction)) {
    //         if ($request->input('select_all', 'no') == "yes") {
    //             Question::where('id', '>', 0)->delete();
    //         } else {
    //             Question::whereIn('id', $request->input('selectbox', []))->delete();
    //         }
    //         if ($request->ajax()) {
    //             return response()->json(["success" => "Questions deleted success"]);
    //         }
    //         return redirect()->route('admin.topic-test.show')->with("success", "Questions deleted success");
    //     } else {
    //         $request->validate([
    //             "bulkaction" => ['required']
    //         ]);
    //         $data = [];

    //         switch ($request->bulkaction) {
              
    //             case 'visible_status':
    //                 $data["visible_status"] = "show";
    //                 break;
    //             case 'visible_status_disable':
    //                 $data["visible_status"] = "";
    //                 break;
                

    //             default:
    //                 # code...
    //                 break;
    //         }
    //         if ($request->input('select_all', 'no') == "yes") {
    //             Question::where('id', '>', 0)->update($data);
    //         } else {
    //             Question::whereIn('id', $request->input('selectbox', []))->update($data);
    //         }

    //         if ($request->ajax()) {
    //             return response()->json(["success" => "Questions update success"]);
    //         }
    //         return redirect()->route('admin.topic-test.show')->with("success", "Questions update success");
    //     }
    // }




    public function bulkaction(Request $request, Category $category ,Exam $exam)
    {
        if (!empty($request->deleteaction)) {
            if ($request->input('select_all', 'no') == "yes") {
               
                $admin = Auth::guard('admin')->user();
                                
                Question::where('exam_id', $exam->id)->where('category_id',$request->category)
                ->update(['admin_id' => $admin->id]);
                
                Question::where('category_id', $category->id)
                        ->where('exam_id',$exam->id)
                        ->delete();
            } else {

                $admin = Auth::guard('admin')->user();
                                
                Question::whereIn('id', $request->input('selectbox', []))
                ->update(['admin_id' => $admin->id]);
                
                Question::whereIn('id', $request->input('selectbox', []))->delete();
            }
    
            if ($request->ajax()) {
                return response()->json(["success" => "Questions deleted successfully"]);
            }
            return redirect()->route('admin.topic-test.show', $category->slug)
                             ->with("success", "Questions deleted successfully");
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
                    break;
            }
    
            if ($request->input('select_all', 'no') == "yes") {
                // Update visibility status for all questions corresponding to the specific setname
                Question::where('category_id', $category->id)
                        ->where('exam_id',$exam->id)
                        ->update($data);
            } else {
                // Update visibility status for selected questions only
                Question::whereIn('id', $request->input('selectbox', []))->update($data);
            }
    
            if ($request->ajax()) {
                return response()->json(["success" => "Questions updated successfully"]);
            }
            return redirect()->route('admin.topic-test.show', $category->slug)
                             ->with("success", "Questions updated successfully");
        }
    }

    



}
