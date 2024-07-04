<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserReviewAnswer extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'description',
        'user_exam_review_id',  
        'user_review_question_id', 
        'iscorrect', 
        'user_answer',
        'slug',
        'exam_id',
        'question_id',
        'answer_id',
        'user_id'
    ];
    protected $hidden = ['user_id', 'id','exam_id','question_id','answer_id','user_exam_review_id','user_review_question_id'];

    protected $appends=[
        'total_user_answered'
    ];
    public function getTotalUserAnsweredAttribute()
    { 
        $ansthis=UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->exam_id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->exam_id)->where('question_id',$this->question_id)->where('answer_id',$this->answer_id)->where('user_answer',true)->count();
        $ansthisall=UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->exam_id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->exam_id)->where('question_id',$this->question_id)->where('user_answer',true)->count();
        return ($ansthis*100)/ $ansthisall;
    }
}
