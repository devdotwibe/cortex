<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Support\Helpers\OptionHelper;
use App\Trait\ResourceController;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller
{
    use ResourceController;
    function __construct()
    {
        self::$model=Exam::class;
        self::$routeName="admin.exam";
    } 
   

        // if($request->ajax()){

        //     self::$defaultActions=["edit","delete"]; 


        //     $start = $request->get('start');
        //     $limit = $request->get('limit');
    

            // return $this->addAction(function($data){
        //         return '
               

        //         <a data-id="'.$data->slug.'" class="btn btn-icons eye-button" onclick="UploadVideo(this)">
        //                     <span class="adminside-icon">
        //                         <img src="' . asset("assets/images/video-clip-32-regular.svg") . '" alt="View">
        //                     </span>
        //                     <span class="adminactive-icon">
        //                         <img src="' . asset("assets/images/hover-video-clip-32-regular.svg") . '" alt="View Active" title="View">
        //                     </span>
        //          </a>

        //         <a href="'.route("admin.full-mock-exam.index",["exam"=>$data->slug]).'" class="btn btn-icons eye-button">
        //                     <span class="adminside-icon">
        //                         <img src="' . asset("assets/images/icons/mdi_incognito.svg") . '" alt="View">
        //                     </span>
        //                     <span class="adminactive-icon">
        //                         <img src="' . asset("assets/images/iconshover/view-yellow.svg") . '" alt="View Active" title="View">
        //                     </span>
        //          </a>


        //         ';
        //     })->where("name","full-mock-exam")->buildTable();
        // }

        public function index(Request $request){


        $exam = Exam::where('id','>',0);

        if ($request->ajax==true) {

            $exam = Exam::orderBy('id', 'DESC');

            // Apply pagination if request parameters exist
            $exam = $exam->paginate($request->get('limit', 12));  // Default limit is 10 if not provided
        
            // Format the response with pagination details
            return [
                'current_page' => $exam->currentPage(),              
                'total_pages' => $exam->lastPage(),                  
                'total_items' => $exam->total(),                             
                'prev' => $exam->previousPageUrl(),               
                'next' => $exam->nextPageUrl()                       
            ];
        }

        if ($request->ajax()) {

            $start = $request->get('start');
            $limit = $request->get('limit');

            if(!empty($start)&& (!empty($limit)))
            {
            $exam = $exam->skip($start)->take($limit);
            }
            else
            {
                $exam = $exam->skip(1)->take(12);
            }


            return DataTables::of($exam)
                ->addColumn("action", function ($data) {
                    return '

                            <a data-id="'.$data->slug.'" class="btn btn-icons eye-button" onclick="UploadVideo(this)">
                                        <span class="adminside-icon">
                                            <img src="' . asset("assets/images/video-clip-32-regular.svg") . '" alt="View">
                                        </span>
                                        <span class="adminactive-icon">
                                            <img src="' . asset("assets/images/hover-video-clip-32-regular.svg") . '" alt="View Active" title="View">
                                        </span>
                             </a>
            
                            <a href="'.route("admin.full-mock-exam.index",["exam"=>$data->slug]).'" class="btn btn-icons eye-button">
                                        <span class="adminside-icon">
                                            <img src="' . asset("assets/images/icons/mdi_incognito.svg") . '" alt="View">
                                        </span>
                                        <span class="adminactive-icon">
                                            <img src="' . asset("assets/images/iconshover/view-yellow.svg") . '" alt="View Active" title="View">
                                        </span>
                             </a>
            
            
                            ';

                })->addColumn('date',function($data){
                    return $data->created_at->format('Y-m-d');
                })
              
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        $exam = Exam::orderBy('id', 'DESC');

        // Apply pagination if request parameters exist
        $exam = $exam->paginate($request->get('limit', 12)); 

         $url=$exam->nextPageUrl(); 

        return view("admin.exam.index",compact('url'));
    }




    public function create(Request $request){
        return view("admin.exam.create");
    }
    public function store(Request $request){
        $examdat=$request->validate([
            "title"=>"required",
            "time_of_exam"=>[
                'required',
                function ($attribute, $value, $fail) {
                    $validTimeFormat = '/^(0[0-9]|1[0-9]|2[0-3]) ?: ?[0-5][0-9]$/';

                    if (!preg_match($validTimeFormat, $value) || $value === '00:00' || $value === '00 : 00') {
                        $fail('The time of exam must not be 00:00.');
                    }
                },
            ],
        ]);
        $examdat['name']="full-mock-exam";
        $exam=Exam::store($examdat);        
        return redirect()->route('admin.exam.index')->with("success","Exam updated success");
    }
    public function show(Request $request,Exam $exam){
        self::reset();
        self::$model = Question::class;
        self::$routeName = "admin.question"; 
        self::$defaultActions=["delete"];

        if($request->ajax()){
            return $this->where('exam_id',$exam->id) 
                ->addAction(function($data)use($exam){
                    return '
                   

                       <a href="'.route("admin.full-mock-exam.edit",["exam"=>$exam->slug,"question"=>$data->slug]).'" class="btn btn-icons edit_btn">
    <span class="adminside-icon">
      <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
    </span>
    <span class="adminactive-icon">
        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active" title="Edit">
    </span>
</a>


                    ';
                })
                ->buildTable(['description']);
        } 
        return view("admin.exam.show",compact('exam'));
    }
    public function edit(Request $request,Exam $exam){
        return view("admin.exam.edit",compact('exam'));
    }
    public function examoptions(Request $request){
        return view("admin.exam.option");
    }

  
    public function examoptionssave(Request $request){
        $request->validate([
            'description'=>'',
            'title'=>'',
            'description1'=>'',
            'title1'=>'',
            
        ]);
        OptionHelper::setData("exam_simulator_title", $request->title);
        OptionHelper::setData("exam_simulator_description", $request->description);
        OptionHelper::setData("exam_simulator1_title", $request->title1);
        OptionHelper::setData("exam_simulator1_description", $request->description1);
        return redirect()->back()->with("success"," Content Updated Successfully");
    }


   




    public function update(Request $request,Exam $exam){
        $examdat=$request->validate([
            "title"=>"required",
            "time_of_exam"=>[
                'required',
                function ($attribute, $value, $fail) {
                    $validTimeFormat = '/^(0[0-9]|1[0-9]|2[0-3]) ?: ?[0-5][0-9]$/';

                    if (!preg_match($validTimeFormat, $value) || $value === '00:00' || $value === '00 : 00') {
                        $fail('The time of exam must not be 00:00.');
                    }
                },
            ],
        ]);
        $exam->update($examdat);        
        return redirect()->route('admin.exam.index')->with("success","Exam updated success");
    }

    public function destroy(Request $request,Exam $exam){ 
        $exam->delete();
        if($request->ajax()){
            return response()->json(["success"=>"Exam deleted success"]);
        }        
        return redirect()->route('admin.exam.index')->with("success","QuestionBankChapter deleted success");
    }

    
    public function get_expain_video(Request $request)
    {
        $slug = $request->exam_slug;
      
        $exam  = Exam::findSlug($slug);

        if(!empty($exam))
        {
            return response()->json(['data' => $exam]);
        }
        
        return response()->json([
            'message' => 'The Exam is Not Found.'
        ]);
    }

    public function explanation_video(Request $request)
    {
        $request->validate([

            "explanation_video"=>["required",'string'],
        ]);

        $exam = Exam::findSlug($request->exam_id);
        if($exam)
        {
            $exam->explanation_video = $request->explanation_video;
            $exam->save();
    
            return response()->json(['status' => 'success', 'message' => 'Explanation Video Added successfully!']);
        }
       
        return response()->json(['status' => 'success', 'message' => 'Something Error!']);
    }


}
