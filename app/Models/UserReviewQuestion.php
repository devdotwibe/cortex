<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserReviewQuestion extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'user_exam_review_id',
        'review_type',
        'note', 
        'explanation', 
        'currect_answer', 
        'user_answer', 
        'duration',
        'takenduration',
        'slug',
        'exam_id',
        'question_id',
        'user_id',
        'time_taken',
        'title_text',
        'sub_question',
        'order_no',
    ];
    protected $hidden = ['user_id','exam_id','question_id','user_exam_review_id'];

    protected $appends=[
        'total_user_taken_time', 
    ]; 
    public function getTotalUserTakenTimeAttribute(){
        return round(UserReviewQuestion::whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->exam_id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->exam_id)->where('question_id',$this->question_id)->whereNotNull('time_taken')->where('time_taken','>',0)->average('time_taken'),2);
    }
    public function answers(){
        return $this->hasMany(UserReviewAnswer::class);
    }
}
