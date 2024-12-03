<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeWork;
use App\Models\HomeWorkAnswer;
use App\Models\HomeWorkBook;
use App\Models\HomeWorkQuestion;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeWorkController extends Controller
{
    use ResourceController;
    public function show(Request $request, HomeWork $homeWork)
    {
        self::reset();
        self::$model = HomeWorkQuestion::class;
        self::$routeName = "admin.home-work";
        self::$defaultActions = [''];
        if ($request->ajax()) {
            if (!empty($request->booklet)) {
                $this->where('home_work_book_id', $request->booklet);
            }

            $this->orderBy('order_no', 'ASC');

            $examCount = HomeWorkQuestion::where('home_work_id',$homeWork->id)->count();

            return $this->where('home_work_id', $homeWork->id)

                ->addAction(function ($data) use ($homeWork,$examCount) {

                    $button = '';  

                    $selected ="";

                $results = "";

                for ($i = 1; $i <= $examCount; $i++) {

                    $selected = ($data->order_no == $i) ? 'selected' : ''; 

                    $results .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                }

                $button .= '<select name="work_update_coordinator" onchange="OrderChange(this)" data-type="home_work" data-id="' . $data->id . '" data-exam="" data-category="' . $data->home_work_id . '" data-subcategory=""  data-subcategoryset="" >'; 
                $button .= $results;
                $button .= '</select>';

                    return '
                   
                    <a href="' . route("admin.home-work.edit", ["home_work" => $homeWork->slug, "home_work_question" => $data->slug]) . '" class="btn btn-icons edit_btn">
                        <span class="adminside-icon">
                        <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
                        </span>
                    </a>


                     <a  class="btn btn-icons dlt_btn" data-delete="' . route("admin.home-work.destroy", ["home_work" => $homeWork->slug, "home_work_question" => $data->slug]) . '">
                            <span class="adminside-icon">
                                <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active" title="Delete">
                            </span>
                        </a> 

                         ' . $button . '

                    ';
                })->addColumn('visibility', function ($data) use ($homeWork) {
                    return '                
                        <div class="form-check ">
                            <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="' . ($data->id) . '" ' . ($data->visible_status == "show" ? "checked" : "") . ' onchange="visiblechangerefresh(' . "'" . route("admin.home-work.visibility", ["home_work" => $homeWork->slug, "home_work_question" => $data->slug]) . "'" . ')" > 
                        </div>
                    ';
                })
                ->addColumn('question', function ($data) use ($homeWork) {

                    if ($data->home_work_type == 'mcq') {
                        return $data->description;
                    } else {
                        return $data->short_question;
                    }
                })


                ->buildTable(['visibility', 'question']);
        }
        return view('admin.home-work.show', compact('homeWork'));
    }
    public function create(Request $request, HomeWork $homeWork)
    {
        if ($request->ajax()) {
            self::reset();
            self::$model = HomeWorkBook::class;
            return $this->where('home_work_id', $homeWork->id)->buildSelectOption('title');
        }
        return view('admin.home-work.create', compact('homeWork'));
    }
    public function edit(Request $request, HomeWork $homeWork, HomeWorkQuestion $homeWorkQuestion)
    {
        if ($request->ajax()) {
            self::reset();
            self::$model = HomeWorkBook::class;
            return $this->where('home_work_id', $homeWork->id)->buildSelectOption('title');
        }
        return view('admin.home-work.edit', compact('homeWork', 'homeWorkQuestion'));
    }
    public function update(Request $request, HomeWork $homeWork, HomeWorkQuestion $homeWorkQuestion)
    {

        switch ($request->input('home_work_type', "")) {

            case 'short_notes':
                $data = $request->validate([
                    "home_work_book_id" => ['required'],
                    "short_question" => ['required'],
                    "short_answer" => ["required"],
                ]);
                break;
            case 'mcq':
                // dd($request);
                $data = $request->validate([
                    "home_work_book_id" => ['required'],
                    "description" => ['required'],
                    "answer" => ['required'],
                   "answer.*" => ["required_without_all:choice_answer_image.*,file_answer.*", 'string', 'max:150', 'nullable'],
                  

                    "file_answer.*" => ["required_without_all:answer.*,choice_answer_image.*", 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    "explanation" => ['nullable']
                ], [
                    'answer.*.required_without_all' => 'The answer field is required when file answer is not provided.',
                    'file_answer.*.required_without_all' => 'The file answer is required when answer is not provided.',
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;

            default:
                $data = $request->validate([
                    "home_work_book_id" => ['required'],
                    "title" => ['required'],
                    "home_work_type" => ["required"],
                ]);
                break;
        }

        $data['title'] = $request->title;
        $data['home_work_id'] = $homeWork->id;
        $data['home_work_type'] = $request->home_work_type;
        $homeWorkQuestion->update($data);
        $ansIds = [];
        $featureimages = $request->file('file_answer', []);
        foreach ($request->answer as $k => $ans) {
            $answer = null;
            $imageName = Null;
            $image = Null;
            if (isset($featureimages[$k])) {
                $featureImage = $featureimages[$k];
                $featureImageName = "questionimages/" . $featureImage->hashName();
                Storage::put('questionimages', $featureImage);
                $imageName = $featureImageName;
            }
            if (!empty($request->choice_answer_id[$k] ?? "")) {
                $answer = HomeWorkAnswer::find($request->choice_answer_id[$k] ?? "");
            }
            if (!empty($request->choice_answer_image[$k] ?? "")) {
                $image = $request->choice_answer_image[$k];
            }
            if (empty($answer)) {
                $answer = HomeWorkAnswer::store([
                    "home_work_id" => $homeWork->id,
                    "home_work_book_id" => $homeWorkQuestion->home_work_book_id,
                    "home_work_question_id" => $homeWorkQuestion->id,
                    "iscorrect" => $k == ($request->choice_answer ?? 0) ? true : false,
                    "title" => $ans,
                    "image" => $imageName
                ]);

            } else {
                $data = [
                    "home_work_id" => $homeWork->id,
                    "home_work_book_id" => $homeWorkQuestion->home_work_book_id,
                    "home_work_question_id" => $homeWorkQuestion->id,
                    "iscorrect" => $k == ($request->choice_answer ?? 0) ? true : false,
                    "title" => $ans
                ];
                if (!$image) {
                    $data['image'] = Null;
                }
                if (isset($imageName)) {
                    $data['image'] = $imageName;
                }
                $answer->update($data);
            }
            $ansIds[] = $answer->id;
        }
        HomeWorkAnswer::where('home_work_question_id', $homeWorkQuestion->id)->whereNotIn('id', $ansIds)->delete();
        $redirect = $request->redirect ?? route('admin.home-work.show', $homeWork->slug);
        return redirect($redirect)->with("success", "Question has been successfully updated");
    }
    public function store(Request $request, HomeWork $homeWork)
    {

        switch ($request->input('home_work_type', "")) {

            case 'short_notes':
                $data = $request->validate([
                    "home_work_book_id" => ['required'],
                    "short_question" => ['required'],
                    "short_answer" => ["required"],
                ]);
                break;
            case 'mcq':
                $data = $request->validate([
                    "home_work_book_id" => ['required'],
                    "description" => ['required'],
                    "answer" => ['required'],
                    "answer.*" => ["required_without:file_answer", 'string', 'max:150', 'nullable'],
                    "file_answer.*" => ["required_without:answer", 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                    "explanation" => ['nullable']
                ], [
                    'answer.*.required_without' => 'The answer field is required when file answer is not provided.',
                    'file_answer.*.required_without' => 'The file answer is required when answer is not provided.',
                    'file_answer.*.mimes' => 'Each file answer must be an image (jpeg, png, jpg, gif).',
                ]);
                break;

            default:
                $data = $request->validate([
                    "home_work_book_id" => ['required'],
                    "title" => ['required'],
                    "home_work_type" => ["required"],
                ]);
                break;
        }

        $question_count = HomeWorkQuestion::where('home_work_id', $homeWork->id)->count();

        
        if(!empty($question_count))
        {
            $data['order_no'] = $question_count+1; 
        }
        else
        {
            $data['order_no'] = 1; 
        }

        $data['title'] = $request->title;
        $data['home_work_id'] = $homeWork->id;
        $data['home_work_type'] = $request->home_work_type;
        $question = HomeWorkQuestion::store($data);

        if ($request->home_work_type === "mcq") {

            $featureimages = $request->file('file_answer', []);
            foreach ($request->answer as $k => $ans) {
                $imageName = "";
                if (isset($featureimages[$k])) {
                    $featureImage = $featureimages[$k];
                    $featureImageName = "questionimages/" . $featureImage->hashName();
                    Storage::put('questionimages', $featureImage);
                    $imageName = $featureImageName;
                }
                HomeWorkAnswer::store([
                    "home_work_id" => $homeWork->id,
                    "home_work_book_id" => $question->home_work_book_id,
                    "home_work_question_id" => $question->id,
                    "iscorrect" => $k == ($request->choice_answer ?? 0) ? true : false,
                    "title" => $ans,
                    'image' => $imageName,
                ]);
            }
        }
        $redirect = $request->redirect ?? route('admin.home-work.show', $homeWork->slug);
        return redirect($redirect)->with("success", "Question has been successfully created");
    }
    public function destroy(Request $request, HomeWork $homeWork, HomeWorkQuestion $homeWorkQuestion)
    {
        $admin = Auth::guard('admin')->user();
        
        $homeWorkQuestion->admin_id = $admin->id;

        $homeWorkQuestion->save();
        
        $homeWorkQuestion->delete();
        if ($request->ajax()) {
            return response()->json(["success" => "Question has been deleted"]);
        }
        return redirect()->route('admin.home-work.show', $homeWork->slug)->with("success", "Question has been deleted");
    }
    public function storebooklet(Request $request)
    {
        $data = $request->validate([
            'home_work' => ['required'],
            'title' => ['required'],
        ]);
        $homeWork = HomeWork::findSlug($data['home_work']);
        $data['home_work_id'] = $homeWork->id;
        HomeWorkBook::store($data);
        if ($request->ajax()) {
            return response()->json(["success" => "Week Booklet has been successfully created"]);
        }
        return redirect()->route('admin.live-class.private_class_create')->with("success", "Week Booklet has been successfully created");
    }
    public function updatebooklet(Request $request, HomeWorkBook $homeWorkBook)
    {
        $data = $request->validate([
            'title' => ['required'],
        ]);
        $homeWorkBook->update($data);
        if ($request->ajax()) {
            return response()->json(["success" => "Week Booklet has been successfully created"]);
        }
        return redirect()->route('admin.live-class.private_class_create')->with("success", "Week Booklet has been successfully created");
    }
    public function showbooklet(Request $request, HomeWorkBook $homeWorkBook)
    {
        $homeWorkBook->updateUrl = route('admin.home-work.updatebooklet', $homeWorkBook->slug);
        return $homeWorkBook;
    }
    public function destroybooklet(Request $request, HomeWorkBook $homeWorkBook)
    {
        $homeWorkBook->delete();
        if ($request->ajax()) {
            return response()->json(["success" => "{$homeWorkBook->title} has been deleted"]);
        }
        return redirect()->route('admin.live-class.private_class_create')->with("success", "{$homeWorkBook->title} has been deleted");
    }
    public function questionvisibility(Request $request, HomeWork $homeWork, HomeWorkQuestion $homeWorkQuestion)
    {
        $homeWorkQuestion->update(['visible_status' => ($homeWorkQuestion->visible_status ?? "") == "show" ? "hide" : "show"]);
        if ($request->ajax()) {
            return response()->json(["success" => " Question visibility change success"]);
        }
        return redirect()->route('admin.home-work.show', $homeWork->slug)->with("success", " Question visibility change success");
    }


    //     public function bulkaction(Request $request, HomeWorkQuestion $homeWork)
// {

    //     if (!empty($request->deleteaction)) {
//         if ($request->input('select_all', 'no') == "yes") {
//             // Delete all questions corresponding to the specific setname
//             HomeWorkQuestion::where('home_work_id', $homeWork->id)->delete();
//         } else {
//             // Delete selected questions only
//             HomeWorkQuestion::whereIn('id', $request->input('selectbox', []))->delete();
//         }

    //         if ($request->ajax()) {
//             return response()->json(["success" => "Questions deleted successfully"]);
//         }
//         return redirect()->route('admin.home-work.show', $homeWork->slug)
//                          ->with("success", "Questions deleted successfully");
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
//                 break;
//         }

    //         if ($request->input('select_all', 'no') == "yes") {
//             // Update visibility status for all questions corresponding to the specific setname
//             HomeWorkQuestion::where('home_work_id', $homeWork->id)->update($data);
//         } else {
//             // Update visibility status for selected questions only
//             HomeWorkQuestion::whereIn('id', $request->input('selectbox', []))->update($data);
//         }

    //         if ($request->ajax()) {
//             return response()->json(["success" => "Questions updated successfully"]);
//         }
//         return redirect()->route('admin.home-work.show', $homeWork->slug)
//                          ->with("success", "Questions updated successfully");
//     }
// }


    public function bulkaction(Request $request, HomeWork $homeWork)
    {
        $booklet = $request->input('home_work_book_id');

        if (!empty($request->deleteaction)) {

            if ($request->input('select_all', 'no') == "yes") {


                $selectAllValues = json_decode($request->select_all_values, true);

                HomeWorkQuestion::whereIn('id', $selectAllValues)
                    ->delete();



            } else {

                $selectBoxValues = is_array($request->input('selectbox', [])) ? $request->input('selectbox', []) : [];


                HomeWorkQuestion::whereIn('id', $selectBoxValues)
                    ->where('home_work_id', $homeWork->id)
                    ->where('home_work_book_id', $booklet)
                    ->delete();
            }

            if ($request->ajax()) {
                return response()->json(["success" => "Questions deleted successfully"]);
            }
            return redirect()->route('admin.home-work.show', $homeWork->slug)
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



            if ($request->ajax()) {
                return response()->json(["success" => "Questions updated successfully"]);
            }
            return redirect()->route('admin.home-work.show', $homeWork->slug)
                ->with("success", "Questions updated successfully");
        }
    }




}
