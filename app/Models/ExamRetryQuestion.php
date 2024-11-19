<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExamRetryQuestion extends Model
{
    
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title', 
        'user_exam_review_id',
        'exam_retry_review_id',
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
        'category_id',
        'sub_category_id',
        'sub_category_set'
    ];
    protected $appends=[
        'total_user_taken_time', 
    ]; 
    public function getTotalUserTakenTimeAttribute(){
        return round(ExamRetryQuestion::whereIn('exam_retry_review_id',ExamRetryReview::where('exam_id',$this->exam_id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->exam_id)->where('question_id',$this->question_id)->whereNotNull('time_taken')->where('time_taken','>',0)->average('time_taken'),2);
    }
    public function answers(){
        return $this->hasMany(ExamRetryAnswer::class);
    }
}
