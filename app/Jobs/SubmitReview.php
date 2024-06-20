<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserExamReview;
use App\Models\UserReviewAnswer;
use App\Models\UserReviewQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SubmitReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** 
     *
     * @var UserExamReview
     */
    protected $review;
    /**
     * Create a new job instance.
     */
    public function __construct($review)
    {
        $this->review=$review;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        switch ($this->review->name) {
            case 'learn':
                $this->learnHandle();
                break;
            
            default:
                # code...
                break;
        }
    }
    private function getVimeoId($vimeoid){
        $pattern = "/vimeo\.com\/(?:video\/|)(\d+)/i";
        if(preg_match($pattern, $vimeoid,$match)){
            return $match[1];
        }
        return $vimeoid;
    }
    private function learnHandle(){
        $user=User::find($this->review->user_id);
        $exam=Exam::find($this->review->exam_id);
        $category=Category::find($this->review->category_id);
        $exam=Exam::find($this->review->exam_id);
        $subCategory=SubCategory::find($this->review->sub_category_id);
        foreach (Learn::where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->get() as $k=> $learn) {
            $note='';
            $currect_answer="";
            $user_answer="";
            switch ($learn->learn_type) {
                case 'video': 
                    $vimeoid = $learn->video_url??""; 
                    if(str_contains($vimeoid,"vimeo.com")){
                        $vimeoid =$this->getVimeoId($vimeoid);
                    }
                    $lesseonId=Str::random(10);
                    $note='<iframe src="https://player.vimeo.com/video/'.$vimeoid.'?h='.$lesseonId.'" width="100%" height="500" frameborder="0" title="'.$learn->title.'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                    $currect_answer="Y";
                    $user_answer=$user->progress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-answer-of-".$learn->slug,"N");
                    break;
                case 'notes': 
                    $note=$learn->note;
                    $currect_answer="Y";
                    $user_answer=$user->progress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-answer-of-".$learn->slug,"N");
                    break;
                case 'short_notes': 
                    $note=$learn->short_question;
                    $currect_answer=$learn->short_answer;
                    $user_answer=$user->progress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-answer-of-".$learn->slug,"");
                    break;
                case 'mcq': 
                    $note=$learn->short_question; 
                    $user_answer=$user->progress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-answer-of-".$learn->slug,"");
                    break;
                default:
                    break;
            }
            $question=UserReviewQuestion::store([
                'title'=>$learn->title, 
                'user_exam_review_id'=>$this->review->id,
                'review_type'=>$learn->learn_type,
                'note'=>$note, 
                'explanation'=>$learn->explanation, 
                'currect_answer'=>$currect_answer, 
                'user_answer'=>$user_answer,  
            ]);
            if($learn->learn_type=='mcq'){
                foreach($learn->learnanswers as $ans){
                    UserReviewAnswer::store([
                        'user_exam_review_id'=>$this->review->id,
                        'user_review_question_id'=>$question->id,
                        'title'=>$ans->title,
                        'iscorrect'=>$ans->iscorrect,
                        'user_answer'=>$ans->slug==$user_answer?true:false,
                    ]);
                }
            }
            $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-answer-of-".$learn->slug,null);
        }
        $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-complete-review",null);
        $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-progress-ids",null);
        $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-progress-url",null);
    }
}
