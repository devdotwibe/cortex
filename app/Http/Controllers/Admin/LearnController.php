<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\LearnAnswer;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LearnController extends Controller
{

    use ResourceController;

    function __construct()
    {
        self::$model = Learn::class;
        self::$routeName = "admin.learn";
    }

    public function index(Request $request)
    {
        self::reset();

        self::$model = Category::class;
        self::$routeName = "admin.learn";

        $categorys = $this->buildResult();

        $exam = Exam::where("name", 'learn')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Learn",
                "name" => "learn",
            ]);
            $exam = Exam::find($exam->id);
        }
        return view("admin.learn.index", compact('categorys', 'exam'));
    }

    public function show(Request $request, Category $category)
    {

        self::reset();
        self::$model = Learn::class;
        self::$routeName = "admin.learn";
        self::$defaultActions = [];

        if ($request->ajax()) {
            if (!empty($request->sub_category)) {
                $this->where('sub_category_id', $request->sub_category);
            }

            $this->orderBy('order_no', 'ASC');

            $examCount = Learn::where('category_id',$category->id)->count();

            return $this->where('category_id', $category->id)
                ->addAction(function ($data) use ($category,$examCount) {

                    $button = '';  

                    $selected ="";

                $results = "";

                for ($i = 1; $i <= $examCount; $i++) {

                    $selected = ($data->order_no == $i) ? 'selected' : ''; 

                    $results .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                }

                $button .= '<select name="work_update_coordinator" onchange="OrderChange(this)" data-type="learn" data-id="' . $data->id . '" data-exam="" data-category="' . $data->category_id . '" data-subcategory=""  data-subcategoryset="" >'; 
                $button .= $results;
                $button .= '</select>';


                    return '
                  

                     <a href="' . route("admin.learn.edit", ["category" => $category->slug, "learn" => $data->slug]) . '" class="btn btn-icons edit_btn">
                        <span class="adminside-icon">
                        <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
                        </span>
                    </a>


                    
                      <a  class="btn btn-icons dlt_btn" data-delete="' . route("admin.learn.destroy", ["category" => $category->slug, "learn" => $data->slug]) . '">
                            <span class="adminside-icon">
                                <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active" title="Delete">
                            </span>
                        </a> 

                         ' . $button . '

                    ';
                })->addColumn('visibility', function ($data) {
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="' . ($data->id) . '" ' . ($data->visible_status == "show" ? "checked" : "") . ' onchange="visiblechangerefresh(' . "'" . route("admin.learn.visibility", $data->slug) . "'" . ')" > 
                        </div>
                    ';
                })
                ->buildTable(['title', 'visibility']);
        }

        $exam = Exam::where("name", 'learn')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Learn",
                "name" => "learn",
            ]);
            $exam = Exam::find($exam->id);
        }
        return view("admin.learn.show", compact('category', 'exam'));
    }


    public function create(Request $request, Category $category)
    {
        self::reset();
        self::$model = Category::class;
        self::$routeName = "admin.learn";


        if ($request->ajax()) {
            $name = $request->name ?? "";
            if ($name == "sub_category_set") {
                self::reset();
                self::$model = Setname::class;
                return $this->where('sub_category_id', $request->parent_id ?? 0)/*->where('category_id',$category->id)*/->buildSelectOption();
            } else {
                self::reset();
                self::$model = SubCategory::class;
                return $this->where('category_id', $category->id)->buildSelectOption();
            }
        }

        $exam = Exam::where("name", 'learn')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Learn",
                "name" => "learn",
            ]);
            $exam = Exam::find($exam->id);
        }
        return view("admin.learn.create", compact('category', 'exam'));
    }

    public function edit(Request $request, Category $category, Learn $learn)
    {
        self::reset();
        self::$model = Category::class;
        self::$routeName = "admin.learn";
        if ($request->ajax()) {
            $name = $request->name ?? "";
            if ($name == "sub_category_set") {
                self::reset();
                self::$model = Setname::class;
                return $this->where('sub_category_id', $request->parent_id ?? 0)/*->where('category_id',$category->id)*/->buildSelectOption();
            } else {
                self::reset();
                self::$model = SubCategory::class;
                return $this->where('category_id', $category->id)->buildSelectOption();
            }
        }

        $exam = Exam::where("name", 'learn')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Learn",
                "name" => "learn",
            ]);
            $exam = Exam::find($exam->id);
        }
        return view("admin.learn.edit", compact('category', 'learn', 'exam'));
    }


    public function store(Request $request, Category $category)
    {

        switch ($request->input('learn_type', "")) {

            case 'video':
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "video_url" => ['required', 'max:255'],
                ]);
                break;

            case 'notes':
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "note" => ['required'],
                ]);
                break;

            case 'short_notes':
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "short_question" => ['required'],
                    "short_answer" => ["required"],
                ]);
                break;
            case 'mcq':
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "mcq_question" => ['required'],
                    "mcq_answer.*" => ["required_without:file_mcq_answer", 'string', 'max:150','nullable'],
                    "file_mcq_answer.*" => ["required_without:mcq_answer", 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    "explanation" => ['nullable']
                ], [
                    'mcq_answer.*.required_without' => 'The answer field is required when file answer is not provided.',
                    'file_mcq_answer.*.required_without' => 'The file answer is required when answer is not provided.',
                    'file_mcq_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;

            default:
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "title" => ['required'],
                    "learn_type" => ["required"],
                ]);
                break;
        }


        $question_count = Learn::where('category_id', $request->category_id)->count();

        
        if(!empty($question_count))
        {
            $learn_data['order_no'] = $question_count+1; 
        }
        else
        {
            $learn_data['order_no'] = 1; 
        }

        $learn_data['title'] = $request->title;

        $learn_data['learn_type'] = $request->learn_type;

        $learn = Learn::store($learn_data);

        if ($request->learn_type === "mcq") {
            $featureimages = $request->file('file_mcq_answer', []);
            foreach ($request->mcq_answer as $k => $ans) {
                $imageName = "";
        
                if (isset($featureimages[$k])) {
                    $featureImage = $featureimages[$k];
                    $featureImageName = "questionimages/" . $featureImage->hashName();
                    Storage::put('questionimages', $featureImage);
                    $imageName = $featureImageName;
                }
                LearnAnswer::store([
                    "learn_id" => $learn->id,
                    "iscorrect" => $k == ($request->choice_mcq_answer ?? 0) ? true : false,
                    "title" => $ans,
                    'image' => $imageName,

                ]);
            }
        }

        $redirect = $request->redirect ?? route('admin.learn.index');
        return redirect($redirect)->with("success", "Learn has been successfully created");
    }
    public function update(Request $request, Category $category, Learn $learn)
    {

        switch ($request->input('learn_type', "")) {

            case 'video':
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "video_url" => ['required'],
                ]);
                break;

            case 'notes':
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "note" => ['required'],
                ]);
                break;
            case 'short_notes':
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "short_question" => ['required'],
                    "short_answer" => ["required"],
                ]);
                break;

            case 'mcq':
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "mcq_question" => ['required'],
                    "mcq_answer.*" => [ 'string', 'max:150','nullable'],
                    "file_mcq_answer.*" => [ 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048','nullable'],
                    "explanation" => ['nullable']
                ], [
                    'file_mcq_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;

            default:
                $learn_data = $request->validate([
                    "category_id" => ['required'],
                    "sub_category_id" => ['required'],
                    "title" => ['required'],
                    "learn_type" => ["required"],
                ]);
                break;
        }


        $learn_data['title'] = $request->title;

        $learn_data['learn_type'] = $request->learn_type;

        $learn->update($learn_data);

        $ansIds = [];
        if ($request->learn_type === "mcq") {

            $featureimages = $request->file('file_mcq_answer', []);
            foreach ($request->mcq_answer as $k => $ans) {
                $learnAns = null;
                $imageName = Null;
                $image = Null;
                if (!empty($request->choice_mcq_answer_id[$k] ?? "")) {
                    $learnAns = LearnAnswer::find($request->choice_mcq_answer_id[$k]);
                }
                if(!empty($request->choice_mcq_answer_image[$k] ?? "")){
                    $image=$request->choice_mcq_answer_image[$k];
                }
                
                if (isset($featureimages[$k])) {
                    $featureImage = $featureimages[$k];
                    $featureImageName = "questionimages/" . $featureImage->hashName();
                    Storage::put('questionimages', $featureImage);
                    $imageName = $featureImageName;
                }
                if (empty($learnAns)) {
                    $learnAns = LearnAnswer::store([
                        "learn_id" => $learn->id,
                        "iscorrect" => $k == ($request->choice_mcq_answer ?? 0) ? true : false,
                        "title" => $ans,
                        'image' => $imageName,
                    ]);
                } else {
                    $data = [
                        "learn_id" => $learn->id,
                        "iscorrect" => $k == ($request->choice_mcq_answer ?? 0) ? true : false,
                        "title" => $ans
                    ];
                    if(!$image){
                        $data['image']=Null;
                    }
                    if(isset($imageName)){
                        $data['image']=$imageName;
                    }
                    $learnAns->update($data);
                }
                $ansIds[] = $learnAns->id;
            }
        }
        LearnAnswer::where('learn_id', $learn->id)->whereNotIn('id', $ansIds)->delete();

        $redirect = $request->redirect ?? route('admin.learn.index');
        return redirect($redirect)->with("success", "Learn has been successfully updated");
    }
    public function destroy(Request $request, Category $category, Learn $learn)
    {
        LearnAnswer::where('learn_id', $learn->id)->delete();

        $admin = Auth::guard('admin')->user();
        
        $learn->admin_id = $admin->id;

        $learn->save();

        $learn->delete();
        
        if ($request->ajax()) {
            return response()->json(["success" => "Learn has been successfully deleted"]);
        }
        $redirect = $request->redirect ?? route('admin.learn.index');
        return redirect($redirect)->with("success", "Learn has been successfully deleted");
    }

    public function visibility(Request $request, Learn $learn)
    {
        $learn->update(['visible_status' => ($learn->visible_status ?? "") == "show" ? "hide" : "show"]);
        if ($request->ajax()) {
            return response()->json(["success" => "Learn visibility change success"]);
        }
        return redirect()->route('admin.learn.index')->with("success", "Learn visibility change success");
    }


    public function bulkaction(Request $request, Category $category)
    {
       
        $subcategoryId = $request->input('sub_category_id'); 
        
        if (!empty($request->deleteaction)  ) {

            if ($request->input('select_all', 'no') == "yes") {
               
                $selectAllValues = json_decode($request->select_all_values, true);
                
                $admin = Auth::guard('admin')->user();
                                
                Learn::whereIn('id', $selectAllValues)
                ->update(['admin_id' => $admin->id]);

                Learn::whereIn('id', $selectAllValues)  
                    ->delete();

            } else {
               
                $selectBoxValues = is_array($request->input('selectbox', [])) ? $request->input('selectbox', []) : [];
                
                $admin = Auth::guard('admin')->user();

                Learn::whereIn('id', $selectBoxValues)->update(['admin_id' => $admin->id]);
         
                Learn::whereIn('id', $selectBoxValues)->delete();
                   
            }
            
    
            if ($request->ajax()) {
                return response()->json(["success" => "Questions deleted successfully"]);
            }
            return redirect()->route('admin.learn.show', $category->slug)
                             ->with("success", "Questions deleted successfully");
        } else {
            // Handle the bulk actions like visibility update
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
    
            if ($request->ajax()) {
                return response()->json(["success" => "Questions updated successfully"]);
            }
            return redirect()->route('admin.learn.show', $category->slug)
                             ->with("success", "Questions updated successfully");
        }
    }




    
}
