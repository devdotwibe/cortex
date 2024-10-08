<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exam extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'title',
        'name',
        'description', 
        'price',  
        'discount',
        'duration',
        'time_of_exam',
        'overview',
        'requirements',
        'fees', 
        'slug'
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function subtitle($id,$defaultTitle){
        return optional($this->categoryTitle()->where("category_id",$id)->first())->title??$defaultTitle;
    }
    public function examIcon($id,$defaultIcon){
        $icon=optional($this->categoryTitle()->where("category_id",$id)->first())->icon;
        if(!empty($icon)){
            return url("d0/$icon");
        }else{
            return $defaultIcon;
        } 
    }
    public function categoryTitle(){
        return $this->hasMany(ExamCategoryTitle::class);
    }
    public function categoryMark($id){ 
        return UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
    }
    public function categoryCount($id=null){ 
        if(empty($id)){
            return Question::where('exam_id',$this->id)->count();
        }else{
            return Question::where("category_id",$id)->where('exam_id',$this->id)->count();
        }
    }
    public function getExamMark($user,$id=null){ 
        if(empty($id)){
            return UserReviewAnswer::where('user_id',$user)->whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->whereIn('question_id',Question::where('exam_id',$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();;
        }else{
            return UserReviewAnswer::where('user_id',$user)->whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->whereIn('question_id',Question::where('exam_id',$this->id)->where("category_id",$id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();;
        } 
    }

    public function getExamAvg($id=null){ 
        if(empty($id)){
            $anscnt=UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->whereIn('question_id',Question::where('exam_id',$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
            $exmcnt=UserExamReview::whereIn('id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->count();
        }else{
            $anscnt=UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->whereIn('question_id',Question::where('exam_id',$this->id)->where("category_id",$id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
            $exmcnt=UserExamReview::whereIn('id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->count();
        }
        if($anscnt>0&&$exmcnt>0){
            return round($anscnt/$exmcnt,2);
        }else{
            return 0;
        }
    }
    public function avgMark($id=null){ 
        if(empty($id)){
            $anscnt=UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->whereIn('question_id',Question::where('exam_id',$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
            $exmcnt=UserExamReview::whereIn('id',UserExamReview::where('exam_id',$this->id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->count();
            $qstcnt=Question::where('exam_id',$this->id)->count();
            return round($anscnt/$exmcnt,2)."/$qstcnt ";
        }else{
            $anscnt=UserReviewAnswer::whereIn('user_exam_review_id',UserExamReview::where('exam_id',$this->id)->where("category_id",$id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->whereIn('question_id',Question::where('exam_id',$this->id)->where("category_id",$id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
            $exmcnt=UserExamReview::whereIn('id',UserExamReview::where('exam_id',$this->id)->where("category_id",$id)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('exam_id',$this->id)->where("category_id",$id)->count();
            $qstcnt=Question::where('exam_id',$this->id)->where("category_id",$id)->count();
            return round($anscnt/$exmcnt,2)."/$qstcnt ";
        }
    }
}
