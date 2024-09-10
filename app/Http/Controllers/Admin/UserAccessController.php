<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassDetail;
use App\Models\HomeWork;
use App\Models\LessonMaterial;
use App\Models\LessonRecording;
use App\Models\TermAccess;
use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class UserAccessController extends Controller
{
    use ResourceController;
    public function index(Request $request,$type,$term){
        switch ($type) {
            case 'class-detail':
                $term=ClassDetail::findSlug($term);
                if(empty($term)){
                    return abort(404);
                }
                break;            
            case 'lesson-material':
                $term=LessonMaterial::findSlug($term);
                if(empty($term)){
                    return abort(404);
                }
                break;
            case 'home-work':
                $term=HomeWork::findSlug($term);
                if(empty($term)){
                    return abort(404);
                }
                break;
            case 'lesson-record':
                $term=LessonRecording::findSlug($term);
                if(empty($term)){
                    return abort(404);
                }
                break;
            
            default:
                return abort(404); 
        }
        if($request->ajax()){
            self::$model = User::class;
            self::$defaultActions=[''];
            return $this->addAction(function($data)use($type,$term){
                $termaccess=TermAccess::where('type',$type)->where('term_id',$term->id)->where('user_id',$data->id)->count();
                return '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" onchange="changeactivestatus('."'".route('admin.user-access.update',['type'=>$type,'term'=>$term->slug,'user'=>$data->slug])."'".')" role="switch" id="term-toggle-'.$data->id.'"  '.($termaccess>0?"checked":"").'/>
                </div>'; 
            })->buildTable();
        }
    }
    public function update(Request $request,$type,$term,User $user){

        switch ($type) {
            case 'class-detail':
                $term=ClassDetail::findSlug($term);
                if(empty($term)){
                    return abort(404);
                }
                break;            
            case 'lesson-material':
                $term=LessonMaterial::findSlug($term);
                if(empty($term)){
                    return abort(404);
                }
                break;
            case 'home-work':
                $term=HomeWork::findSlug($term);
                if(empty($term)){
                    return abort(404);
                }
                break;
            case 'lesson-record':
                $term=LessonRecording::findSlug($term);
                if(empty($term)){
                    return abort(404);
                }
                break;
            
            default:
                return abort(404); 
        }
        if($request->ajax()){
            if(TermAccess::where('type',$type)->where('term_id',$term->id)->where('user_id',$user->id)->count()>0){
                TermAccess::where('type',$type)->where('term_id',$term->id)->where('user_id',$user->id)->delete();
            }else{
                TermAccess::store(['type'=>$type,'term_id'=>$term->id,'user_id'=>$user->id]);
            }
        }

        return response()->json([
            'success'=>"User Access updated"
        ]);
    }
    public function user_update(Request $request,User $user){
        $term=trim($request->term);
        if(!empty($term)){
            $classIds=[];
            foreach (ClassDetail::where('term_name','like',"%".$term."%")->get() as $term) {
                if(TermAccess::where('type',"class-detail")->where('term_id',$term->id)->where('user_id',$user->id)->count()==0){
                    TermAccess::store(['type'=>"class-detail",'term_id'=>$term->id,'user_id'=>$user->id]);
                }
                $classIds[]=$term->id;
            }
            TermAccess::where('type','class-detail')->whereNotIn('term_id',$classIds)->where('user_id',$user->id)->delete();


            $lessonIds=[];
            foreach (LessonMaterial::where('term_name','like',"%".$term."%")->get() as $term) {
                if(TermAccess::where('type',"lesson-material")->where('term_id',$term->id)->where('user_id',$user->id)->count()==0){
                    TermAccess::store(['type'=>"lesson-material",'term_id'=>$term->id,'user_id'=>$user->id]);
                }
                $lessonIds[]=$term->id;
            }
            TermAccess::where('type','lesson-material')->whereNotIn('term_id',$lessonIds)->where('user_id',$user->id)->delete();


            $homeIds=[];
            foreach (HomeWork::where('term_name','like',"%".$term."%")->get() as $term) {
                if(TermAccess::where('type',"home-work")->where('term_id',$term->id)->where('user_id',$user->id)->count()==0){
                    TermAccess::store(['type'=>"home-work",'term_id'=>$term->id,'user_id'=>$user->id]);
                }
                $homeIds[]=$term->id;
            }
            TermAccess::where('type','home-work')->whereNotIn('term_id',$homeIds)->where('user_id',$user->id)->delete();


            $recordIds=[];
            foreach (LessonRecording::where('term_name','like',"%".$term."%")->get() as $term) {
                if(TermAccess::where('type',"lesson-record")->where('term_id',$term->id)->where('user_id',$user->id)->count()==0){
                    TermAccess::store(['type'=>"lesson-record",'term_id'=>$term->id,'user_id'=>$user->id]);
                }
                $recordIds[]=$term->id;
            }
            TermAccess::where('type','lesson-record')->whereNotIn('term_id',$recordIds)->where('user_id',$user->id)->delete();
        }else{
            echo "**";
        }
        // return redirect()->back()->with('success',"User Access updated");
    }

}
