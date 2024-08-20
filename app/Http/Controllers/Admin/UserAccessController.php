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
    
}
