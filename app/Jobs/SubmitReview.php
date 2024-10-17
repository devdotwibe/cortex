<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Exam;
use App\Models\Learn;
use App\Models\Question;
use App\Models\Setname;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserExam;
use App\Models\UserExamQuestion;
use App\Models\UserExamReview;
use App\Models\UserReviewAnswer;
use App\Models\UserReviewQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
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
     * 
     * @var UserExam|null
     */
    protected $userexam;

    /**
     * Summary of __construct
     * @param UserExamReview $review
     */
    public function __construct($review,$userexam=null)
    {
  
        $this->review=$review;
        $this->userexam=$userexam;

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
            case 'question-bank':
                $this->questionSetHandle();
                break;        
            case 'topic-test':
                $this->topicTestHandle();
                break;
            case 'full-mock-exam':
                $this->fullMockExamHandle();
                break;
            default: 
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
                    $note='<iframe src="https://player.vimeo.com/video/'.$vimeoid.'?byline=0&keyboard=0&dnt=1&app_id='.$lesseonId.'" width="100%" height="500" frameborder="0"  allow="autoplay; fullscreen; picture-in-picture; clipboard-write" title="'.$learn->title.'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
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
                    $note=$learn->mcq_question; 
                    $user_answer=$user->progress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-answer-of-".$learn->slug,"");
                    break;
                default:
                    break;
            }
            $revquestion=UserReviewQuestion::store([
                'title'=>$learn->title, 
                'user_exam_review_id'=>$this->review->id,
                'review_type'=>$learn->learn_type,
                'note'=>$note, 
                'explanation'=>$learn->explanation, 
                'currect_answer'=>$currect_answer, 
                'user_answer'=>$user_answer, 
                'exam_id'=> $this->review->exam_id,
                'question_id'=> $learn->id,
                'user_id'=>$this->review->user_id,
            ]);
            if($learn->learn_type=='mcq'){
                foreach($learn->learnanswers as $ans){
                    UserReviewAnswer::store([
                        'user_exam_review_id'=>$this->review->id,
                        'user_review_question_id'=>$revquestion->id,
                        'title'=>$ans->title,
                        'iscorrect'=>$ans->iscorrect,
                        'user_answer'=>(($ans->slug==$user_answer)?true:false),
                        'exam_id'=> $this->review->exam_id,
                        'question_id'=> $learn->id,
                        'answer_id'=> $ans->id,
                        'user_id'=>$this->review->user_id,
                    ]);
                }
            }
            $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-answer-of-".$learn->slug,null);
        }
        $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-complete-review",null);
        $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-progress-ids",null);
        $user->setProgress("exam-".$exam->id."-module-".$category->id."-lesson-".$subCategory->id."-progress-url",null);
    }
    private function questionSetHandle(){
   
        $user=User::find($this->review->user_id);
        $exam=Exam::find($this->review->exam_id);
        $category=Category::find($this->review->category_id); 
        $subCategory=SubCategory::find($this->review->sub_category_id);
        $setname=Setname::find($this->review->sub_category_set);
        $takentime=json_decode($user->progress("exam-review-".$this->review->id."-times",'[]'),true); 
        $takentimereview=[];
        foreach (Question::where('exam_id',$exam->id)->where('category_id',$category->id)->where('sub_category_id',$subCategory->id)->where('sub_category_set',$setname->id)->get() as $k=> $question) {
              
            $user_answer=$user->progress("exam-".$exam->id."-topic-".$category->id."-lesson-".$subCategory->id."-set-".$setname->id."-answer-of-".$question->slug,"");

            $revquestion=UserReviewQuestion::store([
                'title'=>$question->title, 
                'user_exam_review_id'=>$this->review->id,
                'review_type'=>'mcq',
                'note'=>$question->description, 
                'explanation'=>$question->explanation, 
                'currect_answer'=>'', 
                'user_answer'=>$user_answer,  
                'exam_id'=> $this->review->exam_id,
                'question_id'=> $question->id,
                'title_text'=> $question->title_text,
                'sub_question'=> $question->sub_question,
                'user_id'=>$this->review->user_id,
                'time_taken'=>$takentime[$question->slug]??0
            ]);
            
            $takentimereview[$revquestion->slug]=$takentime[$question->slug]??0;
            
            foreach($question->answers as $ans){
                UserReviewAnswer::store([
                    'user_exam_review_id'=>$this->review->id,
                    'user_review_question_id'=>$revquestion->id,
                    'title'=>$ans->title,
                    'iscorrect'=>$ans->iscorrect,
                    'user_answer'=>(($ans->slug==$user_answer)?true:false),
                    'exam_id'=> $this->review->exam_id,
                    'question_id'=> $question->id,
                    'answer_id'=> $ans->id,
                    'user_id'=>$this->review->user_id,
                ]); 
            } 
            $user->setProgress("exam-".$exam->id."-topic-".$category->id."-lesson-".$subCategory->id."-set-".$setname->id."-answer-of-".$question->slug,null);
        }
        $user->setProgress("exam-reviewed-".$this->review->id."-times",json_encode($takentimereview));
        
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-lesson-".$subCategory->id."-set-".$setname->id."-complete-review",null);
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-lesson-".$subCategory->id."-set-".$setname->id."-progress-ids",null);
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-lesson-".$subCategory->id."-set-".$setname->id."-progress-url",null);
        
    }

    private function topicTestHandle(){

        $user=User::find($this->review->user_id);
        $exam=Exam::find($this->review->exam_id);
        $category=Category::find($this->review->category_id);  
        $takentime=json_decode($user->progress("exam-review-".$this->review->id."-times",'[]'),true);
        $takentimereview=[];
        foreach (UserExamQuestion::where('user_exam_id',$this->userexam->id)->get() as $k=> $question) {
              
            $user_answer=$user->progress("exam-".$exam->id."-topic-".$category->id."-answer-of-".$question->slug,"");

            $revquestion=UserReviewQuestion::store([
                'title'=>$question->title, 
                'user_exam_review_id'=>$this->review->id,
                'review_type'=>'mcq',
                'note'=>$question->description, 
                'explanation'=>$question->explanation, 
                'currect_answer'=>'', 
                'user_answer'=>$user_answer,  
                'exam_id'=> $this->review->exam_id,
                'question_id'=> $question->question_id,
                'title_text'=> $question->title_text,
                'sub_question'=> $question->sub_question,
                'user_id'=>$this->review->user_id,
                'time_taken'=>$takentime[$question->slug]??0
            ]);
            
            $takentimereview[$revquestion->slug]=$takentime[$question->slug]??0;
            
            foreach($question->answers as $ans){
                UserReviewAnswer::store([
                    'user_exam_review_id'=>$this->review->id,
                    'user_review_question_id'=>$revquestion->id,
                    'title'=>$ans->title,
                    'iscorrect'=>$ans->iscorrect,
                    'user_answer'=>(($ans->slug==$user_answer)?true:false),
                    'exam_id'=> $this->review->exam_id,
                    'question_id'=> $question->question_id,
                    'answer_id'=> $ans->answer_id,
                    'user_id'=>$this->review->user_id,
                ]); 
            } 
            $user->setProgress("exam-".$exam->id."-topic-".$category->id."-answer-of-".$question->slug,null);
        }
        $user->setProgress("exam-reviewed-".$this->review->id."-times",json_encode($takentimereview));

        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-complete-review",null);
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-progress-ids",null);
        $user->setProgress("exam-".$exam->id."-topic-".$category->id."-progress-url",null);
    }
    private function fullMockExamHandle(){

        $user=User::find($this->review->user_id);
        $exam=Exam::find($this->review->exam_id);   
        $takentime=json_decode($user->progress("exam-review-".$this->review->id."-times",'[]'),true);
        $takentimereview=[];
        foreach (UserExamQuestion::where('user_exam_id',$this->userexam->id)->get() as $k=> $question) {
              
            $user_answer=$user->progress("exam-".$exam->id."-answer-of-".$question->slug,"");
            
            $revquestion=UserReviewQuestion::store([
                'title'=>$question->title, 
                'user_exam_review_id'=>$this->review->id,
                'review_type'=>'mcq',
                'note'=>$question->description, 
                'explanation'=>$question->explanation, 
                'currect_answer'=>'', 
                'user_answer'=>$user_answer,  
                'exam_id'=> $this->review->exam_id,
                'question_id'=> $question->question_id,
                'title_text'=> $question->title_text,
                'sub_question'=> $question->sub_question,
                'user_id'=>$this->review->user_id,
                'time_taken'=>$takentime[$question->slug]??0
            ]);
            $takentimereview[$revquestion->slug]=$takentime[$question->slug]??0;
            
            foreach($question->answers as $ans){
                UserReviewAnswer::store([
                    'user_exam_review_id'=>$this->review->id,
                    'user_review_question_id'=>$revquestion->id,
                    'title'=>$ans->title,
                    'iscorrect'=>$ans->iscorrect,
                    'user_answer'=>(($ans->slug==$user_answer)?true:false),
                    'exam_id'=> $this->review->exam_id,
                    'question_id'=> $question->id,
                    'answer_id'=> $ans->answer_id,
                    'user_id'=>$this->review->user_id,
                ]); 
            } 
            $user->setProgress("exam-".$exam->id."-answer-of-".$question->slug,null);
        }
        $user->setProgress("exam-reviewed-".$this->review->id."-times",json_encode($takentimereview));

        $user->setProgress("exam-".$exam->id."-complete-review",null);
        $user->setProgress("exam-".$exam->id."-progress-ids",null);
        $user->setProgress("exam-".$exam->id."-progress-url",null);
    }
}
