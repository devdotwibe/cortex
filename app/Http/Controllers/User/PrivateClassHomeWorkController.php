<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HomeWork;
use App\Models\HomeWorkAnswer;
use App\Models\HomeWorkBook;
use App\Models\HomeWorkQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateClassHomeWorkController extends Controller
{
    public function index(Request $request){
        $homeWorks=HomeWork::all();
        /**
         *  @var User
         */
        $user=Auth::user();
        return view('user.home-work.index',compact('homeWorks','user'));
    }
    public function show(Request $request,HomeWork $homeWork){
        /**
         *  @var User
         */
        $user=Auth::user();
        $booklets=HomeWorkBook::where('home_work_id',$homeWork->id)->get();
        return view('user.home-work.show',compact('homeWork','booklets','user'));
    }
    public function booklet(Request $request,HomeWork $homeWork,HomeWorkBook $homeWorkBook){ 
        /**
         *  @var User
         */
        $user=Auth::user();

        if($request->ajax()){      
            
            if(!empty($request->question)){
                $question=HomeWorkQuestion::findSlug($request->question);
                return HomeWorkAnswer::where('home_work_question_id',$question->id)->get(['slug','title']);
            }
            return HomeWorkQuestion::where('home_work_id',$homeWork->id)->where('home_work_book_id',$homeWorkBook->id)->paginate(1,['slug','title','description','duration']);
        } 
        $questioncount=HomeWorkQuestion::where('home_work_id',$homeWork->id)->where('home_work_book_id',$homeWorkBook->id)->count();
        return view('user.home-work.booklet',compact('homeWork','homeWorkBook','questioncount','user'));
    }

    public function bookletverify(Request $request,HomeWork $homeWork,HomeWorkBook $homeWorkBook){ 
        $request->validate([
            "question"=>'required'
        ]);
        /**
        * @var User
        */
       $user=Auth::user();   
        $question=HomeWorkQuestion::findSlug($request->question);
        $ans=HomeWorkAnswer::findSlug($request->answer);
        if(empty($ans)||$ans->home_work_id!=$homeWorkBook->id||$ans->home_work_question_id!=$question->id||!$ans->iscorrect){
            return response()->json(["iscorrect"=>false]);
        }else{
            return response()->json(["iscorrect"=>true]);
        }
    }
}
