<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRetryReview extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'title',
        'name',  
        'user_id',
        'exam_id', 
        'progress',
        'timetaken',
        'flags',
        'times',
        'passed',
        'questions',
        'time_of_exam',
        'category_id', 
        'sub_category_id', 
        'sub_category_set',
        'user_exam_review_id', 
    ];


    public function categoryMark($id){ 
        return ExamRetryAnswer::where('exam_retry_review_id',$this->id)->where('exam_id',$this->exam_id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
    }
    public function categoryCount($id){ 
        return ExamRetryQuestion::where('exam_retry_review_id',$this->id)->where('exam_id',$this->exam_id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'))->count();
    }
    public function avgTime($id=null){ 
        $qst=ExamRetryQuestion::where('exam_retry_review_id',$this->id)->where('exam_id',$this->exam_id);
        if(!empty($id)){
            $qst->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'));
        }
        return round($qst->whereNotNull('time_taken')->where('time_taken','>',0)->average('time_taken'),2);
    }
}
