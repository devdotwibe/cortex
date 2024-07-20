<?php

namespace App\Models;

use App\Models\Scopes\VisibleStatus;
use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

#[ScopedBy([VisibleStatus::class])]
class Category extends Model
{
    use HasFactory,ResourceModel;

    protected $fillable = [
        'slug',
        'name',
        'visible_status',
        'time_of_exam'
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class,'category_id','id');
    }

    public function getExamAvg($exam){ 
        $anscnt=UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
        $exmcnt=UserExamReview::whereIn('id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->count();
        if($anscnt>0&&$exmcnt>0){
            return round($anscnt/$exmcnt,2);
        }else{
            return 0;
        }
    }
    public function getExamAvgPercentage($exam){
        $avg=$this->getExamAvg($exam);
        $total=$this->getQuestionCount($exam);
        if($avg>0&&$total>0){
            return round($avg*100/$total,2);
        }else{
            return 0;
        }
    }
    public function getExamAvgTime($exam){
        return round(UserReviewQuestion::whereIn('user_exam_review_id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->whereNotNull('time_taken')->where('time_taken','>',0)->average('time_taken'),2);
    }
    public function getQuestionCount($exam){
        return Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->count();
    }
    public function getExamQuestionTime($exam){
        $cnt=$this->getQuestionCount($exam);
        if($exam=="topic-test"){
            if(!empty($this->time_of_exam)&&$cnt>0){
                $time=explode(':',$this->time_of_exam); 
                return round(((trim($time[0])*(count($time)*60))+(trim($time[1]??0)*60))/$cnt,2);
            }
        }
        if($exam=="question-bank"){
            $time=Setname::whereIn('id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('sub_category_set'))->whereNotNull('time_of_exam')->sum(DB::raw("(CAST(SUBSTRING_INDEX(time_of_exam, ':', 1) AS UNSIGNED) * 3600) + (CAST(SUBSTRING_INDEX(time_of_exam, ':', -1) AS UNSIGNED) * 60)"));
            if($cnt>0){
                return round($time/$cnt,2);
            }
        }
        return 0;
    }
    public function getExamMark($exam,$user){ 
         
        return UserReviewAnswer::where('user_id',$user)->whereIn('user_exam_review_id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();;
    }
    public function getExamTime($exam,$user){ 
        return round(UserReviewQuestion::where('user_id',$user)->whereIn('user_exam_review_id',UserExamReview::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->whereIn('exam_id',Exam::where('name',$exam)->select('id'))->whereIn('question_id',Question::whereIn('exam_id',Exam::where('name',$exam)->select('id'))->where("category_id",$this->id)->select('id'))->whereNotNull('time_taken')->where('time_taken','>',0)->average('time_taken'),2);
    }
    public function getExamMarkPercentage($exam,$user){
        $avg=$this->getExamMark($exam,$user);
        $total=$this->getQuestionCount($exam);
        if($avg>0&&$total>0){
            return round($avg*100/$total,2);
        }else{
            return 0;
        }
    }
}
