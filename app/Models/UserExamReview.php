<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserExamReview extends Model
{
    use HasFactory,ResourceModel;
    protected $fillable = [
        'ticket',
        'slug',
        'title',
        'name', 
        'progress', 
        'user_id',
        'exam_id', 
        'category_id', 
        'sub_category_id', 
        'sub_category_set',
        'timed',
        'timetaken',
        'flags',
        'times',
        'passed',
        'time_of_exam'
    ];
    public function categoryMark($id){ 
        //        return UserReviewAnswer::where('user_exam_review_id',$this->id)->where('exam_id',$this->exam_id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
        $questions = UserExamQuestion::where("category_id",$id)
                            ->where('exam_id',$this->exam_id)
                            ->select('id');
        return UserReviewAnswer::where('user_exam_review_id',$this->id)
                                ->where('exam_id',$this->exam_id)
                                ->whereIn('question_id',$questions)
                                ->where('iscorrect',true)
                                ->where('user_answer',true)
                                ->count();
    }
    public function categoryCount($id){ 
        //return UserReviewQuestion::where('user_exam_review_id',$this->id)->where('exam_id',$this->exam_id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'))->count();
        $questions = Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id');
        return UserReviewQuestion::where('user_exam_review_id',$this->id)
                                    ->where('exam_id',$this->exam_id)
                                    ->whereIn('question_id',$questions)
                                    ->count();
    }
    public function avgTime($id=null){ 
        $qst=UserReviewQuestion::where('user_exam_review_id',$this->id)->where('exam_id',$this->exam_id);
        if(!empty($id)){
            $qst->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'));
        }
        return round($qst->whereNotNull('time_taken')->where('time_taken','>',0)->average('time_taken'),2);
    }
    public function avgMark(){ 
        $userExamReviewId=$this->id;
        $categoryId=$this->category_id;
        $subCategoryId=$this->sub_category_id;
        $subCategorySet=$this->sub_category_set;
        $anscnt=0;
        $exmcnt=0; 
        switch ($this->name) {
            case 'full-mock-exam':
                $anscnt = UserReviewAnswer::where('user_exam_review_id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->whereIn('user_exam_review_id',UserExamReview::where('name','full-mock-exam')->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
                $exmcnt = UserExamReview::where('id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->whereIn('id',UserExamReview::where('name','full-mock-exam')->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->count();
                break; 
            case 'topic-test':
                $anscnt = UserReviewAnswer::where('user_exam_review_id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->whereIn('user_exam_review_id',UserExamReview::where('name','topic-test')->where('category_id',$categoryId)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
                $exmcnt = UserExamReview::where('id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->where('category_id',$categoryId)->whereIn('id',UserExamReview::where('name','topic-test')->where('category_id',$categoryId)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->count();
                break; 
            case 'learn':
                $anscnt = UserReviewAnswer::where('user_exam_review_id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->whereIn('user_exam_review_id',UserExamReview::where('name','learn')->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
                $exmcnt = UserExamReview::where('id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->whereIn('id',UserExamReview::where('name','learn')->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->count();
                break; 
            case 'question-bank':
                $anscnt = UserReviewAnswer::where('user_exam_review_id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->whereIn('user_exam_review_id',UserExamReview::where('name','question-bank')->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('sub_category_set',$subCategorySet)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
                $exmcnt = UserExamReview::where('id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('sub_category_set',$subCategorySet)->whereIn('id',UserExamReview::where('name','question-bank')->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('sub_category_set',$subCategorySet)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->count();
                break; 
            default:
                # code...
                break;
        } 
        $qstcnt=UserReviewQuestion::where('user_exam_review_id',$userExamReviewId)->where('exam_id',$this->exam_id)->count();
        return ($exmcnt>0?round($anscnt/$exmcnt,2):0)."/$qstcnt ";
    }
    public function getData($name,$defaultValue=null){
        $data=PreviewResult::where('user_exam_review_id',$this->id)->where("name",$name)->first();
        if(empty($data)){
            return $defaultValue;
        }
        switch ($data->vtype) {
            case 'string':
                return strval($data->content); 
            case 'int':
                return intval($data->content); 
            case 'float':
                return floatval($data->content); 
            case 'array':
                if(is_string($data->content??'')){
                    return json_decode($data->content??"[]",true);
                }else{
                    return json_decode(json_encode($data->content),true);
                }
                 
            default:
                return $data->content;
        }
    }
}
