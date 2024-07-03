<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function categoryTitle(){
        return $this->hasMany(ExamCategoryTitle::class);
    }
    public function categoryMark($id){ 
        return UserReviewAnswer::where('exam_id',$this->id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
    }
    public function categoryCount($id){ 
        return Question::where("category_id",$id)->where('exam_id',$this->id)->count();
    }
    public function avgMark(){ 
        $anscnt=UserReviewAnswer::where('exam_id',$this->id)->whereIn('question_id',Question::where('exam_id',$this->id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
        $exmcnt=UserExamReview::where('exam_id',$this->id)->count();
        $qstcnt=Question::where('exam_id',$this->id)->count();
        return round($anscnt/$exmcnt,2)."/$qstcnt ";
    }
}
