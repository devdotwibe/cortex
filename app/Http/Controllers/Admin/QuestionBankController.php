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

class QuestionBankController extends Controller
{

    use ResourceController;
    public function index(Request $request)
    {
        self::reset();
        self::$model = Category::class;
        self::$routeName = "admin.question-bank";
        $categorys = $this->buildResult();

        $exam = Exam::where("name", 'question-bank')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Question Bank",
                "name" => "question-bank",
            ]);
            $exam = Exam::find($exam->id);
        }

        return view("admin.question-bank.index", compact('categorys', 'exam'));
    }
    public function subtitle(Request $request)
    {
        $data = $request->validate([
            "exam_id" => ['required'],
            "category_id" => ['required'],
            "title" => ['required'],
        ]);
        $icon = $request->icon;
        if (!empty($icon)) {
            $data['icon'] = $icon == "delete" ? "" : $icon;
        }
        $categorytitle = ExamCategoryTitle::where('exam_id', $data['exam_id'])->where('category_id', $data['category_id'])->first();
        if (empty($categorytitle)) {
            $categorytitle = ExamCategoryTitle::store($data);
        } else {
            $categorytitle->update($data);
        }
        if (!empty($icon)) {
            $data['icon'] = $icon == "delete" ? "" : url('d0/' . $icon);
        }
        return $data;
    }

    public function show(Request $request, Setname $setname)
    {
        self::reset();
        self::$model = Question::class;
        self::$routeName = "admin.question";
        self::$defaultActions = ["delete"];

        $exam = Exam::where("name", 'question-bank')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Question Bank",
                "name" => "question-bank",
            ]);
            $exam = Exam::find($exam->id);
        }

        if ($request->ajax()) {

            $this->orderBy('order_no', 'ASC');

            $examCount = Question::where('exam_id',$exam->id??0)->where('category_id',$setname->category_id)->where('sub_category_id', $setname->sub_category_id)->where('sub_category_set', $setname->id)->count();

            return  $this->where('exam_id', $exam->id)->where('category_id', $setname->category_id)->where('sub_category_id', $setname->sub_category_id)->where('sub_category_set', $setname->id)
            ->addAction(function ($data) use ($setname,$examCount) {

                $button = '';  
                $selected ="";
                $results = "";
                for ($i = 1; $i <= $examCount; $i++) {
                    $selected = ($data->order_no == $i) ? 'selected' : ''; 
                    $results .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                }

                $button .= '<select name="work_update_coordinator" onchange="OrderChange(this)" data-type="question_bank" data-id="' . $data->id . '" data-exam="' . $data->exam_id . '" data-category="' . $data->category_id . '" data-subcategory="' . $data->sub_category_id . '"  data-subcategoryset="' . $data->sub_category_set . '" data-homeworkbook="" >'; 
                $button .= $results;
                $button .= '</select>';

                return '
                   
                   <a href="' . route("admin.question-bank.edit", ["setname" => $setname->slug, "question" => $data->slug]) . '" class="btn btn-icons edit_btn">
                        <span class="adminside-icon">
                        <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
                        </span>
                    </a>

                     ' . $button . '

                    ';
            })->addColumn('visibility', function ($data) {
                return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="' . ($data->id) . '" ' . ($data->visible_status == "show" ? "checked" : "") . ' onchange="visiblechangerefresh(' . "'" . route("admin.question.visibility", $data->slug) . "'" . ')" > 
                        </div>
                    ';
            })
                ->buildTable(['description', 'visibility']);
        }
        $category = Category::find($setname->category_id);
        $subcategory = SubCategory::find($setname->sub_category_id);
        return view("admin.question-bank.show", compact('category', 'subcategory', 'setname', 'exam'));
    }
    public function create(Request $request, Setname $setname)
    {

        $exam = Exam::where("name", 'question-bank')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Question Bank",
                "name" => "question-bank",
            ]);
            $exam = Exam::find($exam->id);
        }
        $category = Category::find($setname->category_id);
        $subcategory = SubCategory::find($setname->sub_category_id);
        return view("admin.question-bank.create", compact('category', 'subcategory', 'setname', 'exam'));
    }

    public function edit(Request $request, Setname $setname, Question $question)
    {
        $exam = Exam::where("name", 'question-bank')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Question Bank",
                "name" => "question-bank",
            ]);
            $exam = Exam::find($exam->id);
        }
        $category = Category::find($setname->category_id);
        $subcategory = SubCategory::find($setname->sub_category_id);

        return view("admin.question-bank.edit", compact('category', 'subcategory', 'setname', 'exam', 'question'));
    }


    public function subcategory(Request $request, Category $category)
    {
        $subcategory = [];
        $category->with('category');
        foreach ($category->subcategories as $row) {
            // $sets=[];
            // foreach ($row->setname as $set) {
            //     $set->questionsUrl=route('admin.question-bank.show',$set->slug);
            //     $sets[]=$set;
            // }
            $row->category_name = $row->category->name;
            $row->subsetUrl = route('admin.set.set_store', $row->slug);
            $row->setUrl = route('admin.question-bank.subcategoryset', $row->slug);
            $subcategory[] = $row;
        }
        return $subcategory;
    }
    public function subcategoryset(Request $request, SubCategory $subCategory)
    {
        $sets = [];
        foreach ($subCategory->setname as $row) {
            $row->questionsUrl = route('admin.question-bank.show', $row->slug);
            $sets[] = $row;
        }
        return $sets;
    }
    public function importquestion(Request $request, Setname $setname)
    {
        $request->validate([
            'import_fields' => ['required'],
            'import_fields.*' => ['required'],
            'import_datas' => ['required', 'file', 'mimes:json']
        ]);

        $file = $request->file('import_datas');
        $name = $file->hashName();
        Storage::put("importfile", $file);

        $exam = Exam::where("name", 'question-bank')->first();
        if (empty($exam)) {
            $exam = Exam::store([
                "title" => "Question Bank",
                "name" => "question-bank",
            ]);
            $exam = Exam::find($exam->id);
        }
        $category = Category::find($setname->category_id);
        $subcategory = SubCategory::find($setname->sub_category_id);

        dispatch(new ImportQuestions(
            filename: $name,
            exam: $exam,
            category: $category,
            subCategory: $subcategory,
            setname: $setname,
            fields: $request->import_fields
        ))->onConnection('sync');

        return response()->json([
            'success' => "Import started"
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
    //         return redirect()->route('admin.question-bank.show')->with("success", "Questions deleted success");
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
    //         return redirect()->route('admin.question-bank.show')->with("success", "Questions update success");
    //     }
    // }


    public function bulkaction(Request $request, Setname $setname)
    {
        if (!empty($request->deleteaction)) {
            // if ($request->input('select_all', 'no') == "yes") {
            //     // Delete all questions corresponding to the specific setname
            //     Question::where('sub_category_set', $setname->id)->delete();
            // } else {
            //     // Delete selected questions only
            //     Question::whereIn('id', values: $request->input('selectbox', []))->delete();
            // }

            $admin = Auth::guard('admin')->user();                                
            Question::whereIn('id', $request->input('selectbox', []))
                    ->update(['admin_id' => $admin->id]); 
                    
            $questions =  Question::whereIn('id',$request->input('selectbox', []))->orderBy('order_no','asc')->get();

            $firstquestion = $questions->first();

            Question::whereIn('id', values: $request->input('selectbox', []))->delete();

            $all_questions = Question::where('category_id', $firstquestion->category_id)->where('sub_category_id', $firstquestion->sub_category_id)
            ->where('sub_category_set', $firstquestion->sub_category_set)
            ->where('exam_id', $firstquestion->exam_id)
            ->get();

            foreach( $all_questions  as $item)
            {
                $question_count = Question::where('order_no','<',$item->order_no)->where('category_id', $item->category_id)
                ->where('sub_category_id', $item->sub_category_id)
                ->where('sub_category_set', $item->sub_category_set)
                ->where('exam_id', $item->exam_id)->count();

                if(!empty($question_count))
                {
                    $item->order_no = $question_count+1; 
                }
                else
                {
                    $item->order_no =1; 
                }

                $item->save();

            } 

            if ($request->ajax()) {
                return response()->json(["success" => "Questions deleted successfully"]);
            }
            return redirect()->route('admin.question-bank.show', $setname->slug)
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

            // if ($request->input('select_all', 'no') == "yes") {
            //     // Update visibility status for all questions corresponding to the specific setname
            //     Question::where('sub_category_set', $setname->id)->update($data);
            // } else {
            //     // Update visibility status for selected questions only
            //     Question::whereIn('id', $request->input('selectbox', []))->update($data);
            // }
            Question::whereIn('id', $request->input('selectbox', []))->update($data);

            if ($request->ajax()) {
                return response()->json(["success" => "Questions updated successfully"]);
            }
            return redirect()->route('admin.question-bank.show', $setname->slug)
                ->with("success", "Questions updated successfully");
        }
    }
}
