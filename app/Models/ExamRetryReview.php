<?php

namespace App\Models;

use App\Trait\ResourceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        //        return ExamRetryAnswer::where('exam_retry_review_id',$this->id)->where('exam_id',$this->exam_id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'))->where('iscorrect',true)->where('user_answer',true)->count();
        $questions = ExamRetryQuestion::where("category_id",$id)
                                        ->where('exam_id',$this->exam_id)
                                        ->select('id');
        return ExamRetryAnswer::where('exam_retry_review_id',$this->id)
                            ->where('exam_id',$this->exam_id)
                            ->whereIn('exam_retry_question_id',$questions)
                            ->where('iscorrect',true)
                            ->where('user_answer',true)
                            ->count();
    }
    public function categoryCount($id){ 
        //        return ExamRetryQuestion::where('exam_retry_review_id',$this->id)->where('exam_id',$this->exam_id)->whereIn('question_id',Question::where("category_id",$id)->where('exam_id',$this->exam_id)->select('id'))->count();
        return ExamRetryQuestion::where('exam_retry_review_id',$this->id)
                                ->where('exam_id',$this->exam_id)
                                ->where("category_id",$id)
                                ->count();
    }
    public function avgTime($id=null){ 
        $qst=ExamRetryQuestion::where('exam_retry_review_id',$this->id)
                                ->where('exam_id',$this->exam_id);
        if(!empty($id)){
            $qst->whereIn('question_id',
                        Question::where("category_id",$id)
                                        ->where('exam_id',$this->exam_id)
                                        ->select('id'));
        }
        return round($qst->whereNotNull('time_taken')
                                ->where('time_taken','>',0)
                                ->average('time_taken'),2);
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
                $anscnt = ExamRetryAnswer::where('exam_retry_review_id', '=', $userExamReviewId)
                                            ->where('exam_id', $this->exam_id)
                                            // ->whereIn('exam_retry_review_id', 
                                            //                 ExamRetryReview::where('name', 'full-mock-exam')
                                            //                                         ->where('id', '<=', $userExamReviewId)
                                            //                                         ->groupBy('user_id')
                                            //                                         ->select(DB::raw('MAX(id)')))
                                            ->where('iscorrect', true)
                                            ->where('user_answer', true)
                                            ->count();
                $exmcnt = ExamRetryReview::where('id', '<=', $userExamReviewId)
                                            ->where('exam_id', $this->exam_id)
                                            // ->whereIn('id', 
                                            //                     ExamRetryReview::where('name', 'full-mock-exam')
                                            //                     ->where('id', '<=', $userExamReviewId)
                                            //                     ->groupBy('user_id')
                                            //                     ->select(DB::raw('MAX(id)')))
                                            ->count();
                break;
            case 'topic-test':
                $anscnt = ExamRetryAnswer::where('exam_retry_review_id', '=', $userExamReviewId)
                                            ->where('exam_id', $this->exam_id)
                                            // ->whereIn('exam_retry_review_id', ExamRetryReview::where('name', 'topic-test')
                                            //                                                     ->where('category_id', $categoryId)
                                            //                                                     ->where('id', '=', $userExamReviewId)
                                            //                                                     ->groupBy('user_id')
                                            //                                                     ->select(DB::raw('MAX(id)')))
                                            ->where('iscorrect', true)
                                            ->where('user_answer', true)
                                            ->count();
                $exmcnt = ExamRetryReview::where('id', '<=', $userExamReviewId)->where('exam_id', $this->exam_id)->where('category_id', $categoryId)->whereIn('id', ExamRetryReview::where('name', 'topic-test')->where('category_id', $categoryId)->where('id', '<=', $userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->count();
                break; 
            // case 'learn':
            //     $anscnt = ExamRetryAnswer::where('exam_retry_review_id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->whereIn('exam_retry_review_id',ExamRetryReview::where('name','learn')->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
            //     $exmcnt = ExamRetryReview::where('id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->whereIn('id',ExamRetryReview::where('name','learn')->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->count();
            //     break; 
            // case 'question-bank':
            //     $anscnt = ExamRetryAnswer::where('exam_retry_review_id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->whereIn('exam_retry_review_id',ExamRetryReview::where('name','question-bank')->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('sub_category_set',$subCategorySet)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->where('iscorrect',true)->where('user_answer',true)->count();
            //     $exmcnt = ExamRetryReview::where('id','<=',$userExamReviewId)->where('exam_id',$this->exam_id)->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('sub_category_set',$subCategorySet)->whereIn('id',ExamRetryReview::where('name','question-bank')->where('category_id',$categoryId)->where('sub_category_id',$subCategoryId)->where('sub_category_set',$subCategorySet)->where('id','<=',$userExamReviewId)->groupBy('user_id')->select(DB::raw('MAX(id)')))->count();
            //     break; 
            default:
                # code...
                break;
        } 
        $qstcnt=ExamRetryQuestion::where('exam_retry_review_id',$userExamReviewId)->where('exam_id',$this->exam_id)->count();
        return ($exmcnt>0?round($anscnt/$exmcnt,2):0)."/$qstcnt ";
    }
}
