<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index(Request $request){
        /**
         *  @var User
         */
        $user=Auth::user(); 
        $category = Category::all();  
        $mockExams = Exam::where('name', "full-mock-exam")->whereHas('questions')->get();

        if($request->ajax()){

            $type = $request->type;
            if($request->type =='mock-exam-result' || empty($request->type))
            {
                $page=$request->page??1;
                $data = Exam::where('name',"full-mock-exam")->whereHas('questions')->get()->skip($page-1)->take(1)->first();
                $categorydata=[];
                foreach ($category as $cat) {
                    $categorydata[]=[
                        'title'=>ucfirst($cat->name),
                        'max'=> $data->categoryCount($cat->id),
                        'avg'=>$data->getExamAvg($cat->id),
                        'mark'=>$data->getExamMark($user->id,$cat->id),
                    ];
                }
                $next = null;
                $prev = null;
                if(Exam::where('name',"full-mock-exam")->count()>$page){
                    $next=route('analytics.index',["page"=> $page+1]);
                }
                if($page>1){
                    $prev=route('analytics.index',["page"=> $page-1]);
                }

                return [
                    'data'=>[
                        'title'=>ucfirst($data->title),
                        'max'=> $data->categoryCount(),
                        'avg'=>$data->getExamAvg(),
                        'mark'=>$data->getExamMark($user->id),
                        'category'=>$categorydata
                    ],
                    "next"=>$next,
                    "prev"=>$prev,
                    'type'=>$type
                ];

            }
            else
            {
            
                $category = Category::whereHas('question')->get();

                $categorydata=[];
                // foreach ($category as $cat) {
                //     $categorydata[]=[
                //         'title'=>ucfirst($cat->name),
                //         'max'=> $data->categoryCount($cat->id),
                //         'avg'=>$data->getExamAvg($cat->id),
                //         'mark'=>$data->getExamMark($user->id,$cat->id),
                //     ];
                // }
                return [
                    'data'=>[
                        'category'=>$category, 
                        'max'=> '',
                        'avg'=>'',
                        'mark'=>'', 
                    ],
                    'type'=>$type
                ];
            }

           
        }
        return view('user.analytics.index',compact('category','mockExams'));   
    }
}
