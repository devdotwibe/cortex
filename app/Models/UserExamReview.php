<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamReview extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'slug',
        'title',
        'name', 
        'progress', 
        'user_id',
        'exam_id', 
        'category_id', 
        'sub_category_id', 
        'sub_category_set',
    ];
    public function categoryMark($id){ 
        return UserReviewAnswer::where('user_exam_review_id',$this->id)->where('exam_id',$this->exam_id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
    }
    public function categoryCount($id){ 
        return UserReviewQuestion::where('user_exam_review_id',$this->id)->where('exam_id',$this->exam_id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'))->count();
    }
    public function avgTime($id=null){ 
        $qst=UserReviewQuestion::where('exam_id',$this->exam_id);
        if(!empty($id)){
            $qst->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'));
        }
        return round($qst->whereNotNull('time_taken')->where('time_taken','>=',0)->average('time_taken'),2);
    }
}
